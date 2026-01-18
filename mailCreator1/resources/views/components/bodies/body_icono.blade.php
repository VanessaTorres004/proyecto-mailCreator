@php
    $iconTextItems = $content['icon_text_content'] ?? [];
    $iconTextRows = $content['icon_text_rows'] ?? 2;
    $iconTextGap = $content['icon_text_gap'] ?? 15;
    $iconTextBorderRadius = $content['icon_text_border_radius'] ?? 0;
    $iconTextLayout = $content['icon_text_layout'] ?? 'vertical';

    $visibleItems = [];
    for($i = 0; $i < $iconTextRows; $i++) {
        if(isset($iconTextItems[$i])) {
            $item = $iconTextItems[$i];
            if(!empty($item['title']) || !empty($item['description'])) {
                $visibleItems[] = $item;
            }
        }
    }
@endphp

<style type="text/css">
  @media only screen and (max-width: 600px) {
    .stack-column {
      display: block !important;
      width: 100% !important;
    }
    .stack-column-center {
      text-align: center !important;
    }
  }
</style>

@if(!empty($visibleItems))
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 670px; margin: 0 auto;">
  @if($iconTextLayout === 'horizontal')
    {{-- Layout Horizontal --}}
    <tr>
      @foreach($visibleItems as $index => $item)
        @php
            $iconPosition = $item['icon_position'] ?? 'left';
            $backgroundColor = $item['background_color'] ?? '#ffffff';
            $iconSize = $item['icon_size'] ?? 60;
            $iconBorderColor = $item['icon_border_color'] ?? '#000000';
            $iconBorderWidth = $item['icon_border_width'] ?? 0;
            $iconBorderRadius = $item['icon_border_radius'] ?? 0;
            $cellWidth = floor(100 / count($visibleItems));
        @endphp
        
        <td width="{{ $cellWidth }}%" valign="top" class="stack-column" style="padding: {{ $iconTextGap/2 }}px {{ $iconTextGap/2 }}px  {{ $iconTextGap/2 }}px 0;">
          <!--[if mso]>
          <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
          <tr>
          <td>
          <![endif]-->
          
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: {{ $backgroundColor }}; border-radius: {{ $iconTextBorderRadius }}px;">
            @if($iconPosition === 'up')
              {{-- Icono arriba --}}
              <tr>
                <td align="center" class="stack-column-center" style="padding: 16px 12px 8px 12px;">
                  @if(!empty($item['icon']))
                    <img src="{{ strpos($item['icon'], 'http') === 0 ? $item['icon'] : asset('storage/'.$item['icon']) }}" 
                         width="{{ $iconSize }}" 
                         height="{{ $iconSize }}"
                         alt=""
                         style="display: block; width: {{ $iconSize }}px; height: {{ $iconSize }}px; border: {{ $iconBorderWidth }}px solid {{ $iconBorderColor }}; border-radius: {{ $iconBorderRadius }}px; margin: 0 auto;">
                  @endif
                </td>
              </tr>
              <tr>
                <td align="center" class="stack-column-center" style="padding: 8px 12px 16px 12px;">
                  @if(!empty($item['title']))
                    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; color: #333333; margin: 0 0 6px 0; line-height: 1.3; word-wrap: break-word;">
                      {!! $item['title'] !!}
                    </div>
                  @endif
                  @if(!empty($item['description']))
                    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #666666; margin: 0; line-height: 1.4; word-wrap: break-word;">
                      {!! $item['description'] !!}
                    </div>
                  @endif
                </td>
              </tr>
            @else
              {{-- Icono a la izquierda o derecha --}}
              <tr>
                @if($iconPosition === 'left')
                  <td width="{{ $iconSize + 16 }}" align="center" valign="middle" class="stack-column-center" style="padding: 12px 8px 12px 12px;">
                    @if(!empty($item['icon']))
                      <img src="{{ strpos($item['icon'], 'http') === 0 ? $item['icon'] : asset('storage/'.$item['icon']) }}" 
                           width="{{ $iconSize }}" 
                           height="{{ $iconSize }}"
                           alt=""
                           style="display: block; width: {{ $iconSize }}px; height: {{ $iconSize }}px; border: {{ $iconBorderWidth }}px solid {{ $iconBorderColor }}; border-radius: {{ $iconBorderRadius }}px; margin: 0 auto;">
                    @endif
                  </td>
                  <td align="left" valign="middle" class="stack-column-center" style="padding: 12px 12px 12px 8px;">
                    @if(!empty($item['title']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; color: #333333; margin: 0 0 6px 0; line-height: 1.3; word-wrap: break-word;">
                        {!! $item['title'] !!}
                      </div>
                    @endif
                    @if(!empty($item['description']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #666666; margin: 0; line-height: 1.4; word-wrap: break-word;">
                        {!! $item['description'] !!}
                      </div>
                    @endif
                  </td>
                @else
                  <td align="left" valign="middle" class="stack-column-center" style="padding: 12px 8px 12px 12px;">
                    @if(!empty($item['title']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; font-weight: bold; color: #333333; margin: 0 0 6px 0; line-height: 1.3; word-wrap: break-word;">
                        {!! $item['title'] !!}
                      </div>
                    @endif
                    @if(!empty($item['description']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #666666; margin: 0; line-height: 1.4; word-wrap: break-word;">
                        {!! $item['description'] !!}
                      </div>
                    @endif
                  </td>
                  <td width="{{ $iconSize + 16 }}" align="center" valign="middle" class="stack-column-center" style="padding: 12px 12px 12px 8px;">
                    @if(!empty($item['icon']))
                      <img src="{{ strpos($item['icon'], 'http') === 0 ? $item['icon'] : asset('storage/'.$item['icon']) }}" 
                           width="{{ $iconSize }}" 
                           height="{{ $iconSize }}"
                           alt=""
                           style="display: block; width: {{ $iconSize }}px; height: {{ $iconSize }}px; border: {{ $iconBorderWidth }}px solid {{ $iconBorderColor }}; border-radius: {{ $iconBorderRadius }}px; margin: 0 auto;">
                    @endif
                  </td>
                @endif
              </tr>
            @endif
          </table>
          
          <!--[if mso]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      @endforeach
    </tr>
  @else
    {{-- Layout Vertical --}}
    @foreach($visibleItems as $item)
      @php
          $iconPosition = $item['icon_position'] ?? 'left';
          $backgroundColor = $item['background_color'] ?? '#ffffff';
          $iconSize = $item['icon_size'] ?? 60;
          $iconBorderColor = $item['icon_border_color'] ?? '#000000';
          $iconBorderWidth = $item['icon_border_width'] ?? 0;
          $iconBorderRadius = $item['icon_border_radius'] ?? 0;
      @endphp
      
      <tr>
        <td style="padding: {{ $iconTextGap/2 }}px 0;">
          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: {{ $backgroundColor }}; border-radius: {{ $iconTextBorderRadius }}px;">
            @if($iconPosition === 'up')
              {{-- Icono arriba --}}
              <tr>
                <td align="center" style="padding: 16px 12px 8px 12px;">
                  @if(!empty($item['icon']))
                    <img src="{{ strpos($item['icon'], 'http') === 0 ? $item['icon'] : asset('storage/'.$item['icon']) }}" 
                         width="{{ $iconSize }}" 
                         height="{{ $iconSize }}"
                         alt=""
                         style="display: block; width: {{ $iconSize }}px; height: {{ $iconSize }}px; border: {{ $iconBorderWidth }}px solid {{ $iconBorderColor }}; border-radius: {{ $iconBorderRadius }}px; margin: 0 auto;">
                  @endif
                </td>
              </tr>
              <tr>
                <td align="center" style="padding: 8px 12px 16px 12px;">
                  @if(!empty($item['title']))
                    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; color: #333333; margin: 0 0 8px 0; line-height: 1.3;">
                      {!! $item['title'] !!}
                    </div>
                  @endif
                  @if(!empty($item['description']))
                    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #666666; margin: 0; line-height: 1.5;">
                      {!! $item['description'] !!}
                    </div>
                  @endif
                </td>
              </tr>
            @else
              {{-- Icono a la izquierda o derecha --}}
              <tr>
                @if($iconPosition === 'left')
                  <td width="{{ $iconSize + 20 }}" align="center" valign="middle" style="padding: 16px 10px 16px 16px;">
                    @if(!empty($item['icon']))
                      <img src="{{ strpos($item['icon'], 'http') === 0 ? $item['icon'] : asset('storage/'.$item['icon']) }}" 
                           width="{{ $iconSize }}" 
                           height="{{ $iconSize }}"
                           alt=""
                           style="display: block; width: {{ $iconSize }}px; height: {{ $iconSize }}px; border: {{ $iconBorderWidth }}px solid {{ $iconBorderColor }}; border-radius: {{ $iconBorderRadius }}px;">
                    @endif
                  </td>
                  <td align="left" valign="middle" style="padding: 16px 16px 16px 10px;">
                    @if(!empty($item['title']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; color: #333333; margin: 0 0 6px 0; line-height: 1.3;">
                        {!! $item['title'] !!}
                      </div>
                    @endif
                    @if(!empty($item['description']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #666666; margin: 0; line-height: 1.5;">
                        {!! $item['description'] !!}
                      </div>
                    @endif
                  </td>
                @else
                  <td align="left" valign="middle" style="padding: 16px 10px 16px 16px;">
                    @if(!empty($item['title']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; color: #333333; margin: 0 0 6px 0; line-height: 1.3;">
                        {!! $item['title'] !!}
                      </div>
                    @endif
                    @if(!empty($item['description']))
                      <div style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #666666; margin: 0; line-height: 1.5;">
                        {!! $item['description'] !!}
                      </div>
                    @endif
                  </td>
                  <td width="{{ $iconSize + 20 }}" align="center" valign="middle" style="padding: 16px 16px 16px 10px;">
                    @if(!empty($item['icon']))
                      <img src="{{ strpos($item['icon'], 'http') === 0 ? $item['icon'] : asset('storage/'.$item['icon']) }}" 
                           width="{{ $iconSize }}" 
                           height="{{ $iconSize }}"
                           alt=""
                           style="display: block; width: {{ $iconSize }}px; height: {{ $iconSize }}px; border: {{ $iconBorderWidth }}px solid {{ $iconBorderColor }}; border-radius: {{ $iconBorderRadius }}px;">
                    @endif
                  </td>
                @endif
              </tr>
            @endif
          </table>
        </td>
      </tr>
    @endforeach
  @endif
</table>
@endif

{{-- Debug output for development --}}
@if(config('app.debug') && auth()->check() && auth()->user()->role === 'admin')
<pre style="background:#f0f0f0; padding:5px; font-size:12px; border:1px solid #ccc; white-space:pre-wrap;">
{{ json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
</pre>
@endif