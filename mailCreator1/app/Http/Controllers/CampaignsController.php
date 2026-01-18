<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Campaigns;
use App\Models\Blocks;
use App\Models\User;
use App\Models\CampaignCollaborator;
use App\Models\Notification;
use App\Mail\CampaignAssignedMail;


class CampaignsController extends Controller
{
    // Helper method to check if user can access campaign
    private function canAccessCampaign($campaign, $userId)
{
    $user = User::findOrFail($userId);

    // Si es admin, puede acceder a todo
    if ($user->hasRole('admin')) {
        return true;
    }

    // Si es el propietario de la campaña
    if ($campaign->user_id == $userId) {
        return true;
    }

    // Si es colaborador
    if (CampaignCollaborator::where('campaign_id', $campaign->id)
           ->where('user_id', $userId)
           ->exists()) {
        return true;
    }

    return false;
}

       

    /**
     * Obtener permisos del usuario actual
     */
    private function getUserPermissions()
    {
        return RolePermissionsController::getUserPermissions();
    }

    /**
     * Aplicar restricciones basadas en permisos
     */
    private function applyPermissionRestrictions(&$data, $permissions)
    {
        // Forzar header si no tiene permiso
        if (!$permissions->can_use_custom_header) {
            $data['header_template'] = $permissions->forced_header;
        }

        // Forzar footer si no tiene permiso
        if (!$permissions->can_use_custom_footer) {
            $data['footer_template'] = $permissions->forced_footer;
        }

        // Forzar logo si no tiene permiso
        if (!$permissions->can_use_custom_logo) {
            $data['logo'] = $permissions->forced_logo;
        }

        // Forzar color de tema si no tiene permiso
        if (!$permissions->can_change_theme_color) {
            $data['color'] = $permissions->forced_theme_color;
        }

        // Forzar color de fondo si no tiene permiso
        if (!$permissions->can_change_background_color) {
            $data['background'] = $permissions->forced_background_color;
        }

        return $data;
    }
    

