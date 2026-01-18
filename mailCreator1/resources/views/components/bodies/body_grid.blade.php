@php
  $gridContent = $content['grid_content'] ?? [];
  $gridGap = intval($content['grid_gap'] ?? $content['grid_gap_backup'] ?? 10);
  $gridRowGap = intval($content['grid_row_gap'] ?? 8);
  $gridBorderRadius = intval($content['grid_border_radius'] ?? $content['grid_border_radius_backup'] ?? 0);
  $columns = intval($content['grid_columns'] ?? 3);
  $tableWidth = 600;
  
  // Generar ID único para este grid
  $gridId = $content['grid_id'] ?? 'grid-' . uniqid();
  
  // No permitir valores negativos
  $gridGap = max(0, $gridGap);
  $gridRowGap = max(0, $gridRowGap);

  // ✅ CAMBIO: Filtrar items pero MOSTRAR los que tienen contenido placeholder también
  $validItems = array_filter($gridContent, function($item) {
    $types = $item['types'] ?? ['text'];
    $text = trim(strip_tags($item['text'] ?? ''));
    
    // Considerar válido si tiene:
    // - Texto real (incluso si es placeholder como "Contenido del grid 1")
    // - O imagen
    // - O botón con texto diferente a vacío
    return (in_array('text', $types) && !empty($text))
           || (in_array('image', $types) && !empty($item['image']))
           || (in_array('button', $types) && !empty(trim($item['button_text'] ?? '')));
  });
  $validItems = array_values($validItems);

  // Si no hay items válidos, crear items por defecto para mostrar algo
  if (empty($validItems)) {
    $validItems = [
      [
        'text' => '<p style="color: #999; font-style: italic;">Grid vacío - Haz clic en editar para agregar contenido</p>',
        'types' => ['text'],
        'background_color' => '#f8f9fa'
      ]
    ];
  }

  // Dividir en filas
  $rows = array_chunk($validItems, $columns);
@endphp

<style>
  /* Estilos base globales */
  table, td {
    border-collapse: collapse;
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
  }
  img {
    border:0;
    outline:none;
    text-decoration:none;
    -ms-interpolation-mode:bicubic;
  }

  /* Estilos específicos para este grid: {{ $gridId }} */
  #{{ $gridId }} .email-container {
    width:100%;
    max-width:{{ $tableWidth }}px;
    margin:15px auto;
    font-family:Arial, Helvetica, sans-serif;
  }
  #{{ $gridId }} .email-table {
    width:100%;
    border-collapse:collapse;
  }
  #{{ $gridId }} .email-cell {
    background-color:#ffffff;
    border-radius:{{ $gridBorderRadius }}px;
    vertical-align:top;
    padding:12px;
    box-sizing:border-box;
  }
  #{{ $gridId }} .grid-text {
    font-size:14px;
    line-height:1.4;
    color:#333333;
    padding:0;
    word-wrap:break-word;
    overflow-wrap:break-word;
    white-space:normal;
  }
  #{{ $gridId }} .gap-spacer {
    font-size:0;
    line-height:0;
  }
  #{{ $gridId }} .row-spacer {
    height:{{ $gridRowGap }}px;
    font-size:0;
    line-height:0;
  }

  /* Responsive para {{ $gridId }} con gaps: {{ $gridGap }}px / {{ $gridRowGap }}px */
  @media only screen and (max-width:600px){
    #{{ $gridId }} .email-container {
      width:100% !important;
      max-width:100% !important;
      margin:15px auto !important;
      padding:0 10px !important;
    }
    #{{ $gridId }} .email-table {
      width:100% !important;
    }
    #{{ $gridId }} .email-row {
      display:block !important;
      margin-bottom:{{ $gridRowGap }}px !important;
    }
    #{{ $gridId }} .email-cell {
      display:block !important;
      width:100% !important;
      margin-bottom:{{ $gridGap }}px !important;
      box-sizing:border-box !important;
    }
    #{{ $gridId }} .email-cell + .email-cell {
      margin-top:{{ $gridGap }}px !important;
    }
    #{{ $gridId }} .email-cell:last-child {
      margin-bottom:0 !important;
    }
    #{{ $gridId }} .gap-spacer {
      display:none !important;
    }
    #{{ $gridId }} .row-spacer {
      display:none !important;
    }
    #{{ $gridId }} .grid-text {
      font-size:14px !important;
      padding:12px !important;
    }
    #{{ $gridId }} img,
    #{{ $gridId }} .responsive-img {
      max-width:100% !important;
      width:100% !important;
      height:auto !important;
      display:block !important;
    }
    #{{ $gridId }} a.responsive-button {
      display:block !important;
      width:100% ;
      max-width:100px !important;
      padding:12px 0 !important;
      text-align:center !important;
      box-sizing:border-box !important;
    }
  }

  @media only screen and (max-width:480px){
    #{{ $gridId }} .email-container { padding:0 5px !important; }
    #{{ $gridId }} .grid-text { font-size:13px !important; padding:10px !important; }
  }
