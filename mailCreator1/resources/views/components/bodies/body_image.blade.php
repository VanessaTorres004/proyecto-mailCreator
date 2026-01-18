<!-- body_image.blade.php -->
@php
  $image = $content['image'] ?? '';
  $imageWidth = min($content['image_width'] ?? 200, 600);
  $imageHeight = $content['image_height'] ?? null;
  $imageAlign = $content['image_align'] ?? 'center';
  $imageBorderColor = $content['image_border_color'] ?? '#000000';
  $imageBorderWidth = $content['image_border_width'] ?? 0;
  $imageBorderRadius = $content['image_border_radius'] ?? 0;

  // Configuración de alineación
  $alignStyle = 'center';
  $marginStyle = '0 auto';
  
  if($imageAlign === 'left') {
    $alignStyle = 'left';
    $marginStyle = '0 auto 0 0';
  } elseif($imageAlign === 'right') {
    $alignStyle = 'right';
    $marginStyle = '0 0 0 auto';
  }
@endphp

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:0; padding:0;">
  <tr>
    <td style="text-align:{{ $alignStyle }}; padding:10px 0;">
      
      @if(!empty($image))
        <table cellpadding="0" cellspacing="0" border="0" @if($imageAlign === 'center') align="center" @elseif($imageAlign === 'right') align="right" @endif>
          <tr>
            <td>
              <!--[if mso]>
              <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                style="height:{{ $imageHeight ?? 'auto' }}; width:{{ $imageWidth }}px; v-text-anchor:top;"
                @if($imageBorderRadius > 0) arcsize="{{ min(($imageBorderRadius / $imageWidth) * 100, 50) }}%" @endif
                @if($imageBorderWidth > 0) strokeweight="{{ $imageBorderWidth }}px" strokecolor="{{ $imageBorderColor }}" @else stroked="false" @endif
                fillcolor="transparent">
                <v:imagedata src="{{ asset($image) }}" />
                <w:anchorlock/>
              </v:roundrect>
              <![endif]-->

              <!--[if !mso]><!-->
              <img src="{{ asset($image) }}"
                   width="{{ $imageWidth }}"
                   @if($imageHeight) height="{{ $imageHeight }}" @endif
                   style="display:block; 
                          width:{{ $imageWidth }}px; 
                          @if($imageHeight) height:{{ $imageHeight }}px; @else height:auto; @endif
                          max-width:100%;
                          @if($imageBorderWidth > 0) border:{{ $imageBorderWidth }}px solid {{ $imageBorderColor }}; @else border:none; @endif
                          @if($imageBorderRadius > 0) border-radius:{{ $imageBorderRadius }}px; @endif
                          outline:none; 
                          text-decoration:none; 
                          -ms-interpolation-mode:bicubic;
                          margin:{{ $marginStyle }};"
                   alt="Imagen">
              <!--<![endif]-->
            </td>
          </tr>
        </table>
      @else
        <!-- Marcador cuando no hay imagen -->
        <div style="display:inline-block; 
                    width:{{ $imageWidth }}px; 
                    height:{{ $imageHeight ?? 150 }}px; 
                    border:2px dashed {{ $imageBorderColor }}; 
                    @if($imageBorderRadius > 0) border-radius:{{ $imageBorderRadius }}px; @endif
                    text-align:center; 
                    line-height:{{ $imageHeight ?? 150 }}px; 
                    color:#888; 
                    font-size:14px;
                    margin:{{ $marginStyle }};">
          Sin imagen
        </div>
      @endif

    </td>
  </tr>
</table>