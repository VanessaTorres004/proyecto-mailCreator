@php
  $footerBg = $campaign->color ?? '#6f1f14';
  $textColor = '#ffffff';
  $linkColor = '#ffffff';

  // Si el logo no es uno de los predefinidos, entonces es personalizado
    if (!in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
        $logoPath = asset('storage/logos/' . $campaign->logo); // Ruta de logos personalizados
    } else {
        $logoPath = asset('img/' . ($campaign->logo ?? 'blanco.png')); // Ruta de logos predefinidos
    }
@endphp


<tr>
  <td align="center" valign="top" style="padding:0; margin:0; background-color: {{ $footerBg }};">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="{{ $footerBg }}">
      <tr>
        <td align="center" style="padding:0;">

          <table width="600" border="0" cellspacing="0" cellpadding="0"
                 style="width:100%; max-width:600px; margin:0 auto; border-radius:0 0 10px 10px; background-color: {{ $footerBg }}; font-family: 'Montserrat', Arial, sans-serif; color: {{ $textColor }}; text-align:center;">
            <tr>
              <td style="padding:20px 15px;">

                <!-- Logo CONTROLADO (atributo width + inline width fijo) -->
                <img src="{{ $logoPath }}" alt="UDLA Logo" class="footer-logo"
                     width="70"
                     style="display:block; margin:0 auto 12px; border:0; width:70px; max-width:70px; height:auto; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic;">

                <p style="font-size:15px; font-weight:600; margin:0 0 15px; line-height:1.3; letter-spacing:0.02em;">
                  AMO LO QUE HAGO
                </p>

                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin:0 auto;">
                  <tr>
                    <td style="font-size:13px; font-family: 'Montserrat', Arial, sans-serif; text-align:center;">
                      <a href="https://www.udla.edu.ec/la-udla/sobre-nosotros/normativa-general/"
                         target="_blank"
                         style="color: {{ $linkColor }}; text-decoration:none; padding:0 4px; display:inline-block; font-weight:600;">
                        Normativa general
                      </a>
                    </td>
                    <td style="font-size:13px; color: {{ $textColor }}; padding:0 2px;">|</td>
                    <td style="font-size:13px; font-family: 'Montserrat', Arial, sans-serif; text-align:center;">
                      <a href="https://api.whatsapp.com/send/?phone=593987545694&text&type=phone_number&app_absent=0"
                         target="_blank"
                         style="color: {{ $linkColor }}; text-decoration:none; padding:0 4px; display:inline-block; font-weight:600;">
                        Contáctanos
                      </a>
                    </td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>
  </td>
</tr>

<!-- Responsive: SIN width:100% -->
<style>
  @media screen and (max-width:480px) {
    .footer-logo {
      width:70px !important;
      max-width:70px !important;
      height:auto !important;
    }
    td p { font-size:14px !important; }
    td a { font-size:12px !important; padding:0 6px !important; }
  }
</style>