    // Listar campañas
    public function listCampaigns(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            // Admin ve todas las campañas
            $query = Campaigns::query();
        } elseif ($user->hasRole('facultades')) {
    // Facultades ve sus campañas y las campañas donde es colaborador
    $query = Campaigns::where(function($q) use ($user) {
        $q->where('user_id', $user->id)
          ->orWhereHas('collaborators', function($subQ) use ($user) {
              $subQ->where('user_id', $user->id);
          });
    });
} else {
            // Marketing y otros: campañas propias + colaboraciones
            $query = Campaigns::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereHas('collaborators', function($subQ) use ($user) {
                      $subQ->where('user_id', $user->id);
                  });
            });
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $campaigns = $query->orderBy('id', 'DESC')->paginate(10);

        return view('campaigns.list', [
            'request' => $request,
            'title' => 'Listado de Campañas',
            'campaigns' => $campaigns,
            'message' => 'Mira las campañas existentes y adminístralas',
            'class' => 'campaigns'
        ]);
    }

    // Crear campaña
    public function createCampaign(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $request->validate([
                    'title' => 'required|string|min:3',
                    'link' => 'nullable|url',
                    'color' => 'required|string|min:7',
                    'background' => 'required|string|min:7',
                ]);

                $data = $request->all();
                $data['menus'] = json_encode([]);

                // Obtener permisos del usuario
                $permissions = $this->getUserPermissions();

                // LOGO - MANEJO MEJORADO CON PERMISOS
                if ($permissions->can_use_custom_logo) {
                    // Usuario PUEDE usar logos personalizados
                    if ($request->logo_type === 'personalizado' && $request->hasFile('logo')) {
                        $file = $request->file('logo');
                        $logoName = date('YmdGis') . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '', $file->getClientOriginalName());
                        $file->storeAs('public/logos', $logoName);
                        $data['logo'] = $logoName;
                    } elseif (in_array($request->logo_type, ['blanco.png', 'rojo.png'])) {
                        $data['logo'] = $request->logo_type;
                    } else {
                        $data['logo'] = 'blanco.png';
                    }
                } else {
                    // Usuario NO puede usar logos personalizados - forzar el predeterminado
                    $data['logo'] = $permissions->forced_logo;
                }

                // Aplicar restricciones de permisos
                $data = $this->applyPermissionRestrictions($data, $permissions);

                // Guardar el user_id del creador
                $data['user_id'] = Auth::id();

                // REDES SOCIALES
                $data['facebook'] = $request->input('facebook', 'UDLAEcuador');
                $data['twitter'] = $request->input('twitter', 'UDLAEcuador');
                $data['linkedin'] = $request->input('linkedin', 'school/universidad-de-las-americas-ecuador/');
                $data['youtube'] = $request->input('youtube', 'user/UDLAUIO');
                $data['instagram'] = $request->input('instagram', 'udlaecuador/');
                $data['tiktok'] = $request->input('tiktok', '@udlaec/');

                // CAMPOS DE ENVÍO
                $data['envio'] = $request->has('envio') ? 1 : 0;
                $data['cuenta'] = $request->input('cuenta', '');
                $data['asunto'] = $request->input('asunto', '');
                $data['destino'] = $request->input('destino', '');

                // TEMPLATES - Aplicar restricciones
                $data['header_template'] = $permissions->can_use_custom_header 
                    ? $request->input('header_template', 'header0') 
                    : $permissions->forced_header;
                    
                $data['footer_template'] = $permissions->can_use_custom_footer 
                    ? $request->input('footer_template', 'footer0') 
                    : $permissions->forced_footer;

                unset($data['_token'], $data['logo_type']);

                $campaign = Campaigns::create($data);

                Session::flash('message', "La campaña se ha ingresado exitosamente");
                Session::flash('code', '200');
                return redirect('blocks/list/' . $campaign->id);

            } catch (\Exception $e) {
                Log::error('Error createCampaign', ['message' => $e->getMessage()]);
                Session::flash('message', "Se ha presentado un error: " . $e->getMessage());
                Session::flash('code', "400");
                return redirect()->back()->withInput();
            }
        }

        // OBTENER PERMISOS para la vista
        $permissions = $this->getUserPermissions();

        $campaign = new Campaigns();
        $campaign->menus = [['url' => '', 'nombre' => '']];
        
        // Aplicar valores según permisos
        $campaign->color = $permissions->can_change_theme_color ? '#3a57e8' : $permissions->forced_theme_color;
        $campaign->background = $permissions->can_change_background_color ? '#ffffff' : $permissions->forced_background_color;
        $campaign->logo = $permissions->can_use_custom_logo ? 'blanco.png' : $permissions->forced_logo;

        return view('campaigns.form', [
            'title' => 'Crear Campaña',
            'action' => url('campaigns/add'),
            'message' => 'Crea una nueva campaña en la aplicación',
            'campaign' => $campaign,
            'class' => 'campaigns',
            'permissions' => $permissions // PASAR PERMISOS A LA VISTA
        ]);
    }

    // Editar campaña
    public function editCampaign($id, Request $request)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Verificar permisos
        if (!$this->canAccessCampaign($campaign, Auth::id())) {
            Session::flash('message', 'No tienes permiso para editar esta campaña');
            Session::flash('code', '403');
            return redirect('campaigns/list');
        }

        // Obtener permisos del usuario
        $permissions = $this->getUserPermissions();

        if ($request->isMethod('post')) {
            try {
                $request->validate([
                    'title' => 'required|string|min:3',
                    'link' => 'nullable|url',
                    'color' => 'required|string|min:7',
                    'background' => 'required|string|min:7'
                ]);

                $campaign->title = $request->input('title');
                $campaign->link = $request->input('link');
                
                // Aplicar colores según permisos
                $campaign->color = $permissions->can_change_theme_color 
                    ? $request->input('color') 
                    : $permissions->forced_theme_color;
                    
                $campaign->background = $permissions->can_change_background_color 
                    ? $request->input('background') 
                    : $permissions->forced_background_color;

                // Redes sociales
                $campaign->facebook = $request->input('facebook', 'UDLAEcuador');
                $campaign->twitter = $request->input('twitter', 'UDLAEcuador');
                $campaign->linkedin = $request->input('linkedin', 'school/universidad-de-las-americas-ecuador/');
                $campaign->youtube = $request->input('youtube', 'user/UDLAUIO');
                $campaign->instagram = $request->input('instagram', 'udlaecuador/');
                $campaign->tiktok = $request->input('tiktok', '@udlaec/');

                // Headers y footers según permisos
                $campaign->header_template = $permissions->can_use_custom_header 
                    ? $request->input('header_template', 'header0') 
                    : $permissions->forced_header;
                    
                $campaign->footer_template = $permissions->can_use_custom_footer 
                    ? $request->input('footer_template', 'footer0') 
                    : $permissions->forced_footer;

                // MENÚS
                $menus = [];
                if ($request->has('menu_url')) {
                    foreach ($request->menu_url as $i => $url) {
                        $menus[] = ['url' => $url, 'nombre' => $request->menu_nombres[$i] ?? ''];
                    }
                }
                $campaign->menus = json_encode($menus);

                // LOGO según permisos
                if ($permissions->can_use_custom_logo) {
                    if ($request->logo_type === 'personalizado' && $request->hasFile('logo')) {
                        if ($campaign->logo && !in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
                            $oldLogoPath = public_path('storage/logos/' . $campaign->logo);
                            if (file_exists($oldLogoPath)) {
                                unlink($oldLogoPath);
                            }
                        }
                        
                        $file = $request->file('logo');
                        $logoName = date('YmdGis') . '_' . $file->getClientOriginalName();
                        $file->move(public_path('storage/logos'), $logoName);
                        $campaign->logo = $logoName;
                    } elseif (in_array($request->logo_type, ['blanco.png', 'rojo.png'])) {
                        if ($campaign->logo && !in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
                            $oldLogoPath = public_path('storage/logos/' . $campaign->logo);
                            if (file_exists($oldLogoPath)) {
                                unlink($oldLogoPath);
                            }
                        }
                        $campaign->logo = $request->logo_type;
                    }
                } else {
                    // Forzar logo predeterminado
                    $campaign->logo = $permissions->forced_logo;
                }

                // CAMPOS DE ENVÍO
                $campaign->envio = $request->has('envio') ? 1 : 0;
                $campaign->cuenta = $request->input('cuenta', '');
                $campaign->asunto = $request->input('asunto', '');
                $campaign->destino = $request->input('destino', '');

                $campaign->save();

                Session::flash('message', "La campaña se ha editado exitosamente");
                Session::flash('code', '200');
                return redirect('blocks/list/' . $campaign->id);

            } catch (\Exception $e) {
                Log::error('Error editCampaign', ['message' => $e->getMessage()]);
                Session::flash('message', "Se ha presentado un error: " . $e->getMessage());
                Session::flash('code', "400");
                return redirect()->back()->withInput();
            }
        }

        $campaign->menus = json_decode($campaign->menus, true) ?? [];

        return view('campaigns.form', [
            'title' => 'Editar Campaña: ' . $campaign->title,
            'action' => url('campaigns/edit/' . $campaign->id),
            'campaign' => $campaign,
            'message' => 'Edita una campaña de la aplicación',
            'permissions' => $permissions // PASAR PERMISOS A LA VISTA
        ]);
    }


    // Enviar campaña
    public function send(Request $request, $id)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Verificar permisos
        if (!$this->canAccessCampaign($campaign, Auth::id())) {
            Session::flash('message', 'No tienes permiso para enviar esta campaña');
            Session::flash('code', '403');
            return redirect('campaigns/list');
        }

        $campaign->envio = $request->has('envio') ? 1 : $campaign->envio;
        $campaign->cuenta = $request->input('cuenta', $campaign->cuenta);
        $campaign->asunto = $request->input('asunto', $campaign->asunto);
        $campaign->destino = $request->input('destino', $campaign->destino);
        $campaign->save();

        if ($campaign->envio != 1) {
            Session::flash('message', 'No se enviará el correo porque no está marcado el envío.');
            Session::flash('code', '400');
            return redirect()->back();
        }

        $toEmails = array_filter(array_map('trim', explode(';', $campaign->destino)));
        if (empty($toEmails)) {
            Session::flash('message', 'Debe ingresar al menos un correo destino.');
            Session::flash('code', '400');
            return redirect()->back();
        }

        $blocksDb = Blocks::where('campaign_id', $campaign->id)->orderBy('position')->get();

        $blocks = $blocksDb->map(function ($block) use ($campaign) {
            $contentArray = json_decode($block->content, true);

            if (!isset($contentArray[0]['type'])) {
                $contentArray = [['type' => $block->type, 'content' => $contentArray]];
            }

            $html = '';
            foreach ($contentArray as $subBlock) {
                $type = $subBlock['type'] ?? $block->type;
                $subContent = $subBlock['content'] ?? [];

                $bladeName = 'components.bodies.body_' . $type;
                if (view()->exists($bladeName)) {
                    $html .= view($bladeName, [
                        'content' => $subContent,
                        'campaign' => $campaign
                    ])->render();
                }
            }

            return ['html' => $html];
        });

        $replaceImages = function ($html, $message) {
            return preg_replace_callback('/src="([^"]+)"/', function ($matches) use ($message) {
                $fileName = basename(parse_url($matches[1], PHP_URL_PATH));

                $paths = [
                    storage_path('app/public/banners/' . $fileName),
                    storage_path('app/public/images/' . $fileName),
                    storage_path('app/public/icons/' . $fileName),
                    storage_path('app/public/logos/' . $fileName),
                    public_path('storage/logos/' . $fileName),
                    public_path('img/' . $fileName),
                ];

                foreach ($paths as $path) {
                    if (file_exists($path)) {
                        return 'src="' . $message->embed($path) . '"';
                    }
                }

                return $matches[0];
            }, $html);
        };

        try {
            foreach ($toEmails as $email) {
                Mail::send([], [], function ($message) use ($campaign, $email, $blocks, $replaceImages) {
                    $emailHtml = view('campaigns.correo', [
                        'campaign' => $campaign,
                        'blocks'   => $blocks
                    ])->render();

                    $emailHtml = $replaceImages($emailHtml, $message);

                    $message->to($email)
                            ->subject($campaign->asunto)
                            ->from($campaign->cuenta ?? config('mail.from.address'), config('mail.from.name'))
                            ->setBody($emailHtml, 'text/html');
                });
            }

            Session::flash('message', 'Los correos se han enviado correctamente.');
            Session::flash('code', '200');
        } catch (\Exception $e) {
            Log::error('Error enviando campaña: ' . $e->getMessage());
            Session::flash('message', 'Error al enviar los correos: ' . $e->getMessage());
            Session::flash('code', '400');
        }

        return redirect()->back();
    }

    // Eliminar campaña
    public function deleteCampaign($id)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Verificar permisos - solo el creador puede eliminar (o admin)
        $user = Auth::user();
        if (!$user->hasRole('admin') && $campaign->user_id !== $user->id) {
            Session::flash('message', 'No tienes permiso para eliminar esta campaña');
            Session::flash('code', '403');
            return redirect('campaigns/list');
        }
        
        if ($campaign->logo && !in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
            $logoPath = public_path('storage/logos/' . $campaign->logo);
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }
        
        $campaign->delete();
        Session::flash('message', "La campaña se ha eliminado exitosamente");
        Session::flash('code', '200');
        return redirect('campaigns/list');
    }

    // Copiar campaña
    public function copyCampaign($id)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Verificar permisos
        if (!$this->canAccessCampaign($campaign, Auth::id())) {
            Session::flash('message', 'No tienes permiso para copiar esta campaña');
            Session::flash('code', '403');
            return redirect('campaigns/list');
        }
        
        $blocks = Blocks::where('campaign_id', $campaign->id)->get();

        $newCampaign = $campaign->replicate();
        $newCampaign->title .= ' - Copia ' . date('Y-m-d G:i');
        // ⬅ La copia pertenece al usuario que la crea
        $newCampaign->user_id = Auth::id();
        $newCampaign->save();

        foreach ($blocks as $b) {
            $newBlock = $b->replicate();
            $newBlock->campaign_id = $newCampaign->id;
            $newBlock->save();
        }

        Session::flash('message', "La campaña se ha copiado exitosamente");
        Session::flash('code', '200');
        return redirect('campaigns/list');
    }

    // Previsualización de campaña
    public function viewCampaign($id)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Verificar permisos
        if (!$this->canAccessCampaign($campaign, Auth::id())) {
            Session::flash('message', 'No tienes permiso para ver esta campaña');
            Session::flash('code', '403');
            return redirect('campaigns/list');
        }

        $blocksDb = Blocks::where('campaign_id', $id)->orderBy('position')->get();

        $blocks = [];

        foreach ($blocksDb as $b) {
            $content = json_decode($b->content, true) ?? [];

            if (!isset($content[0]['type'])) {
                $content = [['type' => $b->type, 'content' => $content]];
            }

            $html = '';

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
                    $html .= "<div style='text-align:center;color:#888;'>Componente $bladeName no encontrado</div>";
                }
            }

            $blocks[] = ['html' => $html];
        }

        if (empty($blocks)) {
            $blocks[] = ['html' => '<p style="text-align:center;color:#888;">No hay bloques para mostrar</p>'];
        }

        return view('campaigns.preview', [
            'title' => $campaign->title,
            'campaign' => $campaign,
            'blocks' => $blocks
        ]);
    }

    public function downloadCampaign($id)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Verificar permisos
        if (!$this->canAccessCampaign($campaign, Auth::id())) {
            abort(403, 'No tienes permiso para descargar esta campaña');
        }
        
        $blocksDb = Blocks::where('campaign_id', $id)->orderBy('position')->get();

        $blocksHtml = '';
        foreach ($blocksDb as $block) {
            $contentArray = json_decode($block->content, true);

            if (!isset($contentArray[0]['type'])) {
                $contentArray = [['type' => $block->type, 'content' => $contentArray]];
            }

            foreach ($contentArray as $subBlock) {
                $type = $subBlock['type'] ?? $block->type;
                $subContent = $subBlock['content'] ?? [];

                if ($type === 'image' && !empty($subContent['image'])) {
                    $subContent['image'] = asset($subContent['image']);
                }

                if ($type === 'grid' && !empty($subContent['grid_content'])) {
                    foreach ($subContent['grid_content'] as &$cell) {
                        if (!empty($cell['image'])) {
                            $cell['image'] = asset($cell['image']);
                        }
                    }
                }

                $bladeName = 'components.bodies.body_' . $type;
                if (view()->exists($bladeName)) {
                    $blocksHtml .= view($bladeName, [
                        'content' => $subContent,
                        'campaign' => $campaign
                    ])->render();
                }
            }
        }

        $headerHtml = '';
        if (!empty($campaign->header_template) && 
            $campaign->header_template !== 'none' && 
            trim($campaign->header_template) !== '') {
            
            $headerView = 'components.headers.' . $campaign->header_template;
            if (view()->exists($headerView)) {
                $headerHtml = view($headerView, compact('campaign'))->render();
            }
        }

        $footerHtml = '';
        if (!empty($campaign->footer_template) && 
            $campaign->footer_template !== 'none' && 
            trim($campaign->footer_template) !== '') {
            
            $footerView = 'components.footers.' . $campaign->footer_template;
            if (view()->exists($footerView)) {
                $footerHtml = view($footerView, compact('campaign'))->render();
            }
        }

        $backgroundColor = $campaign->background ?? '#f4f4f4';
        $contentColor = $campaign->color ?? '#ffffff';

        $htmlContent = '<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<title>' . e($campaign->title) . '</title>

