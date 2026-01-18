<!-- footer1.blade.php -->
@php
  $footerBg = $campaign->background ?? '#f9f9f9'; // Fondo del footer
  $footerColor = $campaign->color ?? '#6f1f14';  // Color principal campaña
  $textColor = '#ffffff';                       // Color del texto
@endphp

<!-- FOOTER COMPLETO A ANCHO TOTAL -->
<tr>
  <td align="center" valign="top" style="padding:0;">

    <!-- Tabla envolvente del footer -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"
      style="background-color: {{ $footerBg }}; border-radius:0; overflow:hidden; max-width=600px;">

      <!-- FILA ÍCONOS SOCIALES -->
      <tr>
        <td align="center" style="padding: 12px 0; border-bottom:1px solid #c7c7c7; background-color:white;">
          <table border="0" align="center" cellpadding="0" cellspacing="0" class="social-table" style="margin:0 auto;">
            <tr>
              @if ($campaign->facebook)
              <td style="padding: 0 6px; width: 30px; height: 30px;">
                <a href="https://www.facebook.com/{{ $campaign->facebook }}" target="_blank">
                  <img src="{{ asset('img/icon-facebook-color.png') }}" width="28" alt="Facebook" class="social-icon" style="display:block; border:0;">
                </a>
              </td>
              @endif

              @if ($campaign->twitter)
              <td style="padding: 0 6px; width: 30px; height: 30px;">
                <a href="https://twitter.com/{{ $campaign->twitter }}" target="_blank">
                  <img src="{{ asset('img/icon-twitter-color.png') }}" width="28" alt="Twitter" class="social-icon" style="display:block; border:0;">
                </a>
              </td>
              @endif

              @if ($campaign->youtube)
              <td style="padding: 0 6px; width: 30px; height: 30px;">
                <a href="https://youtube.com/{{ $campaign->youtube }}" target="_blank">
                  <img src="{{ asset('img/icon-youtube-color.png') }}" width="28" alt="YouTube" class="social-icon" style="display:block; border:0;">
                </a>
              </td>
              @endif

              @if ($campaign->linkedin)
              <td style="padding: 0 6px; width: 30px; height: 30px;">
                <a href="https://www.linkedin.com/{{ $campaign->linkedin }}" target="_blank">
                  <img src="{{ asset('img/icon-linkedIn-color.png') }}" width="28" alt="LinkedIn" class="social-icon" style="display:block; border:0;">
                </a>
              </td>
              @endif

              @if ($campaign->instagram)
              <td style="padding: 0 6px; width: 30px; height: 30px;">
                <a href="https://www.instagram.com/{{ $campaign->instagram }}" target="_blank">
                  <img src="{{ asset('img/icon-instagram-color.png') }}" width="28" alt="Instagram" class="social-icon" style="display:block; border:0;">
                </a>
              </td>
              @endif

              @if ($campaign->tiktok)
              <td style="padding: 0 6px; width: 30px; height: 30px;">
                <a href="https://www.tiktok.com/{{ $campaign->tiktok }}" target="_blank">
                  <img src="{{ asset('img/icon-tiktok-color.png') }}" width="28" alt="TikTok" class="social-icon" style="display:block; border:0;">
                </a>
              </td>
              @endif
            </tr>
          </table>
        </td>
      </tr>

      <!-- FILA COPYRIGHT -->
      <tr>
        <td align="center" style="background-color: {{ $footerColor }}; padding:14px 20px;">
          <p style="margin:0; font-size:13px; line-height:20px; font-family:Arial, sans-serif; color:{{ $textColor }}; text-align:center;">
            Este correo cumple con todas las normas vigentes.<br>
            Universidad de Las Américas. Todos los derechos reservados &copy; {{ date('Y') }}
          </p>
        </td>
      </tr>

    </table>
  </td>
</tr>

<!-- ✅ Estilos responsive para móviles -->
<style>
  @media only screen and (max-width: 480px) {
    .social-icon {
      width: 18px !important;   /* Íconos mucho más proporcionados en móvil */
      height: 18px !important;
      display: inline-block !important;
    }
    .social-table td {
      padding: 0 3px !important; /* Menos espacio entre íconos */
    }
    p {
      font-size: 12px !important;
      line-height: 18px !important;
    }
  }
</style>
