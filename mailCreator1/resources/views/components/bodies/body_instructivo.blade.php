<!-- body_instructivo.blade.php - Responsive -->
@php
    $instructivoTitle = $content['instructivo_title'] ?? 'Información del programa';
    $instructivoTitleColor = $content['instructivo_title_color'] ?? '#c41e3a';
    $instructivoGeneralBgColor = $content['instructivo_general_bg_color'] ?? '#ffffff';
    $instructivoItems = $content['instructivo_items'] ?? [];
    $instructivoItemsCount = (int)($content['instructivo_items_count'] ?? 3);
    $instructivoExtraMessage = $content['instructivo_extra_message'] ?? '';
    $instructivoShowButtons = $content['instructivo_show_buttons'] ?? 0;
    $instructivoButtons = $content['instructivo_buttons'] ?? [];
    $instructivoButtonsCount = (int)($content['instructivo_buttons_count'] ?? 2);
    
    $visibleItems = [];
    for($i = 0; $i < $instructivoItemsCount; $i++) {
        if(isset($instructivoItems[$i])) {
            $visibleItems[] = $instructivoItems[$i];
        }
    }
    
    $visibleButtons = [];
    if($instructivoShowButtons) {
        for($i = 0; $i < $instructivoButtonsCount; $i++) {
            if(isset($instructivoButtons[$i]) && !empty($instructivoButtons[$i]['text'])) {
                $visibleButtons[] = $instructivoButtons[$i];
            }
        }
    }
@endphp

<style type="text/css">
    @media only screen and (max-width: 400px) {
        .instructivo-wrapper {
            padding: 15px !important;
        }
        .instructivo-title {
            font-size: 18px !important;
        }
        .instructivo-item {
            padding: 10px !important;
            margin-bottom: 8px !important;
        }
        .instructivo-label {
            font-size: 13px !important;
        }
        .instructivo-content {
            font-size: 13px !important;
        }
        .instructivo-extra {
            font-size: 13px !important;
        }
        .instructivo-button-table {
            display: block !important;
            width: 100% !important;
        }
        .instructivo-button-cell {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            margin-bottom: 10px !important;
        }
        .instructivo-button {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
    }
</style>

{{-- Wrapper general con color de fondo --}}
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 20px; max-width: 670px;">
    <tr>
        <td class="instructivo-wrapper" style="background-color: {{ $instructivoGeneralBgColor }}; padding: 20px; border-radius: 8px;">
            
            {{-- Title --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 15px;">
                <tr>
                    <td class="instructivo-title" style="font-family: Arial, Helvetica, sans-serif; font-size: 20px; font-weight: bold; color: {{ $instructivoTitleColor }};">
                        {{ $instructivoTitle }}
                    </td>
                </tr>
            </table>

            {{-- Items - BLOQUES VERTICALES --}}
            @foreach($visibleItems as $item)
                @php
                    $label = $item['label'] ?? '';
                    $content = $item['content'] ?? '';
                    $bgColor = $item['bg_color'] ?? '#ffffff';
                @endphp
                
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px;">
                    <tr>
                        <td class="instructivo-item" style="padding: 12px; background-color: {{ $bgColor }}; border: 1px solid #dee2e6; border-radius: 4px;">
                            @if(!empty($label))
                                <div class="instructivo-label" style="font-weight: bold; color: #212529; font-size: 14px; margin-bottom: 5px; font-family: Arial, Helvetica, sans-serif; line-height: 1.5;">
                                    {!! $label !!}
                                </div>
                            @endif
                            
                            @if(!empty($content))
                                <div class="instructivo-content" style="color: #495057; font-size: 14px; font-family: Arial, Helvetica, sans-serif; line-height: 1.5;">
                                    {!! $content !!}
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
            @endforeach

            {{-- Extra Message --}}
            @if(!empty($instructivoExtraMessage) && trim(strip_tags($instructivoExtraMessage)))
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 15px;">
                <tr>
                    <td class="instructivo-extra" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 1.6; color: #495057;">
                        {!! $instructivoExtraMessage !!}
                    </td>
                </tr>
            </table>
            @endif

            {{-- Buttons --}}
            @if(!empty($visibleButtons))
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 15px;">
                <tr>
                    <td>
                        <table class="instructivo-button-table" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                @foreach($visibleButtons as $index => $btn)
                                    @php
                                        $text = $btn['text'] ?? 'Botón';
                                        $url = $btn['url'] ?? '#';
                                        $style = $btn['style'] ?? 'solid';
                                        $bgColor = $btn['bg_color'] ?? '#c41e3a';
                                        $textColor = $btn['text_color'] ?? '#ffffff';
                                        $borderColor = $btn['border_color'] ?? '#c41e3a';
                                        
                                        $buttonStyle = $style === 'solid'
                                            ? "background-color: {$bgColor}; color: {$textColor}; border: 2px solid {$borderColor};"
                                            : "background-color: transparent; color: {$textColor}; border: 2px solid {$borderColor};";
                                    @endphp
                                    
                                    @if($index > 0)
                                        <td width="10">&nbsp;</td>
                                    @endif
                                    
                                    <td class="instructivo-button-cell">
                                        <a href="{{ $url }}" class="instructivo-button" style="{{ $buttonStyle }} padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; font-family: Arial, Helvetica, sans-serif; font-weight: bold; text-align: center; font-size: 14px; min-width: 120px;">
                                            {{ $text }}
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            @endif
            
        </td>
    </tr>
</table>