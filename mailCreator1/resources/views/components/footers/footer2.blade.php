@php
    // Determinar ruta del logo
    if (!in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
        $logoPath = asset('storage/logos/' . $campaign->logo); // Logo personalizado
    } else {
        $logoPath = asset('img/' . ($campaign->logo ?? 'blanco.png')); // Logo predefinido
    }

    $color = $campaign->color ?? '#333333';
@endphp

<!-- FOOTER RESPONSIVE START -->
<style>
  /* Reset general para emails */
  img {
    border: none;
    display: block;
    outline: none;
    text-decoration: none;
  }

  /* Asegura que la tabla principal ocupe el 100% del ancho siempre */
  .footer-wrapper {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  /* Ajustes para tablets */
  @media only screen and (max-width: 768px) {
    .footer-logo {
      width: 158px !important;
    }
    .footer-text {
      font-size: 10px !important;
    }
  }

  /* Ajustes para móviles */
  @media only screen and (max-width: 480px) {
    .footer-logo {
      width: 40px !important;
    }
    .footer-text {
      font-size: 9px !important;
      line-height: 1.4;
    }
  }
</style>

<tr>
  <td class="footer-wrapper" align="center" style="padding: 0; margin: 0; background-color: {{ $color }};">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" role="presentation"
      style="width: 100%; max-width: 600px; background-color: {{ $color }}; text-align: center; color: white; font-family: Arial, sans-serif; margin: 0; padding: 0;">
      
      <!-- LOGO -->
      <tr>
        <td style="padding: 12px 0;">
          <img src="{{ $logoPath }}" alt="Logo UDLA"
               class="footer-logo"
               style="width: 70px; height: auto; margin: 0 auto; display: block;">
        </td>
      </tr>

      <!-- COPYRIGHT -->
      <tr>
        <td class="footer-text" style="padding: 10px 0; font-size: 11px; color: #eeeeee;">
          Universidad de Las Américas &copy; {{ date('Y') }}. Todos los derechos reservados.
        </td>
      </tr>

    </table>
  </td>
</tr>
<!-- FOOTER RESPONSIVE END -->
