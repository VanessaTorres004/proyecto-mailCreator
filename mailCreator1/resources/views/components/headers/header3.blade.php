@php
    $primaryColor = $campaign->color ?? '#4a90e2';
    $linkColor = '#ffffff';

    // Si el logo no es uno de los predefinidos, entonces es personalizado
    if (!in_array($campaign->logo, ['blanco.png', 'rojo.png'])) {
        $logoPath = asset('storage/logos/' . $campaign->logo); // Ruta de logos personalizados
    } else {
        $logoPath = asset('img/' . ($campaign->logo ?? 'blanco.png')); // Ruta de logos predefinidos
    }
@endphp


<tr>
  <td align="center" valign="top" style="padding:0; margin:0; background-color: {{ $primaryColor }};">

    <!-- Wrapper full-width -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="{{ $primaryColor }}">
      <tr>
        <td align="center" style="padding:0;">

          <!-- Tabla interna centrada (max-width 600px) -->
          <table width="600" border="0" cellspacing="0" cellpadding="0"
                 style="max-width:600px; width:100%; margin:0 auto; background-color: {{ $primaryColor }};">
            <tr>
              <!-- Logo -->
              <td align="left" valign="middle" style="padding:12px 15px;" class="header-logo">
                <img src="{{ $logoPath }}" alt="UDLA Logo" width="80" height="auto"
                     style="display:block; width:80px; max-width:100%; height:auto; border:0;">
              </td>

            
            </tr>
          </table>
          <!-- /Tabla interna 600px -->

        </td>
      </tr>
    </table>
    <!-- /Wrapper full-width -->

  </td>
</tr>

<!-- ESTILOS RESPONSIVOS -->
<style>
  @media only screen and (max-width:480px){
    .header-logo, .header-title {
      display:block !important;
      width:100% !important;
      text-align:center !important;
      padding:8px 0 !important;
    }
    .header-logo img {
      width:50px !important;
      height:auto !important;
      margin:0 auto !important;
    }
    .header-title a {
      font-size:15px !important;
      display:inline-block !important;
    }
    .header-title a img {
      width:9px !important;
      height:auto !important;
      max-width:9px !important;
    }
  }
</style>
