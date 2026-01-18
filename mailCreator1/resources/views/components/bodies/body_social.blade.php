@php
  $socialContent = $content['social_content'] ?? [];
  $socialIconSize = intval($content['social_icon_size'] ?? 40);
  $socialGap = intval($content['social_gap'] ?? 15);
  $socialBorderRadius = intval($content['social_border_radius'] ?? 50);
  $socialAlign = $content['social_align'] ?? 'center';
  
  // Filtrar solo redes habilitadas con URL
  $enabledNetworks = array_filter($socialContent, function($item) {
    return ($item['enabled'] ?? false) && !empty(trim($item['url'] ?? ''));
  });
  
  // Iconos monocromáticos de Icons8 (personalizables por color)
  $socialIconsImages = [
    'facebook' => 'https://img.icons8.com/material-outlined/100/facebook-new.png',
    'instagram' => 'https://img.icons8.com/material-outlined/100/instagram-new.png',
    'twitter' => 'https://img.icons8.com/material-outlined/100/twitter.png',
    'linkedin' => 'https://img.icons8.com/material-outlined/100/linkedin.png',
    'youtube' => 'https://img.icons8.com/material-outlined/100/youtube-play.png',
    'tiktok' => 'https://img.icons8.com/material-outlined/100/tiktok.png',
    'whatsapp' => 'https://img.icons8.com/material-outlined/100/whatsapp.png',
    'telegram' => 'https://img.icons8.com/material-outlined/100/telegram-app.png',
    'pinterest' => 'https://img.icons8.com/material-outlined/100/pinterest.png',
    'snapchat' => 'https://img.icons8.com/material-outlined/100/snapchat.png',
    'discord' => 'https://img.icons8.com/material-outlined/100/discord-logo.png',
    'twitch' => 'https://img.icons8.com/material-outlined/100/twitch.png',
    'reddit' => 'https://img.icons8.com/material-outlined/100/reddit.png',
    'github' => 'https://img.icons8.com/material-outlined/100/github.png',
    'website' => 'https://img.icons8.com/material-outlined/100/domain.png',
    'email' => 'https://img.icons8.com/material-outlined/100/email.png',
  ];
  
  $alignAttr = $socialAlign === 'left' ? 'left' : ($socialAlign === 'right' ? 'right' : 'center');
@endphp

@if(!empty($enabledNetworks))
<style>
  .social-container {
    width: 100%;
    max-width: 600px;
    margin: 15px auto;
    font-family: Arial, Helvetica, sans-serif;
  }
  .social-table {
    border-collapse: collapse;
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
  }
  .social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border-radius: {{ $socialBorderRadius }}px;
    mso-line-height-rule: exactly;
  }
  .social-icon img {
    display: block;
    border: 0;
  }
  
  @media only screen and (max-width: 600px) {
    .social-container {
      width: 100% !important;
      padding: 0 10px !important;
    }
    .social-table {
      width: 100% !important;
    }
    .social-icons-wrapper td {
      display: inline-block !important;
      padding: 5px !important;
    }
  }
</style>

<!--[if mso]>
<table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td align="{{ $alignAttr }}">
<![endif]-->

<div class="social-container">
  <table class="social-table" cellpadding="0" cellspacing="0" border="0" role="presentation" width="100%">
    <tr>
      <td align="{{ $alignAttr }}" style="padding: 10px 0;">
        <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="display:inline-block;" class="social-icons-wrapper">
          <tr>
            @foreach($enabledNetworks as $index => $item)
              @php
                $network = $item['network'] ?? '';
                $url = $item['url'] ?? '#';
                $bgColor = $item['bg_color'] ?? '#6c757d';
                $iconColor = $item['icon_color'] ?? '#ffffff';
                $borderColor = $item['border_color'] ?? '#000000';
                $borderWidth = intval($item['border_width'] ?? 0);
                
                $iconUrl = $socialIconsImages[$network] ?? $socialIconsImages['website'];
                // Icons8 permite cambiar color: /100/COLORHEX/
                $colorHex = ltrim($iconColor, '#');
                $iconUrl = str_replace('/100/', '/100/' . $colorHex . '/', $iconUrl);
                
                // Tamaño del icono (60% del contenedor para mejor centrado)
                $iconDisplaySize = round($socialIconSize * 0.6);
              @endphp
              
              <td align="center" valign="middle" style="padding: 0 {{ $socialGap/2 }}px;" class="social-icon-cell">
                <!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" 
                             xmlns:w="urn:schemas-microsoft-com:office:word" 
                             href="{{ $url }}"
                             style="height:{{ $socialIconSize }}px; width:{{ $socialIconSize }}px; v-text-anchor:middle;"
                             arcsize="{{ min(100, round(($socialBorderRadius / $socialIconSize) * 100)) }}%"
                             strokecolor="{{ $borderColor }}"
                             strokeweight="{{ $borderWidth }}px"
                             fillcolor="{{ $bgColor }}">
                  <w:anchorlock/>
                  <center>
                    <img src="{{ $iconUrl }}" width="{{ $iconDisplaySize }}" height="{{ $iconDisplaySize }}" alt="{{ ucfirst($network) }}" style="display:block; border:0;" />
                  </center>
                </v:roundrect>
                <![endif]-->
                
                <!--[if !mso]><!-->
                <a href="{{ $url }}" 
                   target="_blank" 
                   class="social-icon"
                   style="display:inline-flex;
                          align-items:center;
                          justify-content:center;
                          width:{{ $socialIconSize }}px;
                          height:{{ $socialIconSize }}px;
                          background-color:{{ $bgColor }};
                          border-radius:{{ $socialBorderRadius }}px;
                          border:{{ $borderWidth }}px solid {{ $borderColor }};
                          text-decoration:none;
                          box-sizing:border-box;">
                  <img src="{{ $iconUrl }}" 
                       width="{{ $iconDisplaySize }}" 
                       height="{{ $iconDisplaySize }}" 
                       alt="{{ ucfirst($network) }}" 
                       style="display:block; border:0;" />
                </a>
                <!--<![endif]-->
              </td>
            @endforeach
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>

<!--[if mso]>
</td></tr></table>
<![endif]-->
@else
<div style="text-align:center; padding:20px; color:#999; font-family:Arial,sans-serif;">
  No hay redes sociales configuradas
</div>
@endif