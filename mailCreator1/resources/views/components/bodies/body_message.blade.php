@php
    $color = $content['message_color'] ?? '#333333';
    $bgcolor = $content['message_bgcolor'] ?? 'transparent';
    $size = $content['message_size'] ?? '16px';
    $align = $content['message_align'] ?? 'left';
    $bold = $content['message_bold'] ?? 'normal';
    $italic = $content['message_italic'] ?? 'normal';
    $underline = $content['message_underline'] ?? 'none';
    
    $sizeValue = (int) filter_var($size, FILTER_SANITIZE_NUMBER_INT);
    $lineHeight = $sizeValue > 0 ? ($sizeValue * 1.5) . 'px' : '24px';
@endphp

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
        {!! $content['message'] ?? 'Mensaje' !!}
    </td>
  </tr>
</table>