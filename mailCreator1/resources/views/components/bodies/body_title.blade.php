@php
    $color = $content['title_color'] ?? '#333333';
    $bgcolor = $content['title_bgcolor'] ?? 'transparent';
    $size = $content['title_size'] ?? '24px';
    $align = $content['title_align'] ?? 'left';
    $bold = $content['title_bold'] ?? 'bold';
    $italic = $content['title_italic'] ?? 'normal';
    $underline = $content['title_underline'] ?? 'none';
    
    $sizeValue = (int) filter_var($size, FILTER_SANITIZE_NUMBER_INT);
    $lineHeight = $sizeValue > 0 ? ($sizeValue * 1.3) . 'px' : '31px';
    
    $title = $content['title'] ?? '';
@endphp

@if(!empty($title))
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
        text-align: {{ $align }};
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        box-sizing: border-box;
        max-width: 100%;
    ">
        {!! $title !!}
    </td>
  </tr>
</table>
@endif