<!--[if mso]>
<noscript>
<xml>
<o:OfficeDocumentSettings>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
</noscript>
<![endif]-->

<style>
  body {
    margin:0 !important;
    padding:0 !important;
    width:100% !important;
    background-color:' . e($backgroundColor) . ';
    font-family: Arial, Helvetica, sans-serif;
  }

  table { border-collapse:collapse !important; }
  img { display:block; border:0; height:auto; line-height:100%; }

  .email-container {
    width:600px !important;
    max-width:600px !important;
    background-color:' . e($contentColor) . ';
    border-radius:8px;
  }

  .wrapper {
    width:100% !important;
    background-color:' . e($backgroundColor) . ';
  }

  @media only screen and (max-width:640px) {
    .email-container {
      width:100% !important;
      max-width:100% !important;
      border-radius:0 !important;
    }
  }
</style>
</head>

<body>
  <table role="presentation" class="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="max-width: 600px;">
    <tr>
      <td align="center" valign="top" style="padding:20px 0;">

        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
        <tr><td align="center" valign="top" width="600">
        <![endif]-->

        <table role="presentation" class="email-container" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td style="padding:0;">

              ' . (!empty($headerHtml) ? $headerHtml : '') . '
              ' . $blocksHtml . '
              ' . (!empty($footerHtml) ? $footerHtml : '') . '

            </td>
          </tr>
        </table>

        <!--[if (gte mso 9)|(IE)]>
        </td></tr></table>
        <![endif]-->

      </td>
    </tr>
  </table>
