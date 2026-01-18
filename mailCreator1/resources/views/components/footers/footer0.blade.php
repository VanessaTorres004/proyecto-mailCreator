<!-- footer0.blade.php -->
@php
  $footerBg = $campaign->background ?? '#f9f9f9';
  $footerColor = $campaign->color ?? '#6f1f14';
  $textColor = '#ffffff';
  $darkBg = '#2b2b2b';

  if (!in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
      $logoPath = asset('storage/logos/' . $campaign->logo);
  } else {
      $logoPath = asset('img/' . ($campaign->logo ?? 'blanco.png'));
  }
@endphp

<!-- FOOTER COMPLETO -->
<tr>
  <td align="center" valign="top" style="padding:0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color: {{ $darkBg }}; border-radius:0; overflow:hidden; max-width=600px;">

      <!-- FILA PRINCIPAL CON 3 COLUMNAS -->
      <tr>
        <!-- COLUMNA 1: Slogan -->
        <td width="30%" valign="middle" style="background-color: {{ $darkBg }}; padding:30px 20px;" class="footer-column">
          <h3 style="margin:0; font-size:16px; line-height:24px; font-family:Arial, sans-serif; color:{{ $textColor }}; font-weight:bold;">
            El mundo necesita<br>gente que ame<br>lo que hace.
          </h3>
        </td>

        <!-- COLUMNA 2: Ubicaciones y Contacto -->
        <td width="50%" valign="middle" style="background-color: {{ $darkBg }}; padding:20px;" class="footer-column">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <!-- Encuéntranos -->
              <td width="50%" valign="top" style="padding-right:10px;">
                <p style="margin:0 0 10px 0; font-size:14px; line-height:20px; font-family:Arial, sans-serif; color:{{ $textColor }}; font-weight:bold;">
                  Encuéntranos
                </p>
                <p style="margin:0; font-size:12px; line-height:18px; font-family:Arial, sans-serif; color:#cccccc;">
                  📍 UDLAPark<br>
                  📍 UDLA Granados<br>
                  📍 UDLA Colón<br>
                  📍 Granja Nono
                </p>
              </td>

              <!-- Contáctanos -->
              <td width="50%" valign="top" style="padding-left:10px;">
                <p style="margin:0 0 10px 0; font-size:14px; line-height:20px; font-family:Arial, sans-serif; color:{{ $textColor }}; font-weight:bold;">
                  Contáctanos
                </p>
                <table border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, sans-serif; font-size:12px; color:#cccccc; line-height:18px;">
                  <tr>
                    <td style="width:16px; text-align:center; vertical-align:middle;">📞</td>
                    <td style="padding-left:6px; vertical-align:middle;">+593 2 398 1000</td>
                  </tr>
                  <tr>
                    <td style="text-align:center; vertical-align:middle;">✉️</td>
                    <td style="padding-left:6px; vertical-align:middle;">admision@udla.edu.ec</td>
                  </tr>
                  <tr>
                    <td style="text-align:center; vertical-align:middle;">💬</td>
                    <td style="padding-left:6px; vertical-align:middle;">+593 9 875 45694</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>

        <!-- COLUMNA 3: Logo -->
        <td width="20%" valign="middle" style="background-color: {{ $footerColor }}; padding:30px 20px;" class="footer-column footer-red">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center">
                <img src="{{ $logoPath }}" width="120" alt="UDLA" style="display:block; border:0; margin:0 auto; max-width:100%; height:auto;">
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <!-- FILA COPYRIGHT -->
      <tr>
        <td colspan="3" align="center" style="background-color: {{ $darkBg }}; padding:20px; border-top:1px solid #444444;">
          <p style="margin:0; font-size:12px; line-height:18px; font-family:Arial, sans-serif; color:#999999; text-align:center;">
            Este correo cumple con todas las normas vigentes.<br>
            Universidad de Las Américas. Todos los derechos reservados &copy; {{ date('Y') }}
          </p>
        </td>
      </tr>
    </table>
  </td>
</tr>

<!-- Estilos responsive -->
<style>
  @media only screen and (max-width: 600px) {
    /* Estructura general */
    table[align="center"] tr:first-child {
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
    }

    .footer-column {
      display: block !important;
      width: 100% !important;
      text-align: center !important;
      padding: 15px 10px !important;
    }

    /* Apilar cada columna */
    .footer-column:nth-child(1),
    .footer-column:nth-child(2),
    .footer-column:nth-child(3) {
      border-top: 1px solid rgba(255,255,255,0.1);
    }

    .footer-column:first-child {
      border-top: none !important;
    }

    /* Texto general */
    h3 {
      font-size: 15px !important;
      line-height: 22px !important;
      text-align: center !important;
      margin-bottom: 8px !important;
    }

    p {
      font-size: 12px !important;
      line-height: 18px !important;
      text-align: center !important;
      margin-bottom: 6px !important;
    }

    /* “Contáctanos” y “Encuéntranos” */
    .footer-column table td {
      text-align: center !important;
    }

    .footer-column table tr {
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      margin-bottom: 6px !important;
    }

    .footer-column table td:first-child {
      margin-bottom: 2px !important;
    }

    /* Logo */
    .footer-red {
      background-color: {{ $footerColor }} !important;
      border-top: none !important;
      padding: 20px 10px !important;
    }

    .footer-red img {
      width: 90px !important;
      max-width: 70% !important;
      margin: 10px auto !important;
    }

    td[colspan="3"] {
      padding: 12px !important;
    }
  }

  @media only screen and (max-width: 480px) {
    h3 {
      font-size: 13px !important;
      line-height: 20px !important;
    }
    p {
      font-size: 11px !important;
      line-height: 17px !important;
    }
    .footer-red img {
      width: 75px !important;
    }
  }
</style>