</style>

<!--[if mso]>
<table width="{{ $tableWidth }}" cellpadding="0" cellspacing="0" border="0" align="center" style="width:{{ $tableWidth }}px;">
<tr><td style="padding:0;margin:0;">
<![endif]-->

<div id="{{ $gridId }}" data-grid-gap="{{ $gridGap }}" data-row-gap="{{ $gridRowGap }}">
  <div class="email-container">
    <table class="email-table" cellpadding="0" cellspacing="0" border="0" role="presentation" width="{{ $tableWidth }}">
      @foreach($rows as $rowIndex => $rowItems)
        @php
          $itemsInRow = count($rowItems);
          $totalGapsInRow = max(0, ($itemsInRow - 1) * $gridGap);
          $availableWidth = $tableWidth - $totalGapsInRow;
          $colWidthPx = floor($availableWidth / $itemsInRow);
          $minColWidth = 150;
          if ($colWidthPx < $minColWidth && $itemsInRow > 1) {
            $colWidthPx = $minColWidth;
          }
        @endphp

        <tr class="email-row">
          @foreach($rowItems as $colIndex => $item)
            @php
              $types = $item['types'] ?? ['text'];
              $backgroundColor = $item['background_color'] ?? '#ffffff';
              $fontSize = intval($item['font_size'] ?? 14);
              $fontSize = min($fontSize, 16);

              $btn = [
                'text' => $item['button_text'] ?? '',
                'link' => $item['button_link'] ?? '#',
                'bg' => $item['button_bg_color'] ?? '#0d6efd',
                'color' => $item['button_text_color'] ?? '#fff',
                'size' => min($item['button_font_size'] ?? 16, 16),
                'radius' => $item['button_border_radius'] ?? 4,
                'border_color' => $item['button_border_color'] ?? '#000000',
                'border_width' => $item['button_border_width'] ?? 0,
                'bold' => $item['button_bold'] ?? false,
                'italic' => $item['button_italic'] ?? false,
                'underline' => $item['button_underline'] ?? false,
                'align' => $item['button_align'] ?? 'center'
              ];
              $fontWeight = $btn['bold'] ? 'bold' : 'normal';
              $fontStyle = $btn['italic'] ? 'italic' : 'normal';
            @endphp

            <td class="email-cell"
                width="{{ $colWidthPx }}"
                style="background-color:{{ $backgroundColor }};
                       border-radius:{{ $gridBorderRadius }}px;
                       vertical-align:top;
                       font-size:{{ $fontSize }}px;
                       width:{{ $colWidthPx }}px;
                       padding:0;">

              {{-- Imagen --}}
              @if(in_array('image', $types) && !empty($item['image']))
                @php
                  $imgBorder = $item['image_border_width'] ?? 0;
                  $imgBorderColor = $item['image_border_color'] ?? '#000';
                  $imgRadius = $item['image_border_radius'] ?? 0;
                  $userWidth = $item['image_width'] ?? '';
                  $userHeight = $item['image_height'] ?? '';
                  $imgAlign = $item['image_align'] ?? 'center';
                  $alignAttr = $imgAlign === 'left' ? 'left' : ($imgAlign === 'right' ? 'right' : 'center');
                @endphp
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td align="{{ $alignAttr }}">
                      <img src="{{ asset($item['image']) }}"
                           @if($userWidth) width="{{ $userWidth }}" @else width="100%" @endif
                           @if($userHeight) height="{{ $userHeight }}" @endif
                           class="responsive-img"
                           style="display:block;
                                  @if($imgAlign === 'center') margin:0 auto; @elseif($imgAlign === 'right') margin-left:auto; @else margin-right:auto; @endif
                                  @if($userWidth) width:{{ $userWidth }}px!important; @else width:100%; @endif
                                  @if($userHeight) height:{{ $userHeight }}px; @else height:auto; @endif
                                  max-width:100%;
                                  border-radius:{{ $imgRadius }}px;
                                  border:{{ $imgBorder }}px solid {{ $imgBorderColor }};">
                    </td>
                  </tr>
                </table>
              @endif

              {{-- Texto --}}
              @if(in_array('text', $types))
                @php 
                  $textColor = $item['font_color'] ?? '#333333';
                  $textContent = $item['text'] ?? '';
                @endphp
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td class="grid-text" style="font-size:{{ $fontSize }}px; line-height:1.4; color:{{ $textColor }}; padding:60px 5px 10px 25px !important; text-align:left;">
                      {!! $textContent !!}
                    </td>
                  </tr>
                </table>
              @endif

              {{-- Botón --}}
              @if(!empty($btn['text']))
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:8px 10px 0 10px;">
                  <tr>
                    <td align="{{ $btn['align'] }}">
                      <!--[if mso]>
                      <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                   href="{{ $btn['link'] }}"
                                   style="height:38px;v-text-anchor:middle;width:auto;"
                                   arcsize="{{ min(50, ($btn['radius'] ?? 4) * 2) }}%"
                                   strokecolor="{{ $btn['border_color'] }}"
                                   strokeweight="{{ $btn['border_width'] }}px"
                                   fillcolor="{{ $btn['bg'] }}">
                        <w:anchorlock/>
                        <center style="color:{{ $btn['color'] }};
                                       font-family:Arial,Helvetica,sans-serif;
                                       font-size:{{ $btn['size'] }}px;
                                       font-weight:{{ $fontWeight }};
                                       font-style:{{ $fontStyle }};">
                          {{ $btn['text'] }}
                        </center>
                      </v:roundrect>
                      <![endif]-->
                      <!--[if !mso]><!-->
                      <a href="{{ $btn['link'] }}" target="_blank" class="responsive-button"
                         style="background:{{ $btn['bg'] }};
                                border-radius:{{ $btn['radius'] }}px;
                                border:{{ $btn['border_width'] }}px solid {{ $btn['border_color'] }};
                                color:{{ $btn['color'] }};
                                display:inline-block;
                                font-family:Arial,Helvetica,sans-serif;
                                font-size:{{ $btn['size'] }}px;
                                font-weight:{{ $fontWeight }};
                                font-style:{{ $fontStyle }};
                                line-height:1.4;
                                text-align:center;
                                text-decoration:{{ $btn['underline'] ? 'underline' : 'none' }};
                                padding:10px 20px;
                                word-wrap:break-word;
                                overflow-wrap:break-word;
                                box-sizing:border-box;
                                mso-hide:all;
                                margin-left:25px;
                                margin-bottom:25px">
                        {{ $btn['text'] }}
                      </a>
                      <!--<![endif]-->
                    </td>
                  </tr>
                </table>
              @endif
            </td>

            {{-- Espaciador horizontal entre columnas --}}
            @if($colIndex < $itemsInRow - 1)
              <td class="gap-spacer" width="{{ $gridGap }}" style="width:{{ $gridGap }}px; min-width:{{ $gridGap }}px; max-width:{{ $gridGap }}px; font-size:0; line-height:0;">&nbsp;</td>
            @endif
          @endforeach
        </tr>

        {{-- Espaciador vertical entre filas --}}
        @if($rowIndex < count($rows) - 1 && $gridRowGap > 0)
          <tr class="row-spacer">
            <td colspan="{{ ($itemsInRow * 2) - 1 }}" style="height:{{ $gridRowGap }}px; font-size:0; line-height:0;">&nbsp;</td>
          </tr>
        @endif
      @endforeach
    </table>
  </div>
</div>

<!--[if mso]>
</td></tr></table>
<![endif]-->