</body>
</html>';

        return response($htmlContent)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="campana_' . $campaign->id . '.html"');
    }

    /**
     * Show delegation form (Admin only)
     */
    public function showDelegateForm($id)
    {
        $campaign = Campaigns::findOrFail($id);
        
        // Solo el creador o admin pueden delegar
        if (!Auth::user()->hasRole('admin') && $campaign->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para delegar esta campaña');
        }

        $marketingUsers = User::role('marketing')->get();
        $facultadesUsers = User::role('facultades')->get();
        
        $existingCollaborators = CampaignCollaborator::where('campaign_id', $id)
            ->with(['user', 'assignedBy'])
            ->get();

        return view('campaigns.delegate', [
            'title' => 'Delegar Campaña: ' . $campaign->title,
            'campaign' => $campaign,
            'marketingUsers' => $marketingUsers,
            'facultadesUsers' => $facultadesUsers, 
            'existingCollaborators' => $existingCollaborators
        ]);
    }

   /**
 * Assign collaborator to campaign
 */
public function assignCollaborator(Request $request, $id)
{
    $request->validate([
        'marketing_user_id' => 'nullable|exists:users,id',
        'facultades_user_id' => 'nullable|exists:users,id',
        'deadline' => 'nullable|date',
        'notes' => 'nullable|string'
    ]);

    // Validación personalizada: al menos uno debe estar seleccionado
    if (empty($request->marketing_user_id) && empty($request->facultades_user_id)) {
        Session::flash('message', 'Debe seleccionar al menos un usuario (Marketing o Facultades)');
        Session::flash('code', '400');
        return redirect()->back()->withInput();
    }

    try {
        $campaign = Campaigns::findOrFail($id);

        // Solo el creador o admin puede asignar
        if (!Auth::user()->hasRole('admin') && $campaign->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para delegar esta campaña');
        }

        $assignedUsers = [];
        $assignedBy = Auth::user();
        
        // Asignar usuario de Marketing si fue seleccionado
        if (!empty($request->marketing_user_id)) {
            $marketingCollaboration = CampaignCollaborator::updateOrCreate(
                [
                    'campaign_id' => $id,
                    'user_id' => $request->marketing_user_id
                ],
                [
                    'assigned_by' => Auth::id(),
                    'status' => 'pending',
                    'deadline' => $request->deadline,
                    'notes' => $request->notes,
                ]
            );
            
            $marketingUser = User::find($request->marketing_user_id);
            $assignedUsers[] = [
                'user' => $marketingUser,
                'collaboration' => $marketingCollaboration
            ];
        }

        // Asignar usuario de Facultades si fue seleccionado
        if (!empty($request->facultades_user_id)) {
            $facultadesCollaboration = CampaignCollaborator::updateOrCreate(
                [
                    'campaign_id' => $id,
                    'user_id' => $request->facultades_user_id
                ],
                [
                    'assigned_by' => Auth::id(),
                    'status' => 'pending',
                    'deadline' => $request->deadline,
                    'notes' => $request->notes,
                ]
            );
            
            $facultadesUser = User::find($request->facultades_user_id);
            $assignedUsers[] = [
                'user' => $facultadesUser,
                'collaboration' => $facultadesCollaboration
            ];
        }

        // Enviar notificaciones y correos a cada usuario asignado
        foreach ($assignedUsers as $assigned) {
            $assignedUser = $assigned['user'];
            $collaboration = $assigned['collaboration'];
            
            // Crear notificación
            Notification::create([
                'user_id' => $assignedUser->id,
                'type' => 'campaign_assigned',
                'title' => 'Nueva campaña asignada',
                'message' => "Has sido asignado a la campaña '{$campaign->title}'.",
                'campaign_id' => $campaign->id,
                'collaboration_id' => $collaboration->id,
                'action_url' => url('my-collaborations'),
            ]);

            // Enviar correo
            try {
                Mail::to($assignedUser->email)
                    ->send(new CampaignAssignedMail($campaign, $collaboration, $assignedBy));
            } catch (\Exception $e) {
                Log::error('Error enviando correo de asignación', [
                    'error' => $e->getMessage(),
                    'user' => $assignedUser->email
                ]);
            }
        }

        $message = count($assignedUsers) > 1 
            ? 'Colaboradores asignados y notificados correctamente.' 
            : 'Colaborador asignado y notificado correctamente.';

        Session::flash('message', $message);
        Session::flash('code', '200');
        return redirect()->back();

    } catch (\Exception $e) {
        Log::error('Error al asignar colaborador', ['error' => $e->getMessage()]);
        Session::flash('message', 'Error al asignar el colaborador: ' . $e->getMessage());
        Session::flash('code', '400');
        return redirect()->back();
    }
}

    /**
     * Remove collaborator from campaign
     */
    public function removeCollaborator($campaignId, $collaboratorId)
    {
        $collaboration = CampaignCollaborator::findOrFail($collaboratorId);
        $campaign = Campaigns::findOrFail($campaignId);
        
        if ($collaboration->campaign_id != $campaignId) {
            abort(404, 'Colaboración no encontrada en esta campaña');
        }
        
        // Solo admin o creador pueden eliminar colaboradores
        if (!Auth::user()->hasRole('admin') && $campaign->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar este colaborador');
        }

        Notification::create([
            'user_id' => $collaboration->user_id,
            'type' => 'assignment',
            'title' => 'Colaboración Removida',
            'message' => 'Has sido removido de la campaña: ' . $campaign->title,
            'campaign_id' => $campaign->id,
            'action_url' => url('my-collaborations')
        ]);

        $collaboration->delete();

        Session::flash('message', 'Colaborador removido exitosamente');
        Session::flash('code', '200');
        
        return redirect()->back();
    }

    /**
     * Update collaboration status
     */
    public function updateCollaborationStatus(Request $request, $id)
    {
        $collaboration = CampaignCollaborator::findOrFail($id);
        $user = Auth::user();

        // Marketing puede actualizar sus propias colaboraciones
        if ($user->hasRole('marketing') && $collaboration->user_id !== $user->id) {
            abort(403, 'No tienes permiso para modificar esta colaboración');
        }

        // Admin puede actualizar cualquier colaboración
        if (!$user->hasRole('admin') && !$user->hasRole('marketing|facultades')) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,returned_for_review,needs_changes,completed',
            'admin_comments' => 'nullable|string'
        ]);

        $oldStatus = $collaboration->status;
        $collaboration->status = $request->status;
        
        if ($request->has('admin_comments')) {
            $collaboration->admin_comments = $request->admin_comments;
        }
        
        $collaboration->save();

        // CREAR NOTIFICACIONES SEGÚN EL CAMBIO DE ESTADO
        
        // Admin solicita cambios -> notificar al marketing
        if ($request->status === 'needs_changes') {
            Notification::create([
                'user_id' => $collaboration->user_id,
                'type' => 'status_change',
                'title' => 'Cambios Solicitados',
                'message' => 'El administrador solicita cambios en: ' . $collaboration->campaign->title,
                'campaign_id' => $collaboration->campaign_id,
                'collaboration_id' => $collaboration->id,
                'action_url' => url('my-collaborations')
            ]);
        }

        // Marketing completa la tarea -> notificar al admin
        if ($request->status === 'completed') {
            Notification::create([
                'user_id' => $collaboration->assigned_by,
                'type' => 'status_change',
                'title' => 'Colaboración Completada',
                'message' => $collaboration->user->name . ' completó: ' . $collaboration->campaign->title,
                'campaign_id' => $collaboration->campaign_id,
                'collaboration_id' => $collaboration->id,
                'action_url' => url('campaigns/delegate/' . $collaboration->campaign_id)
            ]);
        }

        // Marketing solicita revisión -> notificar al admin
        if ($request->status === 'returned_for_review') {
            Notification::create([
                'user_id' => $collaboration->assigned_by,
                'type' => 'status_change',
                'title' => 'Revisión Solicitada',
                'message' => $collaboration->user->name . ' solicita revisión de: ' . $collaboration->campaign->title,
                'campaign_id' => $collaboration->campaign_id,
                'collaboration_id' => $collaboration->id,
                'action_url' => url('campaigns/delegate/' . $collaboration->campaign_id)
            ]);
        }

        Session::flash('message', 'Estado actualizado exitosamente');
        Session::flash('code', '200');
        
        return redirect()->back();
    }

    /**
     * List collaborations for marketing users
     */
   public function myCollaborations()
{
    $user = Auth::user();
    
    // Ya no necesitas esta validación porque el middleware la hace
    // Pero si quieres dejarla por seguridad extra:
    if (!$user->hasAnyRole(['marketing', 'facultades', 'admin'])) {
        abort(403, 'Esta sección es solo para usuarios permitidos');
    }

    $collaborations = CampaignCollaborator::where('user_id', $user->id)
        ->with(['campaign', 'assignedBy'])
        ->orderBy('created_at', 'DESC')
        ->get();

    return view('campaigns.collaborations', [
        'title' => 'Mis Colaboraciones',
        'collaborations' => $collaborations
    ]);
}
}