@php
    $color = $content['subtitle_color'] ?? '#555555';
    $bgcolor = $content['subtitle_bgcolor'] ?? 'transparent';
    $size = $content['subtitle_size'] ?? '18px';
    $align = $content['subtitle_align'] ?? 'left';
    $bold = $content['subtitle_bold'] ?? '600';
    $italic = $content['subtitle_italic'] ?? 'normal';
    $underline = $content['subtitle_underline'] ?? 'none';
    
    $sizeValue = (int) filter_var($size, FILTER_SANITIZE_NUMBER_INT);
    $lineHeight = $sizeValue > 0 ? ($sizeValue * 1.4) . 'px' : '25px';
    
    $subtitle = $content['subtitle'] ?? 'Subtitulo por defecto';
@endphp

@if(!empty($subtitle))
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 4px 0; max-width: 670px;">
  <tr>
    <td align="{{ $align }}" style="
        color: {{ $color }};
        background-color: {{ $bgcolor }};
        font-size: {{ $size }};
        font-weight: {{ $bold }};
        font-style: {{ $italic }};
        text-decoration: {{ $underline }};
        font-family: Arial, Helvetica, sans-serif;
        line-height: {{ $lineHeight }};
        mso-line-height-rule: exactly;
        padding: 10px 15px;
        margin: 0;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        box-sizing: border-box;
        max-width: 100%;
    ">
        {!! $subtitle !!}
    </td>
  </tr>
</table>
@endif