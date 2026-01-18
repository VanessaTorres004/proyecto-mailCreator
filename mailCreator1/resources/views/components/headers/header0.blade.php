@php 
  $mainColor = $campaign->color ?? '#4a90e2';
  $linkColor = '#ffffff';
@endphp

<!-- HEADER COMPLETO A ANCHO TOTAL -->
<tr>
  <td align="center" valign="top" style="padding:0;">

    <!-- Wrapper full-width -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="{{ $mainColor }}">
      <tr>
        <td align="center" style="padding:0;">

          <!-- Contenido centrado a 600px -->
          <table width="600" border="0" cellspacing="0" cellpadding="0"
                 class="header-inner"
                 style="max-width:600px; width:100%; margin:0 auto; background-color:{{ $mainColor }}; border-radius:8px;">
            <tr>
              <!-- TÍTULO -->
              <td class="header-left" align="left" valign="middle" style="font-family: Arial, sans-serif; padding: 10px;">
                <a href="{{ $campaign->link }}" class="header-title"
                style="color:{{ $linkColor }}; text-decoration:none; font-size:18px; font-weight:bold;">
                {{ $campaign->title }}
                <span class="arrow-icon">➜</span>
              </a>
              </td>

              <!-- ÍCONOS -->
              <td class="header-right" align="right" valign="middle" style="padding:10px;">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    @if ($campaign->facebook)
                      <td style="padding-left:6px;">
                        <a href="https://www.facebook.com/{{ $campaign->facebook }}" target="_blank">
                          <img src="{{ asset('img/icon-facebook.png') }}" width="28" alt="Facebook" class="social-icon" style="display:block; border:0;">
                        </a>
                      </td>
                    @endif
                    @if ($campaign->twitter)
                      <td style="padding-left:6px;">
                        <a href="https://twitter.com/{{ $campaign->twitter }}" target="_blank">
                          <img src="{{ asset('img/icon-twitter.png') }}" width="28" alt="Twitter" class="social-icon" style="display:block; border:0;">
                        </a>
                      </td>
                    @endif
                    @if ($campaign->youtube)
                      <td style="padding-left:6px;">
                        <a href="https://youtube.com/{{ $campaign->youtube }}" target="_blank">
                          <img src="{{ asset('img/icon-youtube.png') }}" width="28" alt="YouTube" class="social-icon" style="display:block; border:0;">
                        </a>
                      </td>
                    @endif
                    @if ($campaign->linkedin)
                      <td style="padding-left:6px;">
                        <a href="https://www.linkedin.com/{{ $campaign->linkedin }}" target="_blank">
                          <img src="{{ asset('img/icon-linkedIn.png') }}" width="28" alt="LinkedIn" class="social-icon" style="display:block; border:0;">
                        </a>
                      </td>
                    @endif
                    @if ($campaign->instagram)
                      <td style="padding-left:6px;">
                        <a href="https://www.instagram.com/{{ $campaign->instagram }}" target="_blank">
                          <img src="{{ asset('img/icon-instagram.png') }}" width="28" alt="Instagram" class="social-icon" style="display:block; border:0;">
                        </a>
                      </td>
                    @endif
                    @if ($campaign->tiktok)
                      <td style="padding-left:6px;">
                        <a href="https://www.tiktok.com/{{ $campaign->tiktok }}" target="_blank">
                          <img src="{{ asset('img/icon-tiktok.png') }}" width="28" alt="TikTok" class="social-icon" style="display:block; border:0;">
                        </a>
                      </td>
                    @endif
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <!-- /Contenido 600px -->

        </td>
      </tr>
    </table>
    <!-- /Wrapper full-width -->

  </td>
</tr>

<!-- Responsive -->
<style>
 @media only screen and (max-width: 480px) {
  .header-inner {
    width: 100% !important;
    padding: 0 10px !important;
  }
  .header-left, .header-right {
    display: block !important;
    width: 100% !important;
    text-align: center !important;
    padding: 6px 0 !important;
  }
  .header-title {
    font-size: 15px !important; /* Ajuste suave */
    display: inline-block !important;
  }
  .arrow-icon {
    width: 8px !important;
    margin-left: 3px !important; /* Menos espacio */
    vertical-align: middle !important;
  }
  .social-icon {
    width: 22px !important;
    height: auto !important;
    display: inline-block !important;
    margin: 0 4px !important;
  }
}

</style>
