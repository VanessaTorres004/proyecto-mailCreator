@php
    // Acceder a la data
    $c = $content ?? [];
    
    // Si viene anidado, extraerlo
    if (isset($c[0]['content'])) {
        $c = $c[0]['content'];
    }

    // Mapear todas las posibles claves usando operador null coalescing
    $bannerBgColor = $c['banner_bg_color'] ?? $c['background_color'] ?? $c['bg_color'] ?? '#f8f9fa';
    $bannerWidth = $c['banner_width'] ?? $c['width'] ?? 600;
    $bannerHeight = $c['banner_height'] ?? $c['height'] ?? 300;
    $bannerBorderRadius = $c['banner_border_radius'] ?? $c['border_radius'] ?? 0;
    $bannerPadding = $c['banner_padding'] ?? $c['padding'] ?? 40;
    $bannerTextAlign = $c['banner_text_align'] ?? $c['text_align'] ?? 'center';
    
    // Link
    $bannerLinkEnabled = $c['banner_link_enabled'] ?? $c['link_enabled'] ?? false;
    $bannerLinkUrl = $c['banner_link_url'] ?? $c['link_url'] ?? '';
    
    // Gradiente
    $bannerGradientEnabled = $c['banner_gradient_enabled'] ?? $c['gradient_enabled'] ?? false;
    $bannerGradientColor1 = $c['banner_gradient_color_1'] ?? $c['gradient_color_1'] ?? $c['gradient_start'] ?? '#667eea';
    $bannerGradientColor2 = $c['banner_gradient_color_2'] ?? $c['gradient_color_2'] ?? $c['gradient_end'] ?? '#764ba2';
    $bannerGradientDirection = $c['banner_gradient_direction'] ?? $c['gradient_direction'] ?? 'to right';

    // Imagen de fondo
    $bannerBgImageEnabled = $c['banner_bg_image_enabled'] ?? $c['background_image_enabled'] ?? false;
    $bannerBgImage = $c['banner_bg_image'] ?? $c['background_image'] ?? '';
    
    // Icono
    $bannerIconEnabled = $c['banner_icon_enabled'] ?? $c['icon_enabled'] ?? false;
    $bannerIcon = $c['banner_icon'] ?? $c['icon'] ?? '';
    $bannerIconPosition = $c['banner_icon_position'] ?? $c['icon_position'] ?? 'top';
    $bannerIconSize = $c['banner_icon_size'] ?? $c['icon_size'] ?? 60;

    // Contenido de texto
    $bannerTitle = $c['banner_title'] ?? $c['title'] ?? 'Banner Title';
    $bannerSubtitle = $c['banner_subtitle'] ?? $c['subtitle'] ?? 'Banner Subtitle';
    
    // Colores de texto (con fallbacks mejorados)
    $bannerTitleColor = $c['banner_title_color'] ?? $c['title_color'] ?? '#ffffff';
    $bannerSubtitleColor = $c['banner_subtitle_color'] ?? $c['subtitle_color'] ?? '#ffffff';

    // Determinar el estilo de fondo (prioridad: imagen > gradiente > color sólido)
    $backgroundStyle = '';
    if ($bannerBgImageEnabled && !empty($bannerBgImage)) {
        $imageUrl = strpos($bannerBgImage, 'http') === 0 
            ? $bannerBgImage 
            : asset('storage/' . $bannerBgImage);
        $backgroundStyle = "background-image: url('{$imageUrl}'); background-size: cover; background-position: center; background-repeat: no-repeat;";
    } elseif ($bannerGradientEnabled) {
        $backgroundStyle = "background: linear-gradient({$bannerGradientDirection}, {$bannerGradientColor1}, {$bannerGradientColor2});";
    } else {
        $backgroundStyle = "background-color: {$bannerBgColor};";
    }
    
    // Alineación de tabla
    $tableAlign = $bannerTextAlign === 'left' ? 'left' : ($bannerTextAlign === 'right' ? 'right' : 'center');
    
    // Preparar textos (sin strip_tags para preservar formato básico)
    $bannerTitle = $bannerTitle ?: '';
    $bannerSubtitle = $bannerSubtitle ?: '';
@endphp

<style type="text/css">
    @media only screen and (max-width: 600px) {
        .banner-container {
            padding: 10px 0 !important;
        }
        .banner-main {
            width: 100% !important;
            max-width: 100% !important;
            border-radius: {{ max(0, $bannerBorderRadius - 2) }}px !important;
        }
        .banner-content {
            height: auto !important;
            min-height: 200px !important;
            padding: 20px !important;
        }
        .banner-icon-top {
            margin-bottom: 10px !important;
        }
        .banner-icon-img {
            width: 50px !important;
            height: 50px !important;
        }
        .banner-icon-lateral {
            padding: 0 10px !important;
        }
        .banner-title {
            font-size: 22px !important;
            margin: 0 0 8px 0 !important;
        }
        .banner-subtitle {
            font-size: 14px !important;
        }
        .banner-lateral-layout {
            display: block !important;
        }
        .banner-icon-cell-left,
        .banner-icon-cell-right {
            display: block !important;
            text-align: center !important;
            padding: 0 0 10px 0 !important;
        }
        .banner-text-cell {
            display: block !important;
            text-align: center !important;
        }
    }
