<!-- body_logo.blade.php -->
@php
  $logoVariant = $content['logo_variant'] ?? 'rojo.png';
  $logoWidth = min($content['logo_width'] ?? 150, 600); // Máximo 600px
  $logoAlign = $content['logo_align'] ?? 'center';
  $maxWidth = 600;

  $alignMap = [
    'left'   => 'left',
    'center' => 'center', 
    'right'  => 'right'
  ];
  $alignment = $alignMap[$logoAlign] ?? 'center';
@endphp

<table align="center" cellpadding="0" cellspacing="0" border="0" 
       width="100%" style="max-width:{{ $maxWidth }}px; margin:0 auto; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
  <tr>
    <td align="{{ $alignment }}" style="padding:20px;">
      <img src="{{ asset('img/' . $logoVariant) }}" 
           alt="Logo"
           width="{{ $logoWidth }}"
           class="email-logo"
           style="display:block; max-width:{{ $logoWidth }}px; width:{{ $logoWidth }}px; height:auto; border:0; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic;">
    </td>
  </tr>
</table>

<!-- Estilos responsive -->
<style>
  @media only screen and (max-width: 480px) {
    /* Mantener el tamaño definido por el usuario también en móvil */
    .email-logo {
      max-width: {{ $logoWidth }}px !important;
      width: {{ $logoWidth }}px !important;
      height: auto !important;
    }
  }
</style>
