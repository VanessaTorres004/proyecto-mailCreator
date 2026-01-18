<!-- body_button.blade.php -->
@php
  $buttonText = $content['button_text'] ?? $content['text'] ?? 'Click aquí';
  $buttonLink = $content['button_link'] ?? $content['link'] ?? '#';
  $buttonColor = $content['button_color'] ?? $content['color'] ?? '#0d6efd';
  $buttonTextColor = $content['button_text_color'] ?? $content['text_color'] ?? '#ffffff';
  $buttonFontSize = $content['button_font_size'] ?? $content['font_size'] ?? 16;
  $buttonBorderRadius = $content['button_border_radius'] ?? $content['border_radius'] ?? 4;
  $buttonBold = $content['button_bold'] ?? $content['bold'] ?? false;
  $buttonItalic = $content['button_italic'] ?? $content['italic'] ?? false;
  $buttonUnderline = $content['button_underline'] ?? $content['underline'] ?? false;
  $buttonBorderEnabled = $content['button_border_enabled'] ?? false;
  $buttonBorderWidth = $content['button_border_width'] ?? 0;
  $buttonBorderColor = $content['button_border_color'] ?? '#000000';
  $buttonBorderStyle = $content['button_border_style'] ?? 'solid';
  $maxWidth = 600;
  
  $fontWeight = $buttonBold ? 'bold' : 'normal';
  $fontStyle = $buttonItalic ? 'italic' : 'normal';
  $textDecoration = $buttonUnderline ? 'underline' : 'none';
  
  // Configurar borde
  $borderCSS = 'none';
  $borderVML = '';
  if($buttonBorderEnabled && $buttonBorderWidth > 0) {
    $borderCSS = "{$buttonBorderWidth}px {$buttonBorderStyle} {$buttonBorderColor}";
    $borderVML = "stroke='t' strokecolor='{$buttonBorderColor}' strokeweight='{$buttonBorderWidth}px'";
  } else {
    $borderVML = "stroke='f'";
  }
@endphp

@if(!empty($buttonText))
<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" 
       width="100%" style="max-width:{{ $maxWidth }}px; margin:0 auto;">
  <tr>
    <td align="center" style="padding:20px 0;">

      <!--[if mso]>
      <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" 
        href="{{ $buttonLink }}" style="height:50px;v-text-anchor:middle;width:100%;" 
        arcsize="{{ min(50, $buttonBorderRadius) }}%" 
        {!! $borderVML !!} fillcolor="{{ $buttonColor }}">
        <w:anchorlock/>
        <center style="color:{{ $buttonTextColor }};font-family:Arial, sans-serif;font-size:{{ $buttonFontSize }}px;
                       font-weight:{{ $fontWeight }};font-style:{{ $fontStyle }};text-decoration:{{ $textDecoration }};">
          {{ $buttonText }}
        </center>
      </v:roundrect>
      <![endif]-->

      <!--[if !mso]><!-- -->
      <a href="{{ $buttonLink }}" target="_blank"
         style="background-color:{{ $buttonColor }}; border-radius:{{ $buttonBorderRadius }}px;
                border:{{ $borderCSS }}; color:{{ $buttonTextColor }}; display:inline-block; 
                font-family:Arial, Helvetica, sans-serif; font-size:{{ $buttonFontSize }}px; 
                font-weight:{{ $fontWeight }}; font-style:{{ $fontStyle }};
                line-height:44px; text-align:center; text-decoration:{{ $textDecoration }};
                padding:0 24px; mso-hide:all;">
        {{ $buttonText }}
      </a>
      <!--<![endif]-->

    </td>
  </tr>
</table>
@endif