</style>

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="banner-container" align="center" style="padding:20px 0;">
      @if($bannerLinkEnabled && !empty($bannerLinkUrl))
        <a href="{{ $bannerLinkUrl }}" style="text-decoration: none; display: block; max-width: {{ $bannerWidth }}px; width: 100%;">
      @endif
      
      <table role="presentation" class="banner-main" width="{{ $bannerWidth }}" cellspacing="0" cellpadding="0" border="0" 
             style="width:100%; max-width:{{ $bannerWidth }}px; border-radius:{{ $bannerBorderRadius }}px; overflow:hidden;">
        <tr>
          <td class="banner-content" style="{{ $backgroundStyle }} height:{{ $bannerHeight }}px; padding:{{ $bannerPadding }}px; vertical-align:middle;">
            
            {{-- ICONO ARRIBA --}}
            @if($bannerIconEnabled && !empty($bannerIcon) && $bannerIconPosition === 'top')
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="{{ $tableAlign }}" class="banner-icon-top" style="margin-bottom: 15px;">
                <tr>
                  <td>
                    @php
                        $iconUrl = strpos($bannerIcon, 'http') === 0 
                            ? $bannerIcon 
                            : asset('storage/' . $bannerIcon);
                    @endphp
                    <img src="{{ $iconUrl }}" 
                         alt="Icon" 
                         class="banner-icon-img"
                         width="{{ $bannerIconSize }}" 
                         height="{{ $bannerIconSize }}"
                         style="display:block; width:{{ $bannerIconSize }}px; height:{{ $bannerIconSize }}px; border:0;">
                  </td>
                </tr>
              </table>
            @endif
            
            {{-- CONTENEDOR CON ICONO LATERAL O SOLO TEXTO --}}
            @if($bannerIconEnabled && !empty($bannerIcon) && in_array($bannerIconPosition, ['left', 'right']))
              {{-- Con icono lateral --}}
              <table role="presentation" class="banner-lateral-layout" cellspacing="0" cellpadding="0" border="0" align="{{ $tableAlign }}">
                <tr>
                  @if($bannerIconPosition === 'left')
                    <td class="banner-icon-cell-left banner-icon-lateral" valign="middle" style="padding-right:20px;">
                      @php
                          $iconUrl = strpos($bannerIcon, 'http') === 0 
                              ? $bannerIcon 
                              : asset('storage/' . $bannerIcon);
                      @endphp
                      <img src="{{ $iconUrl }}" 
                           alt="Icon" 
                           class="banner-icon-img"
                           width="{{ $bannerIconSize }}" 
                           height="{{ $bannerIconSize }}"
                           style="display:block; width:{{ $bannerIconSize }}px; height:{{ $bannerIconSize }}px; border:0;">
                    </td>
                  @endif
                  
                  <td class="banner-text-cell" valign="middle" style="text-align:{{ $bannerTextAlign }};">
                    @if(!empty($bannerTitle))
                      <div class="banner-title" style="font-size:28px; font-weight:bold; line-height:1.3; margin:0 0 10px 0; color:{{ $bannerTitleColor }}; font-family:Arial, Helvetica, sans-serif; word-wrap:break-word; overflow-wrap:break-word;">
                        {!! $bannerTitle !!}
                      </div>
                    @endif

                    @if(!empty($bannerSubtitle))
                      <div class="banner-subtitle" style="font-size:16px; line-height:1.5; margin:0; color:{{ $bannerSubtitleColor }}; font-family:Arial, Helvetica, sans-serif; word-wrap:break-word; overflow-wrap:break-word;">
                        {!! $bannerSubtitle !!}
                      </div>
                    @endif
                  </td>
                  
                  @if($bannerIconPosition === 'right')
                    <td class="banner-icon-cell-right banner-icon-lateral" valign="middle" style="padding-left:20px;">
                      @php
                          $iconUrl = strpos($bannerIcon, 'http') === 0 
                              ? $bannerIcon 
                              : asset('storage/' . $bannerIcon);
                      @endphp
                      <img src="{{ $iconUrl }}" 
                           alt="Icon" 
                           class="banner-icon-img"
                           width="{{ $bannerIconSize }}" 
                           height="{{ $bannerIconSize }}"
                           style="display:block; width:{{ $bannerIconSize }}px; height:{{ $bannerIconSize }}px; border:0;">
                    </td>
                  @endif
                </tr>
              </table>
            @else
              {{-- Solo texto, sin icono lateral --}}
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <td style="text-align:{{ $bannerTextAlign }};">
                    @if(!empty($bannerTitle))
                      <div class="banner-title" style="font-size:28px; font-weight:bold; line-height:1.3; margin:0 0 10px 0; color:{{ $bannerTitleColor }}; font-family:Arial, Helvetica, sans-serif; word-wrap:break-word; overflow-wrap:break-word;">
                        {!! $bannerTitle !!}
                      </div>
                    @endif

                    @if(!empty($bannerSubtitle))
                      <div class="banner-subtitle" style="font-size:16px; line-height:1.5; margin:0; color:{{ $bannerSubtitleColor }}; font-family:Arial, Helvetica, sans-serif; word-wrap:break-word; overflow-wrap:break-word;">
                        {!! $bannerSubtitle !!}
                      </div>
                    @endif
                  </td>
                </tr>
              </table>
            @endif
            
          </td>
        </tr>
      </table>
      
      @if($bannerLinkEnabled && !empty($bannerLinkUrl))
        </a>
      @endif
    </td>
  </tr>
</table>