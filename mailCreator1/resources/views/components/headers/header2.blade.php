@php
    $primaryColor = $campaign->color ?? '#4a90e2';

    // Nombre del archivo del logo guardado en la campaña
    $logoFile = $campaign->logo ?? 'blanco.png';

    // Rutas físicas para comprobar si existe en storage o en public/img
    $storageLogoPath = public_path('storage/logos/' . $logoFile);
    $publicLogoPath  = public_path('img/' . $logoFile);

    // Determinar cuál URL usar según dónde esté el archivo
    if (!empty($logoFile) && file_exists($storageLogoPath)) {
        // Logo personalizado en storage/logos
        $logoPath = asset('storage/logos/' . $logoFile);
    } elseif (file_exists($publicLogoPath)) {
        // Logo predefinido en public/img
        $logoPath = asset('img/' . $logoFile);
    } else {
        // Si no existe ninguno, -> logo por defecto
        $logoPath = asset('img/blanco.png');
    }
@endphp


<tr>
  <td align="center" bgcolor="{{ $primaryColor }}" style="padding:10px 0;">
    <!-- Wrapper full-width -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="{{ $primaryColor }}">
      <tr>
        <td align="center" style="padding:0;">
          <!-- Contenido centrado -->
          <table width="600" border="0" cellspacing="0" cellpadding="0" style="max-width:600px; width:100%; margin:0 auto; background-color:{{ $primaryColor }}; border-radius:8px;">
            <tr>
              <td align="center" style="padding:20px 10px;">
                <!-- Logo -->
                <img src="{{ $logoPath }}" alt="UDLA Logo" width="100" style="display:block; height:auto; margin-bottom:10px;" />
                <!-- Título -->
                <h1 style="margin:0; font-size:24px; font-weight:700; color:#ffffff; line-height:1.2; text-align:center;">
                  Universidad de las Américas
                </h1>
                <!-- Slogan -->
                <p style="margin:5px 0 0 0; font-size:16px; font-weight:500; color:#f0f0f0; text-align:center;">
                  ¡AMO LO QUE HAGO!
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </td>
</tr>

<!-- Responsive -->
<style>
  @media only screen and (max-width:480px){
    table[width="600"]{
      width:95% !important;
    }
    td img{
      width:80px !important;
      height:auto !important;
    }
    h1{
      font-size:20px !important;
      line-height:1.2 !important;
    }
    p{
      font-size:14px !important;
    }
  }
</style>

