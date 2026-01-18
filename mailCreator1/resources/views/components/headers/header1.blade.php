@php
    $primaryColor = $campaign->color ?? '#bd0000';
    $logoFile = $campaign->logo ?? 'blanco.png';

    
    $storageLogoPath = public_path('storage/logos/' . $logoFile);
    $publicLogoPath  = public_path('img/' . $logoFile);

    // Verificación de existencia de archivo (logo personalizado o predefinido)
    if (!empty($logoFile) && file_exists($storageLogoPath)) {
        // Logo personalizado (vía storage/logos)
        $logoPath = asset('storage/logos/' . $logoFile);
    } elseif (file_exists($publicLogoPath)) {
        // Logo predefinido (vía public/img)
        $logoPath = asset('img/' . $logoFile);
    } else {
        // Si no se encuentra ninguno, usa uno por defecto
        $logoPath = asset('img/blanco.png');
    }
@endphp



<tr>
  <td align="center" valign="top" style="padding:0; margin:0;">
    <!-- Wrapper full-width -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="{{ $primaryColor }}">
      <tr>
        <td align="center" style="padding:0;">
          <!-- Contenido centrado a 600px -->
          <table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width:600px; width:100%; background-color:{{ $primaryColor }};">
            <tr>
              <td align="center" style="padding:20px 0px 0px 0px;">
                <!-- Logo más pequeño -->
                <img src="{{ $logoPath }}" alt="Logo UDLA" width="120" style="display:block; width:120px !important; height:auto; border:0;">
              </td>
            </tr>
            <tr>
              <td align="center" style="padding:8px 10px 5px 10px;">
                <span style="display:block; color:#ffffff; font-family: Arial, Helvetica, sans-serif; font-size:28px; font-weight:bold; line-height:1; text-align:center;">
                  Universidad de las Américas
                </span>
              </td>
            </tr>
          </table>
          <!-- /Contenido centrado -->
        </td>
      </tr>
    </table>
    <!-- /Wrapper full-width -->
  </td>
</tr>

