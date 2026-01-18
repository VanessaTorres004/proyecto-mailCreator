<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Blocks;
use App\Models\Campaigns;
use App\Models\CampaignCollaborator; // AGREGAR IMPORT
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlocksController extends Controller
{
    public function __construct()
    {
        // Marketing y Admin pueden gestionar bloques
        $this->middleware('role:marketing|admin|facultades');
    }

    // Helper method to check if user can access campaign (AGREGAR ESTE MÉTODO)
    private function canAccessCampaign($campaign, $userId)
    {
        return $campaign->user_id == $userId || 
               CampaignCollaborator::where('campaign_id', $campaign->id)
                   ->where('user_id', $userId)
                   ->exists();
    }

    // Listar bloques
    public function listBlocks($id)
    {
        $campaign = Campaigns::findOrFail($id);
        $user = Auth::user();

        // REEMPLAZAR LA VERIFICACIÓN ANTIGUA CON ESTA:
        if (!$this->canAccessCampaign($campaign, $user->id) && !$user->hasRole('admin')) {
            abort(403, 'No tienes permiso para ver los bloques de esta campaña');
        }

        Session::put('campaign_id', $id);

        $blocks = Blocks::where('campaign_id', $id)
            ->orderBy('position')
            ->get();

        $blocksView = [];

        foreach ($blocks as $b) {
            $content = json_decode($b->content, true);
            if (!is_array($content)) $content = [];

            $html = '';

            if (!isset($content[0]['type'])) {
                $content = [
                    [
                        'type' => $b->type,
                        'content' => $content
                    ]
                ];
            }

            foreach ($content as $subBlock) {
                $type = $subBlock['type'] ?? $b->type;
                $subContent = $subBlock['content'] ?? [];

                $bladeName = 'body_' . $type;

                if (view()->exists('components.bodies.' . $bladeName)) {
                    $html .= view('components.bodies.' . $bladeName, [
                        'content' => $subContent,
                        'campaign' => $campaign
                    ])->render();
                } else {
                    $html .= "<div class='text-danger'>Componente $bladeName no encontrado</div>";
                }
            }

            $blocksView[] = ['block' => $b, 'html' => $html];
        }

        return view('blocks.view', [
            'title' => 'Previsualización',
            'blocks' => $blocksView,
            'campaign' => $campaign
        ]);
    }

    // Agregar bloque
    public function addBlock(Request $request)
    {
        $campaignId = session('campaign_id');
        $campaign = Campaigns::findOrFail($campaignId);
        $user = Auth::user();

        // REEMPLAZAR LA VERIFICACIÓN ANTIGUA CON ESTA:
        if (!$this->canAccessCampaign($campaign, $user->id) && !$user->hasRole('admin')) {
            abort(403, 'No tienes permiso para agregar bloques a esta campaña');
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'block_type' => 'required',
            ]);

            [$type, $template] = explode('_', $request->block_type);

            $defaultContent = [
                [
                    'type' => $type,
                    'content' => [
                        'template' => $template,
                        'title' => 'Título por defecto',
                        'bodyContent' => 'Contenido por defecto',
                        'ctaLink' => '#',
                    ]
                ]
            ];

           if ($type === 'grid_text' || $type === 'grid') {
            $defaultContent[0]['content']['grid_columns'] = 2;
            $defaultContent[0]['content']['grid_content'] = [
                [
                    'text' => '<p>Contenido del grid 1</p>',
                    'types' => ['text'],
                    'background_color' => '#ffffff',
                    'image' => null,
                    'button_text' => '',
                    'button_link' => '#'
                ],
                [
                    'text' => '<p>Contenido del grid 2</p>',
                    'types' => ['text'],
                    'background_color' => '#ffffff',
                    'image' => null,
                    'button_text' => '',
                    'button_link' => '#'
                ]
            ];
            $defaultContent[0]['content']['grid_gap'] = 10;
            $defaultContent[0]['content']['grid_row_gap'] = 8;
            $defaultContent[0]['content']['grid_border_radius'] = 0;
        }

            if ($type === 'message') {
                $defaultContent[0]['content']['text'] = 'Mensaje por defecto';
            }
            

            if ($type === 'button') {
                $defaultContent[0]['content']['text'] = 'Click aquí';
                $defaultContent[0]['content']['link'] = '#';
                $defaultContent[0]['content']['color'] = '#0d6efd';
            }

            if ($type === 'icono') {
                $defaultContent[0]['content'] = [
                    'icon_text_rows' => 2,
                    'icon_text_gap' => 15,
                    'icon_text_border_radius' => 0,
                    'icon_text_content' => [
                        [
                            'row_index' => 0,
                            'icon_position' => 'left',
                            'title' => 'Título 1',
                            'description' => 'Descripción del primer elemento',
                            'icon' => '',
                            'background_color' => '#ffffff',
                            'icon_size' => 60,
                            'icon_border_color' => '#000000',
                            'icon_border_width' => 0,
                            'icon_border_radius' => 0
                        ],
                        [
                            'row_index' => 1,
                            'icon_position' => 'left',
                            'title' => 'Título 2',
                            'description' => 'Descripción del segundo elemento',
                            'icon' => '',
                            'background_color' => '#ffffff',
                            'icon_size' => 60,
                            'icon_border_color' => '#000000',
                            'icon_border_width' => 0,
                            'icon_border_radius' => 0
                        ]
                    ]
                ];
            }

            if ($type === 'banner') {
                $defaultContent[0]['content'] = [
                    'height' => 200,
                    'background_type' => 'color',
                    'background_color' => '#7c7c7cff',
                    'background_image' => '',
                    'gradient_start' => '#007bff',
                    'gradient_end' => '#6f42c1',
                    'gradient_direction' => 'to right',
                    'overlay_enabled' => false,
                    'overlay_color' => '#000000',
                    'overlay_opacity' => 50,
                    'overlay_pattern' => 'none',
                    'title' => 'Banner Title',
                    'subtitle' => 'Banner Subtitle',
                    'title_color' => '#ffffff1f',
                    'subtitle_color' => '#000000ff',
                    'title_size' => 32,
                    'subtitle_size' => 18,
                    'text_align' => 'center',
                    'vertical_align' => 'center'
                ];
            }
            if ($type === 'instructivo') {
                $defaultContent[0]['content'] = [
                    'instructivo_title' => 'Información del programa',
                    'instructivo_title_color' => '#c41e3a',
                    'instructivo_items_count' => 3,
                    'instructivo_items' => [
                        ['label' => '', 'content' => '', 'bg_color' => '#f5f5f5'],
                        ['label' => '', 'content' => '', 'bg_color' => '#f5f5f5'],
                        ['label' => '', 'content' => '', 'bg_color' => '#f5f5f5']
                    ],
                    'instructivo_extra_message' => '',
                    'instructivo_show_buttons' => 0,
                    'instructivo_buttons_count' => 2,
                    'instructivo_buttons' => []
                ];
            }

            Blocks::create([
                'campaign_id' => $campaignId,
                'type' => $type,
                'content' => json_encode($defaultContent),
                'position' => Blocks::where('campaign_id', $campaignId)->max('position') + 1,
            ]);

            return redirect()->route('blocks.list', ['id' => $campaignId])
                ->with('success', 'Bloque agregado correctamente');
        }

        return view('blocks.create', ['campaign_id' => $campaignId]);
    }

    // Editar bloque
    public function editBlock($id, Request $request)
    {
        $block = Blocks::findOrFail($id);
        $campaign = Campaigns::find($block->campaign_id);
        $user = Auth::user();

        // REEMPLAZAR LA VERIFICACIÓN ANTIGUA CON ESTA:
        if (!$this->canAccessCampaign($campaign, $user->id) && !$user->hasRole('admin')) {
            abort(403, 'No tienes permiso para editar este bloque');
        }

        $content = json_decode($block->content, true);

        if (!is_array($content)) $content = [];

        if (!isset($content[0]['type'])) {
            $content = [
                [
                    'type' => $block->type,
                    'content' => $content
                ]
            ];
        }

        if ($request->isMethod('post')) {

            $subBlockContent = $content[0]['content'];
// BLOQUES DE TEXTO (title, subtitle, message)
            foreach(['title','subtitle','message'] as $type) {
                if ($request->has($type)) {
                    // Contenido
                    $subBlockContent[$type] = $request->input($type);
                    
                    // Estilos específicos para cada tipo
                    $subBlockContent[$type.'_color'] = $request->input($type.'_color', '#333333');
                    $subBlockContent[$type.'_bgcolor'] = $request->input($type.'_bgcolor', 'transparent');
                    $subBlockContent[$type.'_size'] = $request->input($type.'_size', '16px');
                    $subBlockContent[$type.'_align'] = $request->input($type.'_align', 'left');
                    $subBlockContent[$type.'_bold'] = $request->input($type.'_bold', 'normal');
                    $subBlockContent[$type.'_italic'] = $request->input($type.'_italic', 'normal');
                    $subBlockContent[$type.'_underline'] = $request->input($type.'_underline', 'none');
                }
            }

            // BOTÓN
if ($block->type === 'button') {
    $subBlockContent['button_text'] = $request->input('button_text', $subBlockContent['button_text'] ?? 'Click aquí');
    $subBlockContent['button_link'] = $request->input('button_link', $subBlockContent['button_link'] ?? '#');
    $subBlockContent['button_color'] = $request->input('button_color', $subBlockContent['button_color'] ?? '#0d6efd');
    $subBlockContent['button_text_color'] = $request->input('button_text_color', $subBlockContent['button_text_color'] ?? '#ffffff');
    $subBlockContent['button_font_size'] = $request->input('button_font_size', $subBlockContent['button_font_size'] ?? 16);
    $subBlockContent['button_border_radius'] = $request->input('button_border_radius', $subBlockContent['button_border_radius'] ?? 4);
    $subBlockContent['button_bold'] = $request->boolean('button_bold', $subBlockContent['button_bold'] ?? false);
    $subBlockContent['button_italic'] = $request->boolean('button_italic', $subBlockContent['button_italic'] ?? false);
    $subBlockContent['button_underline'] = $request->boolean('button_underline', $subBlockContent['button_underline'] ?? false);
    $subBlockContent['button_border_enabled'] = $request->boolean('button_border_enabled', $subBlockContent['button_border_enabled'] ?? false);
    $subBlockContent['button_border_width'] = $request->input('button_border_width', $subBlockContent['button_border_width'] ?? 0);
    $subBlockContent['button_border_color'] = $request->input('button_border_color', $subBlockContent['button_border_color'] ?? '#000000');
    $subBlockContent['button_border_style'] = $request->input('button_border_style', $subBlockContent['button_border_style'] ?? 'solid');
}

            // LOGO
            if ($request->has('logo_variant')) $subBlockContent['logo_variant'] = $request->input('logo_variant');
            if ($request->has('logo_width')) $subBlockContent['logo_width'] = $request->input('logo_width');
            if ($request->has('logo_align')) $subBlockContent['logo_align'] = $request->input('logo_align');

            if ($request->hasFile('logo_file')) {
                $subBlockContent['logo'] = $request->file('logo_file')->store('logos', 'public');
            }

            // --- IMAGEN ---
            if ($request->has('image_width')) $subBlockContent['image_width'] = $request->input('image_width');
            if ($request->has('image_height')) $subBlockContent['image_height'] = $request->input('image_height');
            if ($request->has('image_align')) $subBlockContent['image_align'] = $request->input('image_align');
            if ($request->has('image_border_color')) $subBlockContent['image_border_color'] = $request->input('image_border_color');
            if ($request->has('image_border_width')) $subBlockContent['image_border_width'] = $request->input('image_border_width');
            if ($request->has('image_border_radius')) $subBlockContent['image_border_radius'] = $request->input('image_border_radius');

            if ($request->hasFile('image_file')) {
                $path = $request->file('image_file')->store('images', 'public');
                $subBlockContent['image'] = 'storage/' . $path;
            } else {
                $subBlockContent['image'] = $subBlockContent['image'] ?? null;
            }

           // --- GRID ---
if ($block->type === 'grid') {
    $columns = $request->input('grid_columns', $subBlockContent['grid_columns'] ?? 2);
    $gridContent = $request->input('grid_content', $subBlockContent['grid_content'] ?? []);

    for ($i = 0; $i < 3; $i++) {
        // Manejar imagen
        if ($request->hasFile("grid_content.$i.image")) {
            $path = $request->file("grid_content.$i.image")->store('images', 'public');
            $gridContent[$i]['image'] = 'storage/' . $path;
        } else {
            $gridContent[$i]['image'] = $subBlockContent['grid_content'][$i]['image'] ?? null;
        }

        // Guardar todos los campos de texto
        $gridContent[$i]['text'] = $request->input("grid_content.$i.text", '');
        $gridContent[$i]['types'] = $request->input("grid_content.$i.types", ['text']);
        $gridContent[$i]['background_color'] = $request->input("grid_content.$i.background_color", '#ffffff');

        // Campos de imagen
        $gridContent[$i]['image_width'] = $request->input("grid_content.$i.image_width", 200);
        $gridContent[$i]['image_height'] = $request->input("grid_content.$i.image_height", '');
        $gridContent[$i]['image_align'] = $request->input("grid_content.$i.image_align", 'center');
        $gridContent[$i]['image_border_color'] = $request->input("grid_content.$i.image_border_color", '#000000');
        $gridContent[$i]['image_border_width'] = $request->input("grid_content.$i.image_border_width", 0);
        $gridContent[$i]['image_border_radius'] = $request->input("grid_content.$i.image_border_radius", 0);

        // Campos de botón
        $gridContent[$i]['button_text'] = $request->input("grid_content.$i.button_text", '');
        $gridContent[$i]['button_link'] = $request->input("grid_content.$i.button_link", '#');
        $gridContent[$i]['button_align'] = $request->input("grid_content.$i.button_align", 'center');
        $gridContent[$i]['button_bg_color'] = $request->input("grid_content.$i.button_bg_color", '#0d6efd');
        $gridContent[$i]['button_text_color'] = $request->input("grid_content.$i.button_text_color", '#ffffff');
        $gridContent[$i]['button_font_size'] = $request->input("grid_content.$i.button_font_size", 16);
        $gridContent[$i]['button_border_radius'] = $request->input("grid_content.$i.button_border_radius", 4);
        
        // NUEVOS CAMPOS DE BORDE DE BOTÓN
        $gridContent[$i]['button_border_color'] = $request->input("grid_content.$i.button_border_color", '#000000');
        $gridContent[$i]['button_border_width'] = $request->input("grid_content.$i.button_border_width", 0);
        
        $gridContent[$i]['button_bold'] = $request->has("grid_content.$i.button_bold");
        $gridContent[$i]['button_italic'] = $request->has("grid_content.$i.button_italic");
        $gridContent[$i]['button_underline'] = $request->has("grid_content.$i.button_underline");
    }

    $subBlockContent['grid_columns'] = $columns;
    $subBlockContent['grid_content'] = $gridContent;

    if ($request->has('grid_gap')) $subBlockContent['grid_gap'] = $request->input('grid_gap');
    if ($request->has('grid_border_radius')) $subBlockContent['grid_border_radius'] = $request->input('grid_border_radius');
}

// --- ICONO (actualizado con layout) ---
if ($block->type === 'icono') {
    $subBlockContent['icon_text_rows'] = $request->input('icon_text_rows', $subBlockContent['icon_text_rows'] ?? 2);
    $subBlockContent['icon_text_gap'] = $request->input('icon_text_gap', $subBlockContent['icon_text_gap'] ?? 15);
    $subBlockContent['icon_text_border_radius'] = $request->input('icon_text_border_radius', $subBlockContent['icon_text_border_radius'] ?? 0);
    $subBlockContent['icon_text_layout'] = $request->input('icon_text_layout', $subBlockContent['icon_text_layout'] ?? 'vertical');

    $iconTextContent = $request->input('icon_text_content', $subBlockContent['icon_text_content'] ?? []);
    $iconTextRows = intval($subBlockContent['icon_text_rows']);

    for ($i = 0; $i < $iconTextRows; $i++) {
        if ($request->hasFile("icon_text_content.$i.icon")) {
            $path = $request->file("icon_text_content.$i.icon")->store('icons', 'public');
            $iconTextContent[$i]['icon'] = $path;
        } else {
            $iconTextContent[$i]['icon'] = $iconTextContent[$i]['icon'] ?? '';
        }

        $iconTextContent[$i]['row_index'] = $i;
        $iconTextContent[$i]['icon_position'] = $request->input("icon_text_content.$i.icon_position", $iconTextContent[$i]['icon_position'] ?? 'left');
        $iconTextContent[$i]['title'] = $request->input("icon_text_content.$i.title", $iconTextContent[$i]['title'] ?? '');
        $iconTextContent[$i]['description'] = $request->input("icon_text_content.$i.description", $iconTextContent[$i]['description'] ?? '');
        $iconTextContent[$i]['background_color'] = $request->input("icon_text_content.$i.background_color", $iconTextContent[$i]['background_color'] ?? '#ffffff');
        $iconTextContent[$i]['icon_size'] = $request->input("icon_text_content.$i.icon_size", $iconTextContent[$i]['icon_size'] ?? 60);
        $iconTextContent[$i]['icon_border_color'] = $request->input("icon_text_content.$i.icon_border_color", $iconTextContent[$i]['icon_border_color'] ?? '#000000');
        $iconTextContent[$i]['icon_border_width'] = $request->input("icon_text_content.$i.icon_border_width", $iconTextContent[$i]['icon_border_width'] ?? 0);
        $iconTextContent[$i]['icon_border_radius'] = $request->input("icon_text_content.$i.icon_border_radius", $iconTextContent[$i]['icon_border_radius'] ?? 0);
    }

    $subBlockContent['icon_text_content'] = $iconTextContent;
}
// --- SOCIAL MEDIA ---
if ($block->type === 'social') {
    // Redes sociales disponibles
    $networks = [
        'facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 
        'tiktok', 'whatsapp', 'telegram', 'pinterest', 'snapchat',
        'discord', 'twitch', 'reddit', 'github', 'website', 'email'
    ];
    
    $processedContent = [];
    
    foreach ($networks as $network) {
        // Verificar si existe la data para esta red
        $networkData = $request->input("social_content.$network", []);
        
        // Solo agregar si está habilitado O si tiene datos previos
        $isEnabled = $request->has("social_content.$network.enabled");
        
        $processedContent[] = [
            'network' => $network,
            'enabled' => $isEnabled,
            'url' => $request->input("social_content.$network.url", ''),
            'bg_color' => $request->input("social_content.$network.bg_color", '#6c757d'),
            'icon_color' => $request->input("social_content.$network.icon_color", '#ffffff'),
            'border_color' => $request->input("social_content.$network.border_color", '#000000'),
            'border_width' => $request->input("social_content.$network.border_width", 0)
        ];
    }
    
    $subBlockContent['social_content'] = $processedContent;
    
    // Configuración general
    $subBlockContent['social_icon_size'] = $request->input('social_icon_size', 40);
    $subBlockContent['social_gap'] = $request->input('social_gap', 15);
    $subBlockContent['social_border_radius'] = $request->input('social_border_radius', 50);
    $subBlockContent['social_align'] = $request->input('social_align', 'center');
}


// --- BANNER SIMPLIFICADO ---
if ($block->type === 'banner') {
    // Configuración básica
    $subBlockContent['banner_bg_color'] = $request->input('banner_bg_color', $subBlockContent['banner_bg_color'] ?? '#f8f9fa');
    $subBlockContent['banner_width'] = $request->input('banner_width', $subBlockContent['banner_width'] ?? 600);
    $subBlockContent['banner_height'] = $request->input('banner_height', $subBlockContent['banner_height'] ?? 300);
    $subBlockContent['banner_border_radius'] = $request->input('banner_border_radius', $subBlockContent['banner_border_radius'] ?? 0);
    $subBlockContent['banner_padding'] = $request->input('banner_padding', $subBlockContent['banner_padding'] ?? 40);
    $subBlockContent['banner_text_align'] = $request->input('banner_text_align', $subBlockContent['banner_text_align'] ?? 'center');
    
    // Link del banner
    $subBlockContent['banner_link_enabled'] = $request->boolean('banner_link_enabled', $subBlockContent['banner_link_enabled'] ?? false);
    $subBlockContent['banner_link_url'] = $request->input('banner_link_url', $subBlockContent['banner_link_url'] ?? '');
    
    // Gradiente
    $subBlockContent['banner_gradient_enabled'] = $request->boolean('banner_gradient_enabled', $subBlockContent['banner_gradient_enabled'] ?? false);
    $subBlockContent['banner_gradient_color_1'] = $request->input('banner_gradient_color_1', $subBlockContent['banner_gradient_color_1'] ?? '#667eea');
    $subBlockContent['banner_gradient_color_2'] = $request->input('banner_gradient_color_2', $subBlockContent['banner_gradient_color_2'] ?? '#764ba2');
    $subBlockContent['banner_gradient_direction'] = $request->input('banner_gradient_direction', $subBlockContent['banner_gradient_direction'] ?? 'to right');
    
    // Imagen de fondo (cubre todo el banner)
    $subBlockContent['banner_bg_image_enabled'] = $request->boolean('banner_bg_image_enabled', $subBlockContent['banner_bg_image_enabled'] ?? false);
    
    if ($request->hasFile('banner_bg_image')) {
        // Eliminar imagen anterior si existe
        if (!empty($subBlockContent['banner_bg_image'])) {
            Storage::disk('public')->delete($subBlockContent['banner_bg_image']);
        }
        $subBlockContent['banner_bg_image'] = $request->file('banner_bg_image')->store('banners', 'public');
    } else {
        $subBlockContent['banner_bg_image'] = $subBlockContent['banner_bg_image'] ?? '';
    }
    
    // Icono decorativo
    $subBlockContent['banner_icon_enabled'] = $request->boolean('banner_icon_enabled', $subBlockContent['banner_icon_enabled'] ?? false);
    $subBlockContent['banner_icon_position'] = $request->input('banner_icon_position', $subBlockContent['banner_icon_position'] ?? 'top');
    $subBlockContent['banner_icon_size'] = $request->input('banner_icon_size', $subBlockContent['banner_icon_size'] ?? 60);
    
    if ($request->hasFile('banner_icon')) {
        // Eliminar icono anterior si existe
        if (!empty($subBlockContent['banner_icon'])) {
            Storage::disk('public')->delete($subBlockContent['banner_icon']);
        }
        $subBlockContent['banner_icon'] = $request->file('banner_icon')->store('icons', 'public');
    } else {
        $subBlockContent['banner_icon'] = $subBlockContent['banner_icon'] ?? '';
    }
    
    // Contenido de texto
    $subBlockContent['banner_title'] = $request->input('banner_title', $subBlockContent['banner_title'] ?? '');
    $subBlockContent['banner_subtitle'] = $request->input('banner_subtitle', $subBlockContent['banner_subtitle'] ?? '');
    $subBlockContent['banner_title_color'] = $request->input('banner_title_color', $subBlockContent['banner_title_color'] ?? '#ffffff');
    $subBlockContent['banner_subtitle_color'] = $request->input('banner_subtitle_color', $subBlockContent['banner_subtitle_color'] ?? '#ffffff');
}
// --- INSTRUCTIVO ---
if ($block->type === 'instructivo') {
    // Title
    $subBlockContent['instructivo_title'] = $request->input('instructivo_title', '');
    $subBlockContent['instructivo_title_color'] = $request->input('instructivo_title_color', '#c41e3a');
    
    // General background color
    $subBlockContent['instructivo_general_bg_color'] = $request->input('instructivo_general_bg_color', '#ffffff');
    
    // Items configuration
    $subBlockContent['instructivo_items_count'] = $request->input('instructivo_items_count', 3);
    
    // Items data
    $instructivoItems = $request->input('instructivo_items', []);
    $subBlockContent['instructivo_items'] = [];
    
    foreach ($instructivoItems as $index => $item) {
        $subBlockContent['instructivo_items'][$index] = [
            'label' => $item['label'] ?? '',
            'content' => $item['content'] ?? '',
            'bg_color' => $item['bg_color'] ?? '#f5f5f5'
        ];
    }
    
    // Extra message
    $subBlockContent['instructivo_extra_message'] = $request->input('instructivo_extra_message', '');
    
    // Buttons configuration
    $subBlockContent['instructivo_show_buttons'] = $request->has('instructivo_show_buttons') ? 1 : 0;
    $subBlockContent['instructivo_buttons_count'] = $request->input('instructivo_buttons_count', 2);
    
    // Buttons data
    $instructivoButtons = $request->input('instructivo_buttons', []);
    $subBlockContent['instructivo_buttons'] = [];
    
    foreach ($instructivoButtons as $index => $button) {
        $subBlockContent['instructivo_buttons'][$index] = [
            'text' => $button['text'] ?? '',
            'url' => $button['url'] ?? '',
            'style' => $button['style'] ?? 'solid',
            'bg_color' => $button['bg_color'] ?? '#c41e3a',
            'text_color' => $button['text_color'] ?? '#ffffff',
            'border_color' => $button['border_color'] ?? '#c41e3a'
        ];
    }
}

            $content[0]['content'] = $subBlockContent;

            $block->content = json_encode($content);
            $block->position = $request->input('position') ?? $block->position;
            $block->save();

            return redirect()->route('blocks.list', $campaign->id)
                ->with('success', 'Bloque editado correctamente');
        }

        return view('blocks.edit', [
            'title' => 'Editar bloque',
            'block' => $block,
            'content' => $content,
            'campaign' => $campaign,
        ]);
    }

    // Eliminar bloque
    public function deleteBlock($id)
    {
        $block = Blocks::findOrFail($id);
        $campaign = Campaigns::find($block->campaign_id);
        $user = Auth::user();

        // REEMPLAZAR LA VERIFICACIÓN ANTIGUA CON ESTA:
        if (!$this->canAccessCampaign($campaign, $user->id) && !$user->hasRole('admin')) {
            abort(403, 'No tienes permiso para eliminar este bloque');
        }

        $campaignId = $block->campaign_id;
        $block->delete();
        
        return redirect()->route('blocks.list', $campaignId)
            ->with('success', 'Bloque eliminado correctamente');
    }

    public function reorder(Request $request)
    {
        try {
            $order = $request->input('order');
            $campaignId = $request->input('campaign_id');
            
            if (!$order || !$campaignId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos incompletos'
                ], 400);
            }

            $campaign = Campaigns::findOrFail($campaignId);
            $user = Auth::user();

            // REEMPLAZAR LA VERIFICACIÓN ANTIGUA CON ESTA:
            if (!$this->canAccessCampaign($campaign, $user->id) && !$user->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permiso para reordenar estos bloques'
                ], 403);
            }
            
            foreach ($order as $item) {
                Blocks::where('id', $item['id'])
                    ->where('campaign_id', $campaignId)
                    ->update(['position' => $item['position']]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Orden actualizado correctamente'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error al reordenar bloques: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el orden'
            ], 500);
        }
    }

    public function imageUpload(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('images', 'public');
                return response()->json([
                    'success' => true,
                    'path' => 'storage/' . $path
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No se recibió ninguna imagen'
            ], 400);
            
        } catch (\Exception $e) {
            Log::error('Error al subir imagen: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen'
            ], 500);
        }
    }
}