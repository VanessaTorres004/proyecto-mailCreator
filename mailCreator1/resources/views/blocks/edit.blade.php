@php
    // Obtener permisos del usuario actual
    $permissions = \App\Http\Controllers\RolePermissionsController::getUserPermissions();
    
    // Obtener tamaños de texto permitidos
    $allowedSizes = $permissions->can_use_custom_text_sizes 
        ? [12, 14, 16, 18, 20, 24, 28, 32] // Todos los tamaños
        : $permissions->allowed_text_sizes; // Solo los permitidos
@endphp

@extends('layouts.app')

@section('content')

<div class="container mt-3">
    <h3>Editar Bloque</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('blocks.edit', $block->id) }}" method="POST" enctype="multipart/form-data" id="mainForm">
        @csrf

        @php 
            $c = $content[0]['content'] ?? $content; 
        @endphp

     {{-- TEXTO (title, subtitle, message) --}}
@foreach(['title','subtitle','message'] as $type)
    @if($block->type === $type)
    <div class="card shadow-sm mb-3">
        <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
            <h6 class="mb-0" style="color: white !important;"><i class="bi bi-pencil-square me-2"></i>{{ ucfirst($type) }}</h6>
        </div>
        <div class="card-body p-3">
            {{-- Toolbar de formato --}}
            <div class="mb-2">
                <small class="text-muted d-block mb-2">Herramientas de formato</small>
                <div class="btn-toolbar" role="toolbar">
                    {{-- Grupo de formato de texto --}}
                    <div class="btn-group me-2 mb-2" role="group" aria-label="Formato de texto">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','bold')" title="Negrita">
                            <i class="bi bi-type-bold"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','italic')" title="Cursiva">
                            <i class="bi bi-type-italic"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','underline')" title="Subrayado">
                            <i class="bi bi-type-underline"></i>
                        </button>
                    </div>
                    
                    {{-- Grupo de alineación --}}
                    <div class="btn-group me-2 mb-2" role="group" aria-label="Alineación">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','justifyLeft')" title="Alinear izquierda">
                            <i class="bi bi-text-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','justifyCenter')" title="Centrar">
                            <i class="bi bi-text-center"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','justifyRight')" title="Alinear derecha">
                            <i class="bi bi-text-right"></i>
                        </button>
                    </div>
                    
                    {{-- Grupo de listas --}}
                    <div class="btn-group me-2 mb-2" role="group" aria-label="Listas">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','insertUnorderedList')" title="Lista con viñetas">
                            <i class="bi bi-list-ul"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatContent('{{ $type }}Editable','insertOrderedList')" title="Lista numerada">
                            <i class="bi bi-list-ol"></i>
                        </button>
                    </div>
                    
                    {{-- Selector de tamaño y colores --}}
                    <div class="btn-group me-2 mb-2" role="group" aria-label="Tamaño y color">
                        <select onchange="setTextSize('{{ $type }}Editable', this.value)" class="form-select form-select-sm" style="width: auto;">
                        <option value="">Tamaño</option>
                        @foreach($allowedSizes as $size)
                            <option value="{{ $size }}">{{ $size }}px</option>
                        @endforeach
                    </select>
                        <button type="button" class="btn btn-sm btn-outline-secondary position-relative" onclick="document.getElementById('{{ $type }}_colorPicker').click()" title="Color de texto">
                            <i class="bi bi-palette"></i>
                            <input type="color" 
                                   id="{{ $type }}_colorPicker" 
                                   style="position: absolute; opacity: 0; width: 0; height: 0;"
                                   value="{{ $c[$type.'_color'] ?? '#333333' }}"
                                   onchange="applyTextColor('{{ $type }}', this.value)">
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary position-relative" onclick="document.getElementById('{{ $type }}_bgcolorPicker').click()" title="Color de fondo">
                            <i class="bi bi-paint-bucket"></i>
                            <input type="color" 
                                   id="{{ $type }}_bgcolorPicker" 
                                   style="position: absolute; opacity: 0; width: 0; height: 0;"
                                   value="{{ ($c[$type.'_bgcolor'] ?? 'transparent') !== 'transparent' ? ($c[$type.'_bgcolor'] ?? '#ffffff') : '#ffffff' }}"
                                   onchange="applyBgColor('{{ $type }}', this.value)">
                        </button>
                        <button type="button" 
                                class="btn btn-sm btn-outline-secondary" 
                                onclick="clearBgColor('{{ $type }}')" 
                                title="Quitar fondo">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Área de edición --}}
            <div class="mb-2">
                <label class="form-label small text-muted">Contenido</label>
                <div id="{{ $type }}Editable" 
                     contenteditable="true" 
                     class="form-control" 
                     style="min-height:100px; word-wrap:break-word; white-space:pre-wrap;"
                     placeholder="Escribe aquí tu {{ $type }}...">{!! $c[$type] ?? '' !!}</div>
            </div>
            
            {{-- Inputs hidden para el contenido y estilos --}}
            <input type="hidden" name="{{ $type }}" id="{{ $type }}Input" value="{{ $c[$type] ?? '' }}">
            <input type="hidden" name="{{ $type }}_color" id="{{ $type }}_color" value="{{ $c[$type.'_color'] ?? '#333333' }}">
            <input type="hidden" name="{{ $type }}_bgcolor" id="{{ $type }}_bgcolor" value="{{ $c[$type.'_bgcolor'] ?? 'transparent' }}">
            <input type="hidden" name="{{ $type }}_size" id="{{ $type }}_size" value="{{ $c[$type.'_size'] ?? '16px' }}">
            <input type="hidden" name="{{ $type }}_align" id="{{ $type }}_align" value="{{ $c[$type.'_align'] ?? 'left' }}">
            <input type="hidden" name="{{ $type }}_bold" id="{{ $type }}_bold" value="{{ $c[$type.'_bold'] ?? 'normal' }}">
            <input type="hidden" name="{{ $type }}_italic" id="{{ $type }}_italic" value="{{ $c[$type.'_italic'] ?? 'normal' }}">
            <input type="hidden" name="{{ $type }}_underline" id="{{ $type }}_underline" value="{{ $c[$type.'_underline'] ?? 'none' }}">
        </div>
    </div>
    @endif
@endforeach

{{-- LOGO --}}
@if($block->type==='logo')
@php
    $logoVariant = $c['logo_variant'] ?? 'blanco.png';
    $logoWidth   = $c['logo_width'] ?? 150;
    $logoAlign   = $c['logo_align'] ?? 'center';
    $logos = ['blanco.png','rojo.png'];
@endphp
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-image me-2"></i>Configuración de Logo</h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Variante del logo</label>
                <select name="logo_variant" id="logoSelector" class="form-select">
                    @foreach($logos as $logo)
                        <option value="{{ $logo }}" {{ $logoVariant === $logo ? 'selected' : '' }}>
                            {{ ucfirst(pathinfo($logo, PATHINFO_FILENAME)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tamaño</label>
                <div class="input-group">
                    <input type="number" name="logo_width" id="logoWidth" class="form-control" value="{{ $logoWidth }}" min="50" max="500">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Alineación</label>
                <select name="logo_align" id="logoAlign" class="form-select">
                    <option value="left" {{ $logoAlign==='left'?'selected':'' }}>
                        <i class="bi bi-align-start"></i> Izquierda
                    </option>
                    <option value="center" {{ $logoAlign==='center'?'selected':'' }}>
                        <i class="bi bi-align-center"></i> Centro
                    </option>
                    <option value="right" {{ $logoAlign==='right'?'selected':'' }}>
                        <i class="bi bi-align-end"></i> Derecha
                    </option>
                </select>
            </div>
        </div>
    </div>
</div>
@endif

{{-- IMAGEN --}}
@if($block->type==='image')
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-card-image me-2"></i>Configuración de Imagen</h6>
    </div>
    <div class="card-body p-3">
        {{-- Vista previa --}}
        <div class="mb-3 text-center">
            <img id="imagePreview" 
                 src="{{ !empty($c['image']) ? asset('storage/'.$c['image']) : '' }}" 
                 class="img-thumbnail" 
                 style="max-width: 100%; max-height: 300px; {{ empty($c['image']) ? 'display:none;' : '' }}">
        </div>

        {{-- Selección de archivo --}}
        <div class="mb-3">
            <label class="form-label">Seleccionar imagen</label>
            <input type="file" name="image_file" id="imageFile" class="form-control" accept="image/*">
            <small class="form-text text-muted">Formatos: JPG, PNG, GIF</small>
        </div>

        <hr class="my-3">

        {{-- Dimensiones --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Ancho</label>
                <div class="input-group">
                    <input type="number" name="image_width" id="imageWidth" class="form-control" value="{{ $c['image_width'] ?? 300 }}" min="50" max="800">
                    <span class="input-group-text">px</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">Alto <small class="text-muted">(opcional)</small></label>
                <div class="input-group">
                    <input type="number" name="image_height" id="imageHeight" class="form-control" value="{{ $c['image_height'] ?? '' }}" min="50" max="800" placeholder="Auto">
                    <span class="input-group-text">px</span>
                </div>
                <small class="form-text text-muted">Dejar vacío para mantener proporción</small>
            </div>
        </div>

        {{-- Alineación --}}
        <div class="mb-3">
            <label class="form-label">Alineación</label>
            <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" name="image_align" id="imageAlignLeft" value="left" {{ ($c['image_align'] ?? '')==='left' ? 'checked':'' }}>
                <label class="btn btn-outline-secondary" for="imageAlignLeft">
                    <i class="bi bi-align-start"></i> Izquierda
                </label>
                
                <input type="radio" class="btn-check" name="image_align" id="imageAlignCenter" value="center" {{ ($c['image_align'] ?? '')==='center' ? 'checked':'' }}>
                <label class="btn btn-outline-secondary" for="imageAlignCenter">
                    <i class="bi bi-align-center"></i> Centro
                </label>
                
                <input type="radio" class="btn-check" name="image_align" id="imageAlignRight" value="right" {{ ($c['image_align'] ?? '')==='right' ? 'checked':'' }}>
                <label class="btn btn-outline-secondary" for="imageAlignRight">
                    <i class="bi bi-align-end"></i> Derecha
                </label>
            </div>
        </div>

        <hr class="my-3">

        {{-- Estilo de bordes --}}
        <div class="mb-2">
            <label class="form-label fw-bold">Bordes y estilo</label>
        </div>
        
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small">Color de marco</label>
                <input type="color" name="image_border_color" id="imageBorderColor" class="form-control form-control-color w-100" value="{{ $c['image_border_color'] ?? '#000000' }}">
            </div>
            
            <div class="col-md-4">
                <label class="form-label small">Ancho de marco</label>
                <div class="input-group input-group-sm">
                    <input type="number" name="image_border_width" id="imageBorderWidth" class="form-control" value="{{ $c['image_border_width'] ?? 0 }}" min="0" max="20">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label small">Bordes redondeados</label>
                <div class="input-group input-group-sm">
                    <input type="number" name="image_border_radius" id="imageBorderRadius" class="form-control" value="{{ $c['image_border_radius'] ?? 0 }}" min="0" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{-- GRID --}}
@if($block->type==='grid')
@php
    $gridItems = $c['grid_content'] ?? [];
    $gridColumns = $c['grid_columns'] ?? 2;
    $gridGap = $c['grid_gap'] ?? 15;
    $gridBorderRadius = $c['grid_border_radius'] ?? 0;
@endphp

<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-grid-3x3-gap me-2"></i>Configuración de Grid</h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Número de columnas</label>
                <select name="grid_columns" id="gridColumns" class="form-select">
                    <option value="2" {{ $gridColumns == 2 ? 'selected' : '' }}>2 Columnas</option>
                    <option value="3" {{ $gridColumns == 3 ? 'selected' : '' }}>3 Columnas</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Espacio entre columnas</label>
                <div class="input-group">
                    <input type="number" name="grid_gap" id="gridGap" class="form-control" value="{{ $gridGap }}" min="0" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Bordes redondeados</label>
                <div class="input-group">
                    <input type="number" name="grid_border_radius" id="gridBorderRadius" class="form-control" value="{{ $gridBorderRadius }}" min="0" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grid Columns --}}
<div id="grid-items" class="row g-3">
    @for($i=0;$i<3;$i++)
        @php
            $item = $gridItems[$i] ?? ['types'=>['text'],'text'=>'','image'=>'','background_color'=>'#ffffff'];
            $selectedTypes = isset($item['types']) ? $item['types'] : ['text'];
            if(empty($item['button_text']) || trim($item['button_text']) === '' || trim($item['button_text']) === 'Click aquí') {
                $selectedTypes = array_diff($selectedTypes, ['button']);
            }
        @endphp
        
        <div class="col-md-{{ $gridColumns == 2 ? '6' : '4' }} grid-column" data-column="{{ $i }}" id="gridColumn{{ $i }}" style="display: {{ $i < $gridColumns ? 'block' : 'none' }};">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important">
                    <h6 class="mb-0" style="color: white !important;"><i class="bi bi-layout-wtf"></i> Columna {{ $i+1 }}</h6>
                </div>
                <div class="card-body p-3">
                    <input type="hidden" name="grid_content[{{ $i }}][column_index]" value="{{ $i }}">

                    {{-- Content Type Selection --}}
                    <div class="mb-2">
                        <label class="form-label fw-bold">Tipos de contenido</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input type="checkbox" name="grid_content[{{ $i }}][types][]" value="text" id="gridTypeText{{ $i }}" class="form-check-input grid-type-checkbox" data-index="{{ $i }}" {{ in_array('text', $selectedTypes) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridTypeText{{ $i }}">
                                    <i class="bi bi-fonts"></i> Texto
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="grid_content[{{ $i }}][types][]" value="image" id="gridTypeImage{{ $i }}" class="form-check-input grid-type-checkbox" data-index="{{ $i }}" {{ in_array('image', $selectedTypes) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridTypeImage{{ $i }}">
                                    <i class="bi bi-image"></i> Imagen
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="grid_content[{{ $i }}][types][]" value="button" id="gridTypeButton{{ $i }}" class="form-check-input grid-type-checkbox" data-index="{{ $i }}" {{ in_array('button', $selectedTypes) ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridTypeButton{{ $i }}">
                                    <i class="bi bi-cursor"></i> Botón
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Background Color --}}
                    <div class="mb-2">
                        <label class="form-label">Color de fondo de celda</label>
                        <input type="color" name="grid_content[{{ $i }}][background_color]" id="gridBgColor{{ $i }}" class="form-control form-control-color w-100 grid-bg-color" data-index="{{ $i }}" value="{{ $item['background_color'] ?? '#ffffff' }}">
                    </div>

                    <hr class="my-2">

                    {{-- TEXT CONTROLS --}}
                    <div class="text-controls" id="textControls{{ $i }}" style="display:{{ in_array('text', $selectedTypes) ? 'block':'none' }};">
                        <div class="mb-2">
                            <label class="form-label fw-bold"><i class="bi bi-fonts"></i> Texto</label>
                            
                            <div class="btn-toolbar mb-2" role="toolbar">
                                <div class="btn-group me-2 mb-2" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','bold')" title="Negrita">
                                        <i class="bi bi-type-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','italic')" title="Cursiva">
                                        <i class="bi bi-type-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','underline')" title="Subrayado">
                                        <i class="bi bi-type-underline"></i>
                                    </button>
                                </div>
                                
                                <div class="btn-group me-2 mb-2" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','justifyLeft')">
                                        <i class="bi bi-text-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','justifyCenter')">
                                        <i class="bi bi-text-center"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','justifyRight')">
                                        <i class="bi bi-text-right"></i>
                                    </button>
                                </div>
                                
                                <div class="btn-group me-2 mb-2" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','insertUnorderedList')">
                                        <i class="bi bi-list-ul"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatGridContent('gridText{{ $i }}','insertOrderedList')">
                                        <i class="bi bi-list-ol"></i>
                                    </button>
                                </div>
                                
                                <div class="btn-group mb-2" role="group">
                                    <select onchange="setGridTextSize('gridText{{ $i }}', this.value)" class="form-select form-select-sm" style="width: auto;">
                                        <option value="">Tamaño</option>
                                        @foreach($allowedSizes as $size)
                                            <option value="{{ $size }}">{{ $size }}px</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openGridColorPicker('gridText{{ $i }}','gridInput{{ $i }}')">
                                        <i class="bi bi-palette"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div id="gridText{{ $i }}" contenteditable="true" class="form-control" style="min-height:80px; word-wrap:break-word; white-space:pre-wrap;">{!! $item['text'] ?? '' !!}</div>
                            <input type="hidden" name="grid_content[{{ $i }}][text]" id="gridInput{{ $i }}" value="{{ $item['text'] ?? '' }}">
                        </div>
                    </div>

                    {{-- IMAGE CONTROLS --}}
                    <div class="image-controls" id="imageControls{{ $i }}" style="display:{{ in_array('image', $selectedTypes) ? 'block':'none' }};">
                        <div class="mb-2">
                            <label class="form-label fw-bold"><i class="bi bi-image"></i> Imagen</label>
                            
                            <input type="file" name="grid_content[{{ $i }}][image]" class="form-control grid-image-input mb-2" data-index="{{ $i }}" accept="image/*">
                            
                            @if(!empty($item['image']))
                                <div class="mb-2 text-center">
                                    <img src="" class="img-thumbnail" style="max-width: 100%; max-height: 200px;" data-old-image="{{ asset($item['image']) }}">
                                </div>
                            @endif

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small">Ancho</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][image_width]" id="gridImageWidth{{ $i }}" class="form-control" value="{{ $item['image_width'] ?? 200 }}" min="10" max="400">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <label class="form-label small">Alto</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][image_height]" id="gridImageHeight{{ $i }}" class="form-control" value="{{ $item['image_height'] ?? '' }}" min="10" max="400" placeholder="Auto">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">Alineación</label>
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <input type="radio" class="btn-check" name="grid_content[{{ $i }}][image_align]" id="gridImageAlignLeft{{ $i }}" value="left" {{ ($item['image_align'] ?? '')==='left' ? 'checked':'' }}>
                                    <label class="btn btn-outline-secondary" for="gridImageAlignLeft{{ $i }}">
                                        <i class="bi bi-align-start"></i>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="grid_content[{{ $i }}][image_align]" id="gridImageAlignCenter{{ $i }}" value="center" {{ ($item['image_align'] ?? '')==='center' ? 'checked':'' }}>
                                    <label class="btn btn-outline-secondary" for="gridImageAlignCenter{{ $i }}">
                                        <i class="bi bi-align-center"></i>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="grid_content[{{ $i }}][image_align]" id="gridImageAlignRight{{ $i }}" value="right" {{ ($item['image_align'] ?? '')==='right' ? 'checked':'' }}>
                                    <label class="btn btn-outline-secondary" for="gridImageAlignRight{{ $i }}">
                                        <i class="bi bi-align-end"></i>
                                    </label>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small">Color marco</label>
                                    <input type="color" name="grid_content[{{ $i }}][image_border_color]" id="gridImageBorderColor{{ $i }}" class="form-control form-control-color w-100" value="{{ $item['image_border_color'] ?? '#000000' }}">
                                </div>
                                
                                <div class="col-4">
                                    <label class="form-label small">Ancho marco</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][image_border_width]" id="gridImageBorderWidth{{ $i }}" class="form-control" value="{{ $item['image_border_width'] ?? 0 }}" min="0" max="20">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label class="form-label small">Redondeo</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][image_border_radius]" id="gridImageBorderRadius{{ $i }}" class="form-control" value="{{ $item['image_border_radius'] ?? 0 }}" min="0" max="50">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON CONTROLS --}}
                    <div class="button-controls" id="buttonControls{{ $i }}" style="display:{{ in_array('button', $selectedTypes) ? 'block':'none' }};">
                        <div class="mb-2">
                            <label class="form-label fw-bold"><i class="bi bi-cursor"></i> Botón</label>
                            
                            <div class="mb-2">
                                <label class="form-label small">Texto del botón</label>
                                <input type="text" name="grid_content[{{ $i }}][button_text]" id="gridButtonText{{ $i }}" class="form-control" value="{{ $item['button_text'] ?? '' }}" placeholder="Ej: Más información">
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">Enlace (URL)</label>
                                <input type="text" name="grid_content[{{ $i }}][button_link]" id="gridButtonLink{{ $i }}" class="form-control" value="{{ $item['button_link'] ?? '#' }}" placeholder="https://...">
                            </div>
                            
                            {{-- ALINEACIÓN DEL BOTÓN --}}
                            <div class="mb-2">
                                <label class="form-label small">Alineación del botón</label>
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <input type="radio" class="btn-check" name="grid_content[{{ $i }}][button_align]" id="gridButtonAlignLeft{{ $i }}" value="left" {{ ($item['button_align'] ?? 'center')==='left' ? 'checked':'' }}>
                                    <label class="btn btn-outline-secondary" for="gridButtonAlignLeft{{ $i }}">
                                        <i class="bi bi-align-start"></i> Izquierda
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="grid_content[{{ $i }}][button_align]" id="gridButtonAlignCenter{{ $i }}" value="center" {{ ($item['button_align'] ?? 'center')==='center' ? 'checked':'' }}>
                                    <label class="btn btn-outline-secondary" for="gridButtonAlignCenter{{ $i }}">
                                        <i class="bi bi-align-center"></i> Centro
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="grid_content[{{ $i }}][button_align]" id="gridButtonAlignRight{{ $i }}" value="right" {{ ($item['button_align'] ?? 'center')==='right' ? 'checked':'' }}>
                                    <label class="btn btn-outline-secondary" for="gridButtonAlignRight{{ $i }}">
                                        <i class="bi bi-align-end"></i> Derecha
                                    </label>
                                </div>
                            </div>
                            
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small">Color fondo</label>
                                    <input type="color" name="grid_content[{{ $i }}][button_bg_color]" id="gridButtonBgColor{{ $i }}" class="form-control form-control-color w-100" value="{{ $item['button_bg_color'] ?? '#0d6efd' }}">
                                </div>
                                
                                <div class="col-6">
                                    <label class="form-label small">Color texto</label>
                                    <input type="color" name="grid_content[{{ $i }}][button_text_color]" id="gridButtonTextColor{{ $i }}" class="form-control form-control-color w-100" value="{{ $item['button_text_color'] ?? '#ffffff' }}">
                                </div>
                            </div>
                            
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small">Tamaño fuente</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][button_font_size]" id="gridButtonFontSize{{ $i }}" class="form-control" value="{{ $item['button_font_size'] ?? 16 }}" min="10" max="32">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <label class="form-label small">Redondeo</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][button_border_radius]" id="gridButtonBorderRadius{{ $i }}" class="form-control" value="{{ $item['button_border_radius'] ?? 4 }}" min="0" max="50">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>

                            {{-- NUEVOS CONTROLES DE BORDE --}}
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small">Color borde</label>
                                    <input type="color" name="grid_content[{{ $i }}][button_border_color]" id="gridButtonBorderColor{{ $i }}" class="form-control form-control-color w-100" value="{{ $item['button_border_color'] ?? '#000000' }}">
                                </div>
                                
                                <div class="col-6">
                                    <label class="form-label small">Ancho borde</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="grid_content[{{ $i }}][button_border_width]" id="gridButtonBorderWidth{{ $i }}" class="form-control" value="{{ $item['button_border_width'] ?? 0 }}" min="0" max="10">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input type="checkbox" name="grid_content[{{ $i }}][button_bold]" id="gridButtonBold{{ $i }}" class="form-check-input" {{ ($item['button_bold'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gridButtonBold{{ $i }}">
                                        <i class="bi bi-type-bold"></i> Negrita
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="checkbox" name="grid_content[{{ $i }}][button_italic]" id="gridButtonItalic{{ $i }}" class="form-check-input" {{ ($item['button_italic'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gridButtonItalic{{ $i }}">
                                        <i class="bi bi-type-italic"></i> Cursiva
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="checkbox" name="grid_content[{{ $i }}][button_underline]" id="gridButtonUnderline{{ $i }}" class="form-check-input" {{ ($item['button_underline'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gridButtonUnderline{{ $i }}">
                                        <i class="bi bi-type-underline"></i> Subrayado
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
</div>
@endif
{{-- ÍCONO-TEXTO --}}
@if($block->type==='icono')
@php
    $iconTextItems = $c['icon_text_content'] ?? [];
    $iconTextRows = $c['icon_text_rows'] ?? 2;
    $iconTextGap = $c['icon_text_gap'] ?? 15;
    $iconTextBorderRadius = $c['icon_text_border_radius'] ?? 0;
    $iconTextLayout = $c['icon_text_layout'] ?? 'vertical'; // Nuevo campo
@endphp

<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-card-text me-2"></i>Configuración de Ícono-Texto</h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Número de filas</label>
                <select name="icon_text_rows" id="iconTextRows" class="form-select">
                    <option value="1" {{ $iconTextRows == 1 ? 'selected' : '' }}>1 Fila</option>
                    <option value="2" {{ $iconTextRows == 2 ? 'selected' : '' }}>2 Filas</option>
                    <option value="3" {{ $iconTextRows == 3 ? 'selected' : '' }}>3 Filas</option>
                    <option value="4" {{ $iconTextRows == 4 ? 'selected' : '' }}>4 Filas</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Distribución de filas</label>
                <select name="icon_text_layout" id="iconTextLayout" class="form-select">
                    <option value="vertical" {{ $iconTextLayout == 'vertical' ? 'selected' : '' }}>Vertical (una debajo de otra)</option>
                    <option value="horizontal" {{ $iconTextLayout == 'horizontal' ? 'selected' : '' }}>Horizontal (una al lado de otra)</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Espacio entre filas</label>
                <div class="input-group">
                    <input type="number" name="icon_text_gap" id="iconTextGap" class="form-control" value="{{ $iconTextGap }}" min="0" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Bordes redondeados</label>
                <div class="input-group">
                    <input type="number" name="icon_text_border_radius" id="iconTextBorderRadius" class="form-control" value="{{ $iconTextBorderRadius }}" min="0" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Icon-Text Rows --}}
<div id="icon-text-items">
    @for($i=0;$i<4;$i++)
        @php
            $item = $iconTextItems[$i] ?? [
                'icon_position' => 'left',
                'title' => '',
                'description' => '',
                'icon' => '',
                'background_color' => '#ffffff'
            ];
        @endphp
        <div class="card shadow-sm mb-3 icon-text-row" data-row="{{ $i }}" id="iconTextRow{{ $i }}" style="display: {{ $i < $iconTextRows ? 'block' : 'none' }};">
            <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important ">
                <h6 class="mb-0" style="color: white !important;"><i class="bi bi-layers"></i> Fila {{ $i+1 }}</h6>
            </div>
            <div class="card-body p-3">
                <input type="hidden" name="icon_text_content[{{ $i }}][row_index]" value="{{ $i }}">

                <div class="row g-3 mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Posición del ícono</label>
                        <select name="icon_text_content[{{ $i }}][icon_position]" id="iconPosition{{ $i }}" class="form-select icon-position-select" data-index="{{ $i }}">
                            <option value="left" {{ ($item['icon_position'] ?? 'left') === 'left' ? 'selected' : '' }}>Izquierda</option>
                            <option value="right" {{ ($item['icon_position'] ?? 'left') === 'right' ? 'selected' : '' }}>Derecha</option>
                            <option value="up" {{ ($item['icon_position'] ?? 'left') === 'up' ? 'selected' : '' }}>Arriba</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Color de fondo</label>
                        <input type="color" name="icon_text_content[{{ $i }}][background_color]" id="iconTextBgColor{{ $i }}" class="form-control form-control-color w-100 icon-text-bg-color" data-index="{{ $i }}" value="{{ $item['background_color'] ?? '#ffffff' }}">
                    </div>
                </div>

                <hr class="my-2">

                <div class="row">
                    <div class="col-lg-5">
                        <div class="mb-2">
                            <label class="form-label fw-bold"><i class="bi bi-emoji-smile"></i> Ícono</label>
                            
                            <div class="mb-2">
                                <input type="file" name="icon_text_content[{{ $i }}][icon]" class="form-control icon-image-input" data-index="{{ $i }}" accept="image/*">
                            </div>
                            
                            @if(!empty($item['icon']))
                                <div class="mb-2 text-center">
                                    <img src="" class="img-thumbnail" style="max-width: 100px; height: auto;" data-old-icon="{{ asset($item['icon']) }}">
                                </div>
                            @endif

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small">Tamaño</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="icon_text_content[{{ $i }}][icon_size]" id="iconSize{{ $i }}" class="form-control icon-size-input" data-index="{{ $i }}" value="{{ $item['icon_size'] ?? 60 }}" min="20" max="150">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label class="form-label small">Redondeo</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="icon_text_content[{{ $i }}][icon_border_radius]" id="iconBorderRadius{{ $i }}" class="form-control icon-border-radius" data-index="{{ $i }}" value="{{ $item['icon_border_radius'] ?? 0 }}" min="0" max="100">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label small">Color marco</label>
                                    <input type="color" name="icon_text_content[{{ $i }}][icon_border_color]" id="iconBorderColor{{ $i }}" class="form-control form-control-color w-100 icon-border-color" data-index="{{ $i }}" value="{{ $item['icon_border_color'] ?? '#000000' }}">
                                </div>
                                
                                <div class="col-6">
                                    <label class="form-label small">Ancho marco</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="icon_text_content[{{ $i }}][icon_border_width]" id="iconBorderWidth{{ $i }}" class="form-control icon-border-width" data-index="{{ $i }}" value="{{ $item['icon_border_width'] ?? 0 }}" min="0" max="20">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="mb-2">
                            <label class="form-label fw-bold"><i class="bi bi-fonts"></i> Texto</label>
                            
                            <div class="mb-2">
                                <label class="form-label small">Título</label>
                                <div class="btn-toolbar mb-2" role="toolbar">
                                    <div class="btn-group me-2 mb-1" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextTitle{{ $i }}','bold')">
                                            <i class="bi bi-type-bold"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextTitle{{ $i }}','italic')">
                                            <i class="bi bi-type-italic"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextTitle{{ $i }}','underline')">
                                            <i class="bi bi-type-underline"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="btn-group me-2 mb-1" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextTitle{{ $i }}','justifyLeft')">
                                            <i class="bi bi-text-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextTitle{{ $i }}','justifyCenter')">
                                            <i class="bi bi-text-center"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextTitle{{ $i }}','justifyRight')">
                                            <i class="bi bi-text-right"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="btn-group mb-1" role="group">
                                        <select onchange="setIconTextSize('iconTextTitle{{ $i }}', this.value)" class="form-select form-select-sm" style="width: auto;">
                                            <option value="">Tamaño</option>
                                            @foreach($allowedSizes as $size)
                                                <option value="{{ $size }}">{{ $size }}px</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openIconTextColorPicker('iconTextTitle{{ $i }}','iconTextTitleInput{{ $i }}')">
                                            <i class="bi bi-palette"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="iconTextTitle{{ $i }}" contenteditable="true" class="form-control icon-text-title" data-index="{{ $i }}" style="min-height:50px; word-wrap:break-word; white-space:pre-wrap;">{!! $item['title'] ?? '' !!}</div>
                                <input type="hidden" name="icon_text_content[{{ $i }}][title]" id="iconTextTitleInput{{ $i }}" value="{{ $item['title'] ?? '' }}">
                            </div>

                            <div class="mb-2">
                                <label class="form-label small">Descripción</label>
                                <div class="btn-toolbar mb-2" role="toolbar">
                                    <div class="btn-group me-2 mb-1" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','bold')">
                                            <i class="bi bi-type-bold"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','italic')">
                                            <i class="bi bi-type-italic"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','underline')">
                                            <i class="bi bi-type-underline"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="btn-group me-2 mb-1" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','justifyLeft')">
                                            <i class="bi bi-text-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','justifyCenter')">
                                            <i class="bi bi-text-center"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','justifyRight')">
                                            <i class="bi bi-text-right"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="btn-group me-2 mb-1" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','insertUnorderedList')">
                                            <i class="bi bi-list-ul"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatIconTextContent('iconTextDesc{{ $i }}','insertOrderedList')">
                                            <i class="bi bi-list-ol"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="btn-group mb-1" role="group">
                                        <select onchange="setIconTextSize('iconTextDesc{{ $i }}', this.value)" class="form-select form-select-sm" style="width: auto;">
                                            <option value="">Tamaño</option>
                                            <option value="12">12px</option>
                                            <option value="14">14px</option>
                                            <option value="16">16px</option>
                                            <option value="18">18px</option>
                                            <option value="20">20px</option>
                                            <option value="24">24px</option>
                                        </select>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openIconTextColorPicker('iconTextDesc{{ $i }}','iconTextDescInput{{ $i }}')">
                                            <i class="bi bi-palette"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="iconTextDesc{{ $i }}" contenteditable="true" class="form-control icon-text-desc" data-index="{{ $i }}" style="min-height:80px; word-wrap:break-word; white-space:pre-wrap;">{!! $item['description'] ?? '' !!}</div>
                                <input type="hidden" name="icon_text_content[{{ $i }}][description]" id="iconTextDescInput{{ $i }}" value="{{ $item['description'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
</div>
@endif

{{-- BOTÓN --}}
@if($block->type==='button')
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-cursor-fill me-2"></i>Configuración de Botón</h6>
    </div>

    <div class="card-body p-3">
        {{-- Texto y enlace --}}
        <div class="row g-3 mb-2">
            <div class="col-md-6">
                <label class="form-label">Texto del botón</label>
                <input type="text" name="button_text" id="buttonText" class="form-control" value="{{ $c['text'] ?? 'Click aquí' }}" placeholder="Ej: Más información">
            </div>
            <div class="col-md-6">
                <label class="form-label">Enlace (URL)</label>
                <input type="text" name="button_link" id="buttonLink" class="form-control" value="{{ $c['link'] ?? '#' }}" placeholder="https://...">
            </div>
        </div>

        <hr class="my-2">

        {{-- Colores --}}
        <div class="mb-2">
            <label class="form-label fw-bold">Colores</label>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Color de fondo</label>
                    <input type="color" name="button_color" id="buttonColor" class="form-control form-control-color w-100" value="{{ $c['color'] ?? '#0d6efd' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Color de texto</label>
                    <input type="color" name="button_text_color" id="buttonTextColor" class="form-control form-control-color w-100" value="{{ $c['text_color'] ?? '#ffffff' }}">
                </div>
            </div>
        </div>

        <hr class="my-2">

        {{-- Tamaño y estilo --}}
        <div class="mb-2">
            <label class="form-label fw-bold">Tamaño y estilo</label>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small">Tamaño de fuente</label>
                    <div class="input-group">
                        <input type="number" name="button_font_size" id="buttonFontSize" class="form-control" value="{{ $c['font_size'] ?? 16 }}" min="10" max="32">
                        <span class="input-group-text">px</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Bordes redondeados</label>
                    <div class="input-group">
                        <input type="number" name="button_border_radius" id="buttonBorderRadius" class="form-control" value="{{ $c['border_radius'] ?? 4 }}" min="0" max="50">
                        <span class="input-group-text">px</span>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-2">

        {{-- Formato de texto --}}
        <div class="mb-2">
            <label class="form-label fw-bold">Formato de texto</label>
            <div class="d-flex gap-3">
                <div class="form-check">
                    <input type="checkbox" name="button_bold" id="buttonBold" class="form-check-input" {{ ($c['bold'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="buttonBold"><i class="bi bi-type-bold"></i> Negrita</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="button_italic" id="buttonItalic" class="form-check-input" {{ ($c['italic'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="buttonItalic"><i class="bi bi-type-italic"></i> Cursiva</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="button_underline" id="buttonUnderline" class="form-check-input" {{ ($c['underline'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="buttonUnderline"><i class="bi bi-type-underline"></i> Subrayado</label>
                </div>
            </div>
        </div>

        <hr class="my-2">

        {{-- Bordes --}}
<div class="mb-2">
    <label class="form-label fw-bold">Bordes</label>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label small">Grosor del borde</label>
            <div class="input-group">
                <input type="number" name="button_border_width" id="buttonBorderWidth" class="form-control" value="{{ $c['border_width'] ?? 0 }}" min="0" max="10">
                <span class="input-group-text">px</span>
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label small">Estilo</label>
            <select name="button_border_style" id="buttonBorderStyle" class="form-select">
                <option value="solid" {{ ($c['border_style'] ?? 'solid') === 'solid' ? 'selected' : '' }}>Sólido</option>
                <option value="dashed" {{ ($c['border_style'] ?? 'solid') === 'dashed' ? 'selected' : '' }}>Guiones</option>
                <option value="dotted" {{ ($c['border_style'] ?? 'solid') === 'dotted' ? 'selected' : '' }}>Puntos</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small">Color del borde</label>
            <input type="color" name="button_border_color" id="buttonBorderColor" class="form-control form-control-color w-100" value="{{ $c['border_color'] ?? '#000000' }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="form-check">
                <input type="checkbox" name="button_border_enabled" id="buttonBorderEnabled" class="form-check-input" {{ ($c['border_enabled'] ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="buttonBorderEnabled">Mostrar borde</label>
            </div>
        </div>
    </div>
</div>
    </div>
</div>


@endif
{{-- BANNER --}}
@if($block->type==='banner')
@php
    $bannerBgColor = $c['banner_bg_color'] ?? '#f8f9fa';
    $bannerBgImageEnabled = $c['banner_bg_image_enabled'] ?? false;
    $bannerBgImage = $c['banner_bg_image'] ?? '';
    $bannerWidth = $c['banner_width'] ?? 600;
    $bannerHeight = $c['banner_height'] ?? 200;
    $bannerTextAlign = $c['banner_text_align'] ?? 'center';
    $bannerBorderRadius = $c['banner_border_radius'] ?? 0;
    $bannerPadding = $c['banner_padding'] ?? 40;
    
    $bannerGradientEnabled = $c['banner_gradient_enabled'] ?? false;
    $bannerGradientColor1 = $c['banner_gradient_color_1'] ?? '#667eea';
    $bannerGradientColor2 = $c['banner_gradient_color_2'] ?? '#764ba2';
    $bannerGradientDirection = $c['banner_gradient_direction'] ?? 'to right';
    
    $bannerLinkUrl = $c['banner_link_url'] ?? '';
    $bannerLinkEnabled = $c['banner_link_enabled'] ?? false;
    
    $bannerIconEnabled = $c['banner_icon_enabled'] ?? false;
    $bannerIcon = $c['banner_icon'] ?? '';
    $bannerIconPosition = $c['banner_icon_position'] ?? 'top';
    $bannerIconSize = $c['banner_icon_size'] ?? 60;
@endphp

{{-- LINK DEL BANNER --}}
<div class="card shadow-sm mb-3">
    <div class="card-header" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-link-45deg me-2"></i>Link del Banner</h6>
    </div>
    <div class="card-body p-2">
        <div class="form-check form-switch mb-2">
            <input type="checkbox" name="banner_link_enabled" id="bannerLinkEnabled" class="form-check-input" role="switch" {{ $bannerLinkEnabled ? 'checked' : '' }}>
            <label class="form-check-label" for="bannerLinkEnabled">
                <strong>Hacer todo el banner clickeable</strong>
            </label>
        </div>
        
        <div id="bannerLinkControls" style="display: {{ $bannerLinkEnabled ? 'block' : 'none' }};">
            <label class="form-label small">URL del enlace</label>
            <input type="text" name="banner_link_url" id="bannerLinkUrl" class="form-control" value="{{ $bannerLinkUrl }}" placeholder="https://example.com">
            <div class="alert alert-info mt-2 mb-0 py-2" role="alert">
                <small><i class="bi bi-info-circle"></i> Al hacer clic en el banner, se abrirá este enlace</small>
            </div>
        </div>
    </div>
</div>

{{-- DIMENSIONES --}}
<div class="card shadow-sm mb-3">
    <div class="card-header" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-arrows-expand me-2"></i>Dimensiones del Banner</h6>
    </div>
    <div class="card-body p-2">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small">Ancho</label>
                <div class="input-group">
                    <input type="number" name="banner_width" id="bannerWidth" class="form-control" value="{{ $bannerWidth }}" min="300" max="800" step="10">
                    <span class="input-group-text">px</span>
                </div>
                <small class="text-muted">Recomendado: 600px para emails</small>
            </div>
            <div class="col-md-6">
                <label class="form-label small">Alto</label>
                <div class="input-group">
                    <input type="number" name="banner_height" id="bannerHeight" class="form-control" value="{{ $bannerHeight }}" min="50" max="600" step="10">
                    <span class="input-group-text">px</span>
                </div>
                <small class="text-muted">Alto del banner</small>
            </div>
        </div>
    </div>
</div>

{{-- FONDO --}}
<div class="card shadow-sm mb-3">
    <div class="card-header" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-palette-fill me-2"></i>Fondo del Banner</h6>
    </div>
    <div class="card-body p-2">
        
        {{-- Imagen de fondo --}}
        <div class="mb-3">
            <div class="form-check form-switch mb-2">
                <input type="checkbox" name="banner_bg_image_enabled" id="bannerBgImageEnabled" class="form-check-input" role="switch" {{ $bannerBgImageEnabled ? 'checked' : '' }}>
                <label class="form-check-label" for="bannerBgImageEnabled">
                    <strong>Usar imagen de fondo</strong>
                </label>
            </div>
            
            <div id="bannerBgImageControls" style="display: {{ $bannerBgImageEnabled ? 'block' : 'none' }};">
                <label class="form-label">Imagen de fondo (cubre todo el banner)</label>
                <input type="file" name="banner_bg_image" id="bannerBgImage" class="form-control" accept="image/*">
                @if(!empty($bannerBgImage))
                    <div class="mt-2 p-2 bg-light rounded text-center">
                        <img src="{{ asset('storage/'.$bannerBgImage) }}" 
                             data-current-bg-image="{{ asset('storage/'.$bannerBgImage) }}"
                             class="img-thumbnail" 
                             style="max-height: 150px;">
                        <p class="small text-muted mb-0 mt-1">Imagen actual</p>
                    </div>
                @endif
                <small class="text-muted d-block mt-1">
                    <i class="bi bi-info-circle"></i> La imagen cubrirá todo el ancho y alto del banner
                </small>
            </div>
        </div>

        <hr class="my-3">

        {{-- Color sólido --}}
        <div class="mb-3">
            <label class="form-label">Color de fondo sólido</label>
            <input type="color" name="banner_bg_color" id="bannerBgColor" class="form-control form-control-color w-100" value="{{ $bannerBgColor }}">
            <small class="text-muted">Se usa si no hay imagen de fondo ni gradiente</small>
        </div>

        {{-- Gradiente --}}
        <div class="form-check form-switch mb-3">
            <input type="checkbox" name="banner_gradient_enabled" id="bannerGradientEnabled" class="form-check-input" {{ $bannerGradientEnabled ? 'checked' : '' }}>
            <label class="form-check-label" for="bannerGradientEnabled">
                <strong>Usar degradado en lugar de color sólido</strong>
            </label>
        </div>

        <div id="bannerGradientControls" style="display: {{ $bannerGradientEnabled ? 'block' : 'none' }};">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small">Color inicial</label>
                    <input type="color" name="banner_gradient_color_1" id="bannerGradientColor1" class="form-control form-control-color w-100" value="{{ $bannerGradientColor1 }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Color final</label>
                    <input type="color" name="banner_gradient_color_2" id="bannerGradientColor2" class="form-control form-control-color w-100" value="{{ $bannerGradientColor2 }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label small">Dirección del degradado</label>
                <select name="banner_gradient_direction" id="bannerGradientDirection" class="form-select">
                    <option value="to right" {{ $bannerGradientDirection === 'to right' ? 'selected' : '' }}>→ Horizontal (izquierda a derecha)</option>
                    <option value="to left" {{ $bannerGradientDirection === 'to left' ? 'selected' : '' }}>← Horizontal (derecha a izquierda)</option>
                    <option value="to bottom" {{ $bannerGradientDirection === 'to bottom' ? 'selected' : '' }}>↓ Vertical (arriba a abajo)</option>
                    <option value="to top" {{ $bannerGradientDirection === 'to top' ? 'selected' : '' }}>↑ Vertical (abajo a arriba)</option>
                    <option value="to bottom right" {{ $bannerGradientDirection === 'to bottom right' ? 'selected' : '' }}>↘ Diagonal</option>
                    <option value="to bottom left" {{ $bannerGradientDirection === 'to bottom left' ? 'selected' : '' }}>↙ Diagonal</option>
                </select>
            </div>
        </div>

        <div class="alert alert-light mb-0 py-2">
            <small>
                <i class="bi bi-lightbulb"></i> <strong>Prioridad:</strong><br>
                1. Si hay imagen, se usa la imagen<br>
                2. Si no hay imagen pero hay gradiente, se usa el gradiente<br>
                3. Si no hay ni imagen ni gradiente, se usa el color sólido
            </small>
        </div>
    </div>
</div>

{{-- ICONO DECORATIVO --}}
<div class="card shadow-sm mb-3">
    <div class="card-header" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-star-fill me-2"></i>Icono Decorativo</h6>
    </div>
    <div class="card-body p-2">
        <div class="form-check form-switch mb-2">
            <input type="checkbox" name="banner_icon_enabled" id="bannerIconEnabled" class="form-check-input" role="switch" {{ $bannerIconEnabled ? 'checked' : '' }}>
            <label class="form-check-label" for="bannerIconEnabled">
                <strong>Incluir icono decorativo</strong>
            </label>
        </div>
        
        <div id="bannerIconControls" style="display: {{ $bannerIconEnabled ? 'block' : 'none' }};">
            <div class="mb-3">
                <label class="form-label small">Subir icono</label>
                <input type="file" name="banner_icon" id="bannerIcon" class="form-control" accept="image/*">
                <small class="text-muted">PNG o SVG con fondo transparente (recomendado)</small>
            </div>

            @if(!empty($bannerIcon))
                <div class="text-center mb-3 p-2 bg-light rounded">
                    <img src="{{ asset('storage/'.$bannerIcon) }}" 
                         data-current-icon="{{ asset('storage/'.$bannerIcon) }}"
                         class="img-thumbnail" 
                         style="max-width: 100px; max-height: 100px;">
                    <p class="small text-muted mb-0 mt-1">Icono actual</p>
                </div>
            @endif

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small">Posición</label>
                    <select name="banner_icon_position" id="bannerIconPosition" class="form-select">
                        <option value="top" {{ $bannerIconPosition === 'top' ? 'selected' : '' }}>⬆️ Arriba del texto</option>
                        <option value="left" {{ $bannerIconPosition === 'left' ? 'selected' : '' }}>⬅️ Izquierda del texto</option>
                        <option value="right" {{ $bannerIconPosition === 'right' ? 'selected' : '' }}>➡️ Derecha del texto</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Tamaño</label>
                    <div class="input-group">
                        <input type="number" name="banner_icon_size" id="bannerIconSize" class="form-control" value="{{ $bannerIconSize }}" min="30" max="150" step="5">
                        <span class="input-group-text">px</span>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning mb-0 py-2">
                <small>
                    <i class="bi bi-exclamation-triangle"></i> <strong>¡Importante!</strong><br>
                    • <strong>Imagen de fondo:</strong> Cubre todo el banner completo<br>
                    • <strong>Icono:</strong> Elemento pequeño decorativo junto al texto
                </small>
            </div>
        </div>
    </div>
</div>

{{-- CONTENIDO Y ESTILOS --}}
<div class="card shadow-sm mb-3">
    <div class="card-header" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-text-left me-2"></i>Contenido y Estilos</h6>
    </div>
    <div class="card-body p-2">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small">Alineación del texto</label>
                <select name="banner_text_align" id="bannerTextAlign" class="form-select">
                    <option value="left" {{ $bannerTextAlign === 'left' ? 'selected' : '' }}>⬅️ Izquierda</option>
                    <option value="center" {{ $bannerTextAlign === 'center' ? 'selected' : '' }}>⬌ Centro</option>
                    <option value="right" {{ $bannerTextAlign === 'right' ? 'selected' : '' }}>➡️ Derecha</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small">Padding interno</label>
                <div class="input-group">
                    <input type="number" name="banner_padding" id="bannerPadding" class="form-control" value="{{ $bannerPadding }}" min="0" max="100" step="5">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small">Radio de bordes</label>
            <div class="input-group">
                <input type="number" name="banner_border_radius" id="bannerBorderRadius" class="form-control" value="{{ $bannerBorderRadius }}" min="0" max="50" step="1">
                <span class="input-group-text">px</span>
            </div>
            <small class="text-muted">0 = esquinas rectas, valores mayores = más redondeado</small>
        </div>

        <hr class="my-3">

        <div class="mb-3">
            <label class="form-label small">Título del banner</label>
            <input type="text" name="banner_title" id="bannerTitle" class="form-control" value="{{ $c['banner_title'] ?? '' }}" placeholder="Título principal">
        </div>

        {{-- NUEVO: Color del título --}}
        <div class="mb-3">
            <label class="form-label small">Color del título</label>
            <input type="color" name="banner_title_color" id="bannerTitleColor" class="form-control form-control-color w-100" value="{{ $c['banner_title_color'] ?? '#ffffff' }}">
        </div>

        <div class="mb-3">
            <label class="form-label small">Subtítulo del banner</label>
            <textarea name="banner_subtitle" id="bannerSubtitle" class="form-control" rows="2" placeholder="Texto descriptivo">{{ $c['banner_subtitle'] ?? '' }}</textarea>
        </div>

        {{-- NUEVO: Color del subtítulo --}}
        <div class="mb-3">
            <label class="form-label small">Color del subtítulo</label>
            <input type="color" name="banner_subtitle_color" id="bannerSubtitleColor" class="form-control form-control-color w-100" value="{{ $c['banner_subtitle_color'] ?? '#ffffff' }}">
        </div>
    </div>
</div>
@endif
{{-- SOCIAL MEDIA --}}
@if($block->type==='social')
@php
    $socialItems = $c['social_content'] ?? [];
    $socialGap = $c['social_gap'] ?? 15;
    $socialIconSize = $c['social_icon_size'] ?? 40;
    $socialBorderRadius = $c['social_border_radius'] ?? 50;
    $socialAlign = $c['social_align'] ?? 'center';
    
    // Redes sociales disponibles con sus colores oficiales
    $availableNetworks = [
        'facebook' => ['name' => 'Facebook', 'icon' => 'bi-facebook', 'color' => '#1877F2'],
        'instagram' => ['name' => 'Instagram', 'icon' => 'bi-instagram', 'color' => '#E4405F'],
        'twitter' => ['name' => 'Twitter/X', 'icon' => 'bi-twitter-x', 'color' => '#000000'],
        'linkedin' => ['name' => 'LinkedIn', 'icon' => 'bi-linkedin', 'color' => '#0A66C2'],
        'youtube' => ['name' => 'YouTube', 'icon' => 'bi-youtube', 'color' => '#FF0000'],
        'tiktok' => ['name' => 'TikTok', 'icon' => 'bi-tiktok', 'color' => '#000000'],
        'whatsapp' => ['name' => 'WhatsApp', 'icon' => 'bi-whatsapp', 'color' => '#25D366'],
        'telegram' => ['name' => 'Telegram', 'icon' => 'bi-telegram', 'color' => '#26A5E4'],
        'pinterest' => ['name' => 'Pinterest', 'icon' => 'bi-pinterest', 'color' => '#E60023'],
        'snapchat' => ['name' => 'Snapchat', 'icon' => 'bi-snapchat', 'color' => '#FFFC00'],
        'discord' => ['name' => 'Discord', 'icon' => 'bi-discord', 'color' => '#5865F2'],
        'twitch' => ['name' => 'Twitch', 'icon' => 'bi-twitch', 'color' => '#9146FF'],
        'reddit' => ['name' => 'Reddit', 'icon' => 'bi-reddit', 'color' => '#FF4500'],
        'github' => ['name' => 'GitHub', 'icon' => 'bi-github', 'color' => '#181717'],
        'website' => ['name' => 'Sitio Web', 'icon' => 'bi-globe', 'color' => '#6c757d'],
        'email' => ['name' => 'Email', 'icon' => 'bi-envelope', 'color' => '#6c757d'],
    ];
@endphp

<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-share me-2"></i>Configuración de Redes Sociales</h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tamaño de iconos</label>
                <div class="input-group">
                    <input type="number" name="social_icon_size" id="socialIconSize" class="form-control" value="{{ $socialIconSize }}" min="20" max="80">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Espacio entre iconos</label>
                <div class="input-group">
                    <input type="number" name="social_gap" id="socialGap" class="form-control" value="{{ $socialGap }}" min="5" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Redondeo</label>
                <div class="input-group">
                    <input type="number" name="social_border_radius" id="socialBorderRadius" class="form-control" value="{{ $socialBorderRadius }}" min="0" max="50">
                    <span class="input-group-text">px</span>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Alineación</label>
                <select name="social_align" id="socialAlign" class="form-select">
                    <option value="left" {{ $socialAlign === 'left' ? 'selected' : '' }}>Izquierda</option>
                    <option value="center" {{ $socialAlign === 'center' ? 'selected' : '' }}>Centro</option>
                    <option value="right" {{ $socialAlign === 'right' ? 'selected' : '' }}>Derecha</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Social Media Items --}}
<div id="social-items" class="row g-3">
    @foreach($availableNetworks as $key => $network)
        @php
            $item = collect($socialItems)->firstWhere('network', $key) ?? [
                'network' => $key,
                'url' => '',
                'enabled' => false,
                'bg_color' => $network['color'],
                'icon_color' => '#ffffff',
                'border_color' => '#000000',
                'border_width' => 0
            ];
        @endphp
        
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="form-check form-switch me-2">
                            <input type="checkbox" name="social_content[{{ $key }}][enabled]" id="socialEnabled{{ $key }}" class="form-check-input social-enabled-checkbox" data-network="{{ $key }}" {{ $item['enabled'] ? 'checked' : '' }}>
                        </div>
                        <i class="bi {{ $network['icon'] }} me-2" style="font-size: 20px;"></i>
                        <h6 class="mb-0 fw-bold">{{ $network['name'] }}</h6>
                    </div>
                    
                    <input type="hidden" name="social_content[{{ $key }}][network]" value="{{ $key }}">
                    
                    <div class="social-controls" id="socialControls{{ $key }}" style="display:{{ $item['enabled'] ? 'block':'none' }};">
                        <div class="mb-2">
                            <label class="form-label small">URL / Enlace</label>
                            <input type="url" name="social_content[{{ $key }}][url]" id="socialUrl{{ $key }}" class="form-control form-control-sm social-url-input" data-network="{{ $key }}" value="{{ $item['url'] }}" placeholder="https://...">
                        </div>
                        
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label small">Color fondo</label>
                                <input type="color" name="social_content[{{ $key }}][bg_color]" id="socialBgColor{{ $key }}" class="form-control form-control-color w-100 social-bg-color" data-network="{{ $key }}" value="{{ $item['bg_color'] }}">
                            </div>
                            
                            <div class="col-6">
                                <label class="form-label small">Color icono</label>
                                <input type="color" name="social_content[{{ $key }}][icon_color]" id="socialIconColor{{ $key }}" class="form-control form-control-color w-100 social-icon-color" data-network="{{ $key }}" value="{{ $item['icon_color'] }}">
                            </div>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small">Color borde</label>
                                <input type="color" name="social_content[{{ $key }}][border_color]" id="socialBorderColor{{ $key }}" class="form-control form-control-color w-100 social-border-color" data-network="{{ $key }}" value="{{ $item['border_color'] }}">
                            </div>
                            
                            <div class="col-6">
                                <label class="form-label small">Ancho borde</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" name="social_content[{{ $key }}][border_width]" id="socialBorderWidth{{ $key }}" class="form-control social-border-width" data-network="{{ $key }}" value="{{ $item['border_width'] }}" min="0" max="10">
                                    <span class="input-group-text">px</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
{{-- INSTRUCTIVO --}}
@if($block->type==='instructivo')
@php
    $instructivoTitle = $c['instructivo_title'] ?? '';
    $instructivoTitleColor = $c['instructivo_title_color'] ?? '#c41e3a';
    $instructivoGeneralBgColor = $c['instructivo_general_bg_color'] ?? '#ffffff';
    $instructivoItems = $c['instructivo_items'] ?? [];
    $instructivoItemsCount = $c['instructivo_items_count'] ?? 3;
    $instructivoExtraMessage = $c['instructivo_extra_message'] ?? '';
    $instructivoButtons = $c['instructivo_buttons'] ?? [];
    $instructivoButtonsCount = $c['instructivo_buttons_count'] ?? 2;
@endphp

{{-- Título Principal --}}
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-list-check me-2"></i>Título del Instructivo</h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-9">
                <label class="form-label">Texto del título</label>
                <input type="text" name="instructivo_title" id="instructivoTitle" class="form-control" value="{{ $instructivoTitle }}" placeholder="Ej: Información del programa">
            </div>
            <div class="col-md-3">
                <label class="form-label">Color del título</label>
                <input type="color" name="instructivo_title_color" id="instructivoTitleColor" class="form-control form-control-color w-100" value="{{ $instructivoTitleColor }}">
            </div>
        </div>
    </div>
</div>

{{-- Color de Fondo General --}}
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-palette-fill me-2"></i>Estilo General del Bloque</h6>
    </div>
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Color de fondo general del bloque completo</label>
                <input type="color" name="instructivo_general_bg_color" id="instructivoGeneralBgColor" class="form-control form-control-color w-100" value="{{ $instructivoGeneralBgColor }}">
                <small class="text-muted">Este color se aplicará como fondo de todo el bloque del instructivo</small>
            </div>
        </div>
    </div>
</div>

{{-- Configuración de Items --}}
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-list-ul me-2"></i>Filas de Información</h6>
    </div>
    <div class="card-body p-3">
        <div class="mb-3">
            <label class="form-label">Número de filas</label>
            <select name="instructivo_items_count" id="instructivoItemsCount" class="form-select">
                @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}" {{ $instructivoItemsCount == $i ? 'selected' : '' }}>{{ $i }} Fila{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
        </div>

        <div id="instructivo-items-container">
            @for($i=0;$i<10;$i++)
                @php
                    $item = $instructivoItems[$i] ?? [
                        'label' => '',
                        'content' => '',
                        'bg_color' => '#f5f5f5'
                    ];
                @endphp
                <div class="card mb-2 instructivo-item" id="instructivoItem{{ $i }}" style="display: {{ $i < $instructivoItemsCount ? 'block' : 'none' }};">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <strong>Fila {{ $i + 1 }}</strong>
                            <input type="color" name="instructivo_items[{{ $i }}][bg_color]" id="instructivoBgColor{{ $i }}" class="form-control form-control-color instructivo-bg-color" data-index="{{ $i }}" value="{{ $item['bg_color'] }}" style="width: 60px;" title="Color de fondo de esta fila">
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Etiqueta (columna izquierda)</label>
                            <div class="btn-toolbar mb-1" role="toolbar">
                                <div class="btn-group me-2 mb-1" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoLabel{{ $i }}','bold')">
                                        <i class="bi bi-type-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoLabel{{ $i }}','italic')">
                                        <i class="bi bi-type-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoLabel{{ $i }}','underline')">
                                        <i class="bi bi-type-underline"></i>
                                    </button>
                                </div>
                                <div class="btn-group mb-1" role="group">
                                    <select onchange="setInstructivoTextSize('instructivoLabel{{ $i }}', this.value)" class="form-select form-select-sm" style="width: auto;">
                                        <option value="">Tamaño</option>
                                        @foreach($allowedSizes as $size)
                                            <option value="{{ $size }}">{{ $size }}px</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openInstructivoColorPicker('instructivoLabel{{ $i }}','instructivoLabelInput{{ $i }}')">
                                        <i class="bi bi-palette"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="instructivoLabel{{ $i }}" contenteditable="true" class="form-control instructivo-label" data-index="{{ $i }}" style="min-height:40px; word-wrap:break-word; white-space:pre-wrap;">{!! $item['label'] ?? '' !!}</div>
                            <input type="hidden" name="instructivo_items[{{ $i }}][label]" id="instructivoLabelInput{{ $i }}" value="{{ $item['label'] ?? '' }}">
                        </div>

                        <div class="mb-0">
                            <label class="form-label small">Contenido (columna derecha)</label>
                            <div class="btn-toolbar mb-1" role="toolbar">
                                <div class="btn-group me-2 mb-1" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoContent{{ $i }}','bold')">
                                        <i class="bi bi-type-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoContent{{ $i }}','italic')">
                                        <i class="bi bi-type-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoContent{{ $i }}','underline')">
                                        <i class="bi bi-type-underline"></i>
                                    </button>
                                </div>
                                <div class="btn-group me-2 mb-1" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoContent{{ $i }}','insertUnorderedList')">
                                        <i class="bi bi-list-ul"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoContent{{ $i }}','insertOrderedList')">
                                        <i class="bi bi-list-ol"></i>
                                    </button>
                                </div>
                                <div class="btn-group mb-1" role="group">
                                    <select onchange="setInstructivoTextSize('instructivoContent{{ $i }}', this.value)" class="form-select form-select-sm" style="width: auto;">
                                        <option value="">Tamaño</option>
                                        <option value="12">12px</option>
                                        <option value="14">14px</option>
                                        <option value="16">16px</option>
                                        <option value="18">18px</option>
                                        <option value="20">20px</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openInstructivoColorPicker('instructivoContent{{ $i }}','instructivoContentInput{{ $i }}')">
                                        <i class="bi bi-palette"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="instructivoContent{{ $i }}" contenteditable="true" class="form-control instructivo-content" data-index="{{ $i }}" style="min-height:40px; word-wrap:break-word; white-space:pre-wrap;">{!! $item['content'] ?? '' !!}</div>
                            <input type="hidden" name="instructivo_items[{{ $i }}][content]" id="instructivoContentInput{{ $i }}" value="{{ $item['content'] ?? '' }}">
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

{{-- Mensaje Extra --}}
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-chat-left-text me-2"></i>Mensaje Extra</h6>
    </div>
    <div class="card-body p-3">
        <div class="btn-toolbar mb-2" role="toolbar">
            <div class="btn-group me-2 mb-1" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoExtraMessage','bold')">
                    <i class="bi bi-type-bold"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoExtraMessage','italic')">
                    <i class="bi bi-type-italic"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoExtraMessage','underline')">
                    <i class="bi bi-type-underline"></i>
                </button>
            </div>
            <div class="btn-group me-2 mb-1" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoExtraMessage','justifyLeft')">
                    <i class="bi bi-text-left"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoExtraMessage','justifyCenter')">
                    <i class="bi bi-text-center"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatInstructivoContent('instructivoExtraMessage','justifyRight')">
                    <i class="bi bi-text-right"></i>
                </button>
            </div>
            <div class="btn-group mb-1" role="group">
                <select onchange="setInstructivoTextSize('instructivoExtraMessage', this.value)" class="form-select form-select-sm" style="width: auto;">
                    <option value="">Tamaño</option>
                    <option value="12">12px</option>
                    <option value="14">14px</option>
                    <option value="16">16px</option>
                    <option value="18">18px</option>
                    <option value="20">20px</option>
                </select>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="openInstructivoColorPicker('instructivoExtraMessage','instructivoExtraMessageInput')">
                    <i class="bi bi-palette"></i>
                </button>
            </div>
        </div>
        <div id="instructivoExtraMessage" contenteditable="true" class="form-control" style="min-height:80px; word-wrap:break-word; white-space:pre-wrap;">{!! $instructivoExtraMessage !!}</div>
        <input type="hidden" name="instructivo_extra_message" id="instructivoExtraMessageInput" value="{{ $instructivoExtraMessage }}">
    </div>
</div>

{{-- Botones --}}
<div class="card shadow-sm mb-3">
    <div class="card-header text-white" style="background-color: #3a57e8; color: white !important; padding:15px !important;">
        <h6 class="mb-0" style="color: white !important;"><i class="bi bi-hand-index me-2"></i>Botones de Acción</h6>
    </div>
    <div class="card-body p-3">
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="instructivoShowButtons" name="instructivo_show_buttons" value="1" {{ ($c['instructivo_show_buttons'] ?? 0) ? 'checked' : '' }}>
                <label class="form-check-label" for="instructivoShowButtons">
                    <strong>Mostrar botones</strong>
                </label>
            </div>
        </div>

        <div id="instructivoButtonsConfig" style="display: {{ ($c['instructivo_show_buttons'] ?? 0) ? 'block' : 'none' }};">
            <div class="mb-3">
                <label class="form-label">Número de botones</label>
                <select name="instructivo_buttons_count" id="instructivoButtonsCount" class="form-select">
                    @for($i=1;$i<=4;$i++)
                        <option value="{{ $i }}" {{ $instructivoButtonsCount == $i ? 'selected' : '' }}>{{ $i }} Botón{{ $i != 1 ? 'es' : '' }}</option>
                    @endfor
                </select>
            </div>

        <div id="instructivo-buttons-container">
            @for($i=0;$i<4;$i++)
                @php
                    $btn = $instructivoButtons[$i] ?? [
                        'text' => '',
                        'url' => '',
                        'style' => 'solid',
                        'bg_color' => '#c41e3a',
                        'text_color' => '#ffffff',
                        'border_color' => '#c41e3a'
                    ];
                @endphp
                <div class="card mb-2 instructivo-button-item" id="instructivoButton{{ $i }}" style="display: {{ $i < $instructivoButtonsCount ? 'block' : 'none' }};">
                    <div class="card-body p-3">
                        <strong class="d-block mb-2">Botón {{ $i + 1 }}</strong>
                        
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label small">Texto del botón</label>
                                <input type="text" name="instructivo_buttons[{{ $i }}][text]" id="instructivoButtonText{{ $i }}" class="form-control instructivo-button-text" data-index="{{ $i }}" value="{{ $btn['text'] }}" placeholder="Ej: Descarga la malla">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">URL del enlace</label>
                                <input type="url" name="instructivo_buttons[{{ $i }}][url]" id="instructivoButtonUrl{{ $i }}" class="form-control instructivo-button-url" data-index="{{ $i }}" value="{{ $btn['url'] }}" placeholder="https://...">
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label small">Estilo</label>
                                <select name="instructivo_buttons[{{ $i }}][style]" id="instructivoButtonStyle{{ $i }}" class="form-select form-select-sm instructivo-button-style" data-index="{{ $i }}">
                                    <option value="solid" {{ $btn['style'] == 'solid' ? 'selected' : '' }}>Sólido</option>
                                    <option value="outline" {{ $btn['style'] == 'outline' ? 'selected' : '' }}>Solo borde</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Color fondo</label>
                                <input type="color" name="instructivo_buttons[{{ $i }}][bg_color]" id="instructivoButtonBg{{ $i }}" class="form-control form-control-color w-100 instructivo-button-bg" data-index="{{ $i }}" value="{{ $btn['bg_color'] }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Color texto</label>
                                <input type="color" name="instructivo_buttons[{{ $i }}][text_color]" id="instructivoButtonTextColor{{ $i }}" class="form-control form-control-color w-100 instructivo-button-text-color" data-index="{{ $i }}" value="{{ $btn['text_color'] }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Color borde</label>
                                <input type="color" name="instructivo_buttons[{{ $i }}][border_color]" id="instructivoButtonBorder{{ $i }}" class="form-control form-control-color w-100 instructivo-button-border" data-index="{{ $i }}" value="{{ $btn['border_color'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        </div>
    </div>
</div>
@endif
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        <a href="{{ route('blocks.list', $campaign->id) }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>

    {{-- PREVIEW --}}
    <div class="mt-5">
        <h4>Previsualización</h4>
        <div id="preview" class="border p-3"></div>
    </div>
</div>

<input type="color" id="colorPicker" style="display:none;">


<script>
const preview = document.getElementById('preview');
const colorPicker = document.getElementById('colorPicker');

function validateImageSize(file, callback) {
    const img = new Image();
    img.onload = function() {
        const width = this.width;
        const height = this.height;
        
        if (width > 600 || height > 600) {
            alert('La imagen no puede tener más de 600px de ancho o alto. Dimensiones actuales: ' + width + 'x' + height + 'px');
            callback(false);
        } else {
            callback(true);
        }
    };
    img.onerror = function() {
        alert('Error al cargar la imagen');
        callback(false);
    };
    img.src = URL.createObjectURL(file);
}

// --- FORMATO TEXTO --- 
function formatContent(id, command){
    const el = document.getElementById(id);
    el.focus();
    
    // Preserve font sizes before formatting
    preserveFontSizes(el);
    
    document.execCommand(command, false, null);
    
    // Restore font sizes after formatting
    const elementsWithFontSize = el.querySelectorAll('[data-font-size]');
    elementsWithFontSize.forEach(element => {
        const fontSize = element.getAttribute('data-font-size');
        if (fontSize) {
            element.style.fontSize = fontSize;
            element.removeAttribute('data-font-size');
        }
    });
    
    updatePreview();
}

function setTextSize(id, size) {
    if (!size) return;
    const el = document.getElementById(id);
    
    // Focus the element first
    el.focus();
    
    // Remove any existing font size styling
    el.style.fontSize = '';
    
    // Apply the new font size using execCommand for better compatibility
    document.execCommand('fontSize', false, '7'); // Use a dummy value first
    
    // Then override with our custom size
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        // If there's a selection, apply to selection
        const range = selection.getRangeAt(0);
        if (!range.collapsed) {
            document.execCommand('fontSize', false, '7');
            // Find all font elements and replace with our size
            const fontElements = el.querySelectorAll('font[size="7"]');
            fontElements.forEach(font => {
                font.style.fontSize = size + 'px';
                font.removeAttribute('size');
            });
        } else {
            // No selection, apply to entire element
            el.style.fontSize = size + 'px';
        }
    } else {
        // Fallback: apply to entire element
        el.style.fontSize = size + 'px';
    }
    
    // Update hidden input
    const inputId = id.replace('Editable', 'Input');
    const hiddenInput = document.getElementById(inputId);
    if (hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function setTextStyle(id, style) {
    if (!style) return;
    const el = document.getElementById(id);
    
    // Remove existing heading classes
    el.classList.remove('h1-style', 'h2-style', 'body-style');
    
    // Apply new style
    switch(style) {
        case 'h1':
            el.classList.add('h1-style');
            el.style.fontSize = '2rem';
            el.style.fontWeight = 'bold';
            break;
        case 'h2':
            el.classList.add('h2-style');
            el.style.fontSize = '1.5rem';
            el.style.fontWeight = 'bold';
            break;
        case 'body':
            el.classList.add('body-style');
            el.style.fontSize = '1rem';
            el.style.fontWeight = 'normal';
            break;
    }
    
    const inputId = id.replace('Editable', 'Input');
    const hiddenInput = document.getElementById(inputId);
    if (hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}
function applyColorToList(el, color) {
    const lists = el.querySelectorAll('ul, ol');
    lists.forEach(list => {
        list.querySelectorAll('li').forEach(li => {
            li.style.color = color; // fuerza el color en cada li
        });
    });
}


function openColorPicker(id, inputId){
    const el = document.getElementById(id);
    el.focus();

    colorPicker.oninput = e => {
        const color = e.target.value;

        // Aplica color al texto seleccionado
        document.execCommand('foreColor', false, color);

        // Aplica color a todas las listas existentes
        applyColorToList(el, color);

        // Guardar en hidden input
        const hiddenInput = document.getElementById(inputId);
        if(hiddenInput){
            hiddenInput.value = el.innerHTML;
        }

        updatePreview();
    }

    colorPicker.click();
}


function formatGridContent(id, command) {
    const el = document.getElementById(id);
    el.focus();
    
    // Preserve font sizes before formatting
    preserveFontSizes(el);
    
    document.execCommand(command, false, null);
    
    // Restore font sizes after formatting
    const elementsWithFontSize = el.querySelectorAll('[data-font-size]');
    elementsWithFontSize.forEach(element => {
        const fontSize = element.getAttribute('data-font-size');
        if (fontSize) {
            element.style.fontSize = fontSize;
            element.removeAttribute('data-font-size');
        }
    });
    
    const inputId = id.replace('gridText', 'gridInput');
    document.getElementById(inputId).value = el.innerHTML;
    updatePreview();
}

function setGridTextStyle(id, style) {
    if (!style) return;
    const el = document.getElementById(id);
    
    el.classList.remove('h1-style', 'h2-style', 'body-style');
    
    switch(style) {
        case 'h1':
            el.classList.add('h1-style');
            el.style.fontSize = '2rem';
            el.style.fontWeight = 'bold';
            break;
        case 'h2':
            el.classList.add('h2-style');
            el.style.fontSize = '1.5rem';
            el.style.fontWeight = 'bold';
            break;
        case 'body':
            el.classList.add('body-style');
            el.style.fontSize = '1rem';
            el.style.fontWeight = 'normal';
            break;
    }
    
    const inputId = id.replace('gridText', 'gridInput');
    document.getElementById(inputId).value = el.innerHTML;
    updatePreview();
}

function setGridTextSize(id, size) {
    if (!size) return;
    const el = document.getElementById(id);
    
    // Focus the element first
    el.focus();
    
    // Remove any existing font size styling
    el.style.fontSize = '';
    
    // Apply the new font size using execCommand for better compatibility
    document.execCommand('fontSize', false, '7'); // Use a dummy value first
    
    // Then override with our custom size
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        // If there's a selection, apply to selection
        const range = selection.getRangeAt(0);
        if (!range.collapsed) {
            document.execCommand('fontSize', false, '7');
            // Find all font elements and replace with our size
            const fontElements = el.querySelectorAll('font[size="7"]');
            fontElements.forEach(font => {
                font.style.fontSize = size + 'px';
                font.removeAttribute('size');
            });
        } else {
            // No selection, apply to entire element
            el.style.fontSize = size + 'px';
        }
    } else {
        // Fallback: apply to entire element
        el.style.fontSize = size + 'px';
    }
    
    // Update hidden input
    const inputId = id.replace('gridText', 'gridInput');
    const hiddenInput = document.getElementById(inputId);
    if (hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function openGridColorPicker(id, inputId) {
    const el = document.getElementById(id);
    el.focus();

    colorPicker.oninput = e => {
        const color = e.target.value;
        document.execCommand('foreColor', false, color);
        document.getElementById(inputId).value = el.innerHTML;
        updatePreview();
    }

    colorPicker.click();
}

// --- LOGO --- 
const logoSelector = document.getElementById('logoSelector');
const logoWidthInput = document.getElementById('logoWidth');
const logoAlignSelect = document.getElementById('logoAlign');
[logoSelector, logoWidthInput, logoAlignSelect].forEach(el=>{if(el) el.addEventListener('input', updatePreview);});

function updateLogoPreview() {
    if(!logoSelector) return;

    const logo = logoSelector.value;
    const width = logoWidthInput.value;
    const align = logoAlignSelect.value;

    const logoPath = `{{ asset('img') }}/${logo}`;
    const background = logo === 'blanco.png' ? '#333' : 'transparent';

    preview.innerHTML = `` 
        + `<div id="previewLogo" style="text-align:${align}; background:${background}; padding: 20px;">`
        + `    <img id="previewLogoImg" src="${logoPath}" style="width:${width}px; height:auto;">`
        + `</div>`; 
}

// --- TEXTO --- 
['title','subtitle','message'].forEach(type=> {
    const el = document.getElementById(type+"Editable");
    if(el) {
        // Event listener para cambios
        el.addEventListener('input', ()=> {
            let content = el.innerHTML;
            
            // Limpiar underline HTML
            content = cleanUnderlineHTML(content);
            
            document.getElementById(type+"Input").value = content;
            updatePreview();
        });
        
        // Event listener para blur (cuando el usuario sale del campo)
        el.addEventListener('blur', ()=> {
            let content = el.innerHTML;
            content = cleanUnderlineHTML(content);
            document.getElementById(type+"Input").value = content;
            
            // Actualizar el estado del underline input
            const underlineInput = document.getElementById(type + '_underline');
            if (underlineInput) {
                // Verificar si hay elementos con underline
                const hasUnderline = el.querySelector('u, [style*="text-decoration: underline"]') !== null;
                underlineInput.value = hasUnderline ? 'underline' : 'none';
            }
        });
        
        // Aplicar estilos iniciales si existen
        const colorInput = document.getElementById(type + '_color');
        const bgColorInput = document.getElementById(type + '_bgcolor');
        const sizeInput = document.getElementById(type + '_size');
        const alignInput = document.getElementById(type + '_align');
        const boldInput = document.getElementById(type + '_bold');
        const italicInput = document.getElementById(type + '_italic');
        const underlineInput = document.getElementById(type + '_underline');
        
        // Aplicar color de texto
        if(colorInput && colorInput.value) {
            el.style.color = colorInput.value;
        }
        
        // Aplicar color de fondo
        if(bgColorInput && bgColorInput.value && bgColorInput.value !== 'transparent') {
            el.style.backgroundColor = bgColorInput.value;
        }
        
        // Aplicar tamaño de fuente
        if(sizeInput && sizeInput.value) {
            el.style.fontSize = sizeInput.value;
        }
        
        // Aplicar alineación
        if(alignInput && alignInput.value) {
            el.style.textAlign = alignInput.value;
        }
        
        // Aplicar negrita
        if(boldInput && boldInput.value && boldInput.value !== 'normal') {
            el.style.fontWeight = boldInput.value;
        }
        
        // Aplicar cursiva
        if(italicInput && italicInput.value && italicInput.value !== 'normal') {
            el.style.fontStyle = italicInput.value;
        }
        
        // Aplicar subrayado inicial si existe en el contenido
        if(el.innerHTML) {
            // Buscar elementos con underline
            const uElements = el.querySelectorAll('u');
            uElements.forEach(u => {
                u.style.textDecoration = 'underline';
                u.style.textDecorationLine = 'underline';
            });
            
            const spanUnderline = el.querySelectorAll('span[style*="text-decoration"]');
            spanUnderline.forEach(span => {
                if (span.style.textDecoration.includes('underline')) {
                    span.style.textDecorationLine = 'underline';
                }
            });
        }
    }
});

function formatContent(editableId, command) {
    const editable = document.getElementById(editableId);
    if (!editable) return;
    
    const type = editableId.replace('Editable', '');
    
    editable.focus();
    
    // Guardar tamaños de fuente antes de formatear
    preserveFontSizes(editable);
    
    // Para underline, usar un enfoque diferente
    if (command === 'underline') {
        const selection = window.getSelection();
        
        // Verificar estado actual
        const isCurrentlyUnderlined = document.queryCommandState('underline');
        
        // Aplicar el comando
        document.execCommand('underline', false, null);
        
        // Actualizar el input hidden inmediatamente
        const underlineInput = document.getElementById(type + '_underline');
        if (underlineInput) {
            // Invertir el estado
            underlineInput.value = !isCurrentlyUnderlined ? 'underline' : 'none';
        }
        
        // Forzar el estilo en elementos con tag U
        setTimeout(() => {
            const uElements = editable.querySelectorAll('u');
            uElements.forEach(u => {
                u.style.textDecoration = 'underline';
                u.style.textDecorationLine = 'underline';
            });
        }, 10);
        
    } else {
        // Para otros comandos (bold, italic, justify, etc)
        document.execCommand(command, false, null);
    }
    
    // Restaurar tamaños de fuente
    const elementsWithFontSize = editable.querySelectorAll('[data-font-size]');
    elementsWithFontSize.forEach(element => {
        const fontSize = element.getAttribute('data-font-size');
        if (fontSize) {
            element.style.fontSize = fontSize;
            element.removeAttribute('data-font-size');
        }
    });
    
    // Para alineación
    if (command.includes('justify')) {
        let alignValue = 'left';
        
        if (command === 'justifyCenter') alignValue = 'center';
        else if (command === 'justifyRight') alignValue = 'right';
        else if (command === 'justifyLeft') alignValue = 'left';
        
        const alignInput = document.getElementById(type + '_align');
        if (alignInput) {
            alignInput.value = alignValue;
        }
        
        editable.style.textAlign = alignValue;
    }
    
    // Para bold
    if (command === 'bold') {
        const boldInput = document.getElementById(type + '_bold');
        if (boldInput) {
            boldInput.value = document.queryCommandState('bold') ? 'bold' : 'normal';
        }
    }
    
    // Para italic
    if (command === 'italic') {
        const italicInput = document.getElementById(type + '_italic');
        if (italicInput) {
            italicInput.value = document.queryCommandState('italic') ? 'italic' : 'normal';
        }
    }
    
    // Actualizar input hidden con el contenido
    document.getElementById(type + 'Input').value = editable.innerHTML;
    
    updatePreview();
}
function cleanUnderlineHTML(html) {
    // Convertir tags <u> a spans con estilo inline
    html = html.replace(/<u([^>]*)>/g, '<span style="text-decoration: underline; text-decoration-line: underline;"$1>');
    html = html.replace(/<\/u>/g, '</span>');
    
    return html;
}

function applyTextColor(type, color) {
    document.getElementById(type + '_color').value = color;
    const editable = document.getElementById(type + 'Editable');
    if (editable) {
        // Aplicar color al contenido seleccionado o a todo el div
        editable.focus();
        const selection = window.getSelection();
        
        if (selection.rangeCount > 0 && !selection.isCollapsed) {
            // Si hay texto seleccionado, aplicar solo a la selección
            document.execCommand('foreColor', false, color);
        } else {
            // Si no hay selección, aplicar a todo el contenido
            editable.style.color = color;
            // También aplicar a todos los elementos hijos
            const allElements = editable.querySelectorAll('*');
            allElements.forEach(el => {
                el.style.color = color;
            });
        }
        
        // Actualizar el input hidden
        document.getElementById(type + 'Input').value = editable.innerHTML;
    }
    updatePreview();
}

function applyBgColor(type, color) {
    document.getElementById(type + '_bgcolor').value = color;
    const editable = document.getElementById(type + 'Editable');
    if (editable) {
        editable.style.backgroundColor = color;
        // Actualizar el input hidden
        document.getElementById(type + 'Input').value = editable.innerHTML;
    }
    updatePreview();
}

function clearBgColor(type) {
    document.getElementById(type + '_bgcolor').value = 'transparent';
    document.getElementById(type + '_bgcolorPicker').value = '#ffffff';
    const editable = document.getElementById(type + 'Editable');
    if (editable) {
        editable.style.backgroundColor = 'transparent';
        // Actualizar el input hidden
        document.getElementById(type + 'Input').value = editable.innerHTML;
    }
    updatePreview();
}

function setTextSize(id, size) {
    if (!size) return;
    const el = document.getElementById(id);
    if (!el) return;
    
    el.focus();
    
    const selection = window.getSelection();
    if (selection.rangeCount > 0 && !selection.isCollapsed) {
        // Hay texto seleccionado
        document.execCommand('fontSize', false, '7');
        const fontElements = el.querySelectorAll('font[size="7"]');
        fontElements.forEach(font => {
            const span = document.createElement('span');
            span.style.fontSize = size + 'px';
            span.innerHTML = font.innerHTML;
            font.parentNode.replaceChild(span, font);
        });
    } else {
        // No hay selección, aplicar a todo
        el.style.fontSize = size + 'px';
        // Aplicar también a elementos internos
        const allElements = el.querySelectorAll('*');
        allElements.forEach(elem => {
            elem.style.fontSize = size + 'px';
        });
    }
    
    // Guardar en input hidden
    const type = id.replace('Editable', '');
    const sizeInput = document.getElementById(type + '_size');
    if (sizeInput) {
        sizeInput.value = size + 'px';
    }
    
    const inputId = id.replace('Editable', 'Input');
    const hiddenInput = document.getElementById(inputId);
    if (hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function preserveFontSizes(element) {
    const elementsWithFontSize = element.querySelectorAll('[style*="font-size"]');
    elementsWithFontSize.forEach(el => {
        const fontSize = el.style.fontSize;
        if (fontSize) {
            el.setAttribute('data-font-size', fontSize);
        }
    });
}

function getTextHTML(){
    let html=''; 
    ['title','subtitle','message'].forEach(type=> {
        const input = document.getElementById(type+"Input");
        if(input && input.value.trim()!=='') {
            html+=`<div class="text-content text-truncate-words">${input.value}</div>`; 
        }
    });
    return html;
}
// --- BOTÓN --- 
['buttonText','buttonLink','buttonColor','buttonTextColor','buttonFontSize','buttonBorderRadius',
 'buttonBold','buttonItalic','buttonUnderline','buttonBorderWidth','buttonBorderColor',
 'buttonBorderEnabled','buttonBorderStyle'].forEach(id=> {
    const el = document.getElementById(id); 
    if(el) el.addEventListener('input', updatePreview);
    if(el) el.addEventListener('change', updatePreview);
});

function getButtonHTML(){
    const text = document.getElementById('buttonText')?.value || 'Click aquí';
    const link = document.getElementById('buttonLink')?.value || '#';
    const color = document.getElementById('buttonColor')?.value || '#0d6efd';
    const textColor = document.getElementById('buttonTextColor')?.value || '#ffffff';
    const fontSize = document.getElementById('buttonFontSize')?.value || 16;
    const borderRadius = document.getElementById('buttonBorderRadius')?.value || 4;
    const bold = document.getElementById('buttonBold')?.checked || false;
    const italic = document.getElementById('buttonItalic')?.checked || false;
    const underline = document.getElementById('buttonUnderline')?.checked || false;
    const borderEnabled = document.getElementById('buttonBorderEnabled')?.checked || false;
    const borderWidth = document.getElementById('buttonBorderWidth')?.value || 0;
    const borderColor = document.getElementById('buttonBorderColor')?.value || '#000000';
    const borderStyle = document.getElementById('buttonBorderStyle')?.value || 'solid';

    let textDecoration = 'none';
    if(underline) textDecoration = 'underline';

    let border = 'none';
    if(borderEnabled && borderWidth > 0) {
        border = `${borderWidth}px ${borderStyle} ${borderColor}`;
    }

    return `<a href="${link}" style="display:inline-block;padding:10px 20px;background-color:${color};color:${textColor};font-size:${fontSize}px;text-decoration:${textDecoration};border-radius:${borderRadius}px;font-weight:${bold?'bold':'normal'};font-style:${italic?'italic':'normal'};border:${border};">${text}</a>`; 
}
// --- IMAGEN --- 
const imageFile = document.getElementById('imageFile');
const imageWidth = document.getElementById('imageWidth');
const imageHeight = document.getElementById('imageHeight');
const imageBorderColor = document.getElementById('imageBorderColor');
const imageBorderWidth = document.getElementById('imageBorderWidth');
const imageBorderRadius = document.getElementById('imageBorderRadius');
const imagePreviewEl = document.getElementById('imagePreview');

// Radio buttons para alineación
const imageAlignRadios = document.querySelectorAll('input[name="image_align"]');

if(imageFile) {
    imageFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if(file) {
            validateImageSize(file, function(isValid) {
                if(!isValid) {
                    e.target.value = '';
                    return;
                }
                // Mostrar preview del archivo seleccionado
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreviewEl.src = e.target.result;
                    imagePreviewEl.style.display = 'block';
                    updatePreview();
                }
                reader.readAsDataURL(file);
            });
        }
    });
}

// Listeners para todos los controles
[imageWidth, imageHeight, imageBorderColor, imageBorderWidth, imageBorderRadius].forEach(el => {
    if(el) {
        el.addEventListener('input', updatePreview); 
        el.addEventListener('change', updatePreview);
    }
});

// Listener para radio buttons de alineación
imageAlignRadios.forEach(radio => {
    radio.addEventListener('change', updatePreview);
});

function getImageAlign() {
    const checkedRadio = document.querySelector('input[name="image_align"]:checked');
    return checkedRadio ? checkedRadio.value : 'center';
}

function getImageHTML() {
    if(!imagePreviewEl) return '';
    
    const width = imageWidth?.value || 300;
    const height = imageHeight?.value || '';
    const align = getImageAlign();
    const borderColor = imageBorderColor?.value || '#000';
    const borderWidth = imageBorderWidth?.value || 0;
    const borderRadius = imageBorderRadius?.value || 0;

    // Build style string
    let imageStyle = `max-width:100%;width:${width}px;display:block;`;
    if(height && height.trim() !== '') {
        imageStyle += `height:${height}px;`;
    } else {
        imageStyle += `height:auto;`;
    }
    imageStyle += `border:${borderWidth}px solid ${borderColor};border-radius:${borderRadius}px;`;
    
    // Agregar margin según alineación
    if(align === 'center') {
        imageStyle += 'margin:0 auto;';
    } else if(align === 'right') {
        imageStyle += 'margin-left:auto;margin-right:0;';
    } else {
        imageStyle += 'margin-left:0;margin-right:auto;';
    }

    // Si hay un archivo nuevo seleccionado
    if(imageFile && imageFile.files.length > 0) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.innerHTML = `<div style="text-align:${align};"><img src="${e.target.result}" style="${imageStyle}"></div>`; 
        }
        reader.readAsDataURL(imageFile.files[0]);
        return '';
    } 
    // Si hay una imagen existente
    else if(imagePreviewEl.src && imagePreviewEl.src !== '') {
        return `<div style="text-align:${align};"><img src="${imagePreviewEl.src}" style="${imageStyle}"></div>`; 
    }
    
    return '';
}
/// --- GRID --- 
function getColumnClass(columns) {
    switch(columns) {
        case 2:
            return 'col-12 col-md-6';
        case 3:
            return 'col-12 col-md-4';
        default:
            return 'col-12 col-md-6';
    }
}

function setupGridListeners(){
    const gridColumns = document.getElementById('gridColumns');
    const gridGap = document.getElementById('gridGap');
    const gridBorderRadius = document.getElementById('gridBorderRadius');
    
    // Column selector listener
    if(gridColumns) {
        gridColumns.addEventListener('change', function() {
            const selectedColumns = parseInt(this.value);
            
            // Show/hide columns based on selection
            for(let i = 0; i < 3; i++) {
                const columnEl = document.getElementById('gridColumn' + i);
                if(columnEl) {
                    columnEl.style.display = i < selectedColumns ? 'block' : 'none';
                    
                    // Update Bootstrap classes for proper responsive behavior
                    if(i < selectedColumns) {
                        const newClass = getColumnClass(selectedColumns) + ' grid-column';
                        columnEl.className = newClass;
                    }
                }
            }
            
            updatePreview();
        });
        
        // Trigger inicial para configurar las clases correctas
        const initialColumns = parseInt(gridColumns.value) || 2;
        for(let i = 0; i < 3; i++) {
            const columnEl = document.getElementById('gridColumn' + i);
            if(columnEl) {
                const newClass = getColumnClass(initialColumns) + ' grid-column';
                columnEl.className = newClass;
            }
        }
    }
    
    if(gridGap) {
        gridGap.addEventListener('input', function() {
            this.setAttribute('data-changed', 'true');
            updatePreview();
        });
        gridGap.addEventListener('change', function() {
            this.setAttribute('data-changed', 'true');
            updatePreview();
        });
    }
    
    if(gridBorderRadius) {
        gridBorderRadius.addEventListener('input', function() {
            this.setAttribute('data-changed', 'true');
            updatePreview();
        });
        gridBorderRadius.addEventListener('change', function() {
            this.setAttribute('data-changed', 'true');
            updatePreview();
        });
    }
    
    // Set up listeners for all 3 possible columns (even if hidden initially)
    for(let i=0;i<3;i++){
        // Type checkboxes
        const typeCheckboxes = document.querySelectorAll(`.grid-type-checkbox[data-index="${i}"]`);
        typeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const textControls = document.getElementById('textControls'+i);
                const imageControls = document.getElementById('imageControls'+i);
                const buttonControls = document.getElementById('buttonControls'+i);
                
                const checkedTypes = Array.from(typeCheckboxes).filter(cb => cb.checked).map(cb => cb.value);
                
                // Verificar que los elementos existen antes de aplicar estilos
                if(textControls) textControls.style.display = checkedTypes.includes('text') ? 'block' : 'none';
                if(imageControls) imageControls.style.display = checkedTypes.includes('image') ? 'block' : 'none';
                if(buttonControls) buttonControls.style.display = checkedTypes.includes('button') ? 'block' : 'none';
                
                updatePreview();
            });
        });

        const textDiv=document.getElementById('gridText'+i);
        const textInput=document.getElementById('gridInput'+i);
        const imageInput=document.querySelector(`input[name="grid_content[${i}][image]"]`);
        const bgColorInput=document.getElementById('gridBgColor'+i);

        if(bgColorInput) {
            bgColorInput.addEventListener('input', updatePreview);
            bgColorInput.addEventListener('change', updatePreview);
        }

        // Listeners para todos los controles de botón - INCLUYENDO BORDE
        ['gridButtonText','gridButtonLink','gridButtonBgColor','gridButtonTextColor','gridButtonFontSize','gridButtonBorderRadius','gridButtonBorderColor','gridButtonBorderWidth','gridButtonBold','gridButtonItalic','gridButtonUnderline'].forEach(prefix => {
            const el = document.getElementById(prefix + i);
            if(el) {
                el.addEventListener('input', updatePreview);
                el.addEventListener('change', updatePreview);
            }
        });

        // Agregar listeners específicos para los radio buttons de alineación de botón
        ['gridButtonAlignLeft','gridButtonAlignCenter','gridButtonAlignRight'].forEach(id => {
            const el = document.getElementById(id + i);
            if(el) {
                el.addEventListener('change', updatePreview);
            }
        });

        // Listeners para todos los controles de imagen - incluyendo ancho y alto
        ['gridImageAlign','gridImageBorderColor','gridImageBorderWidth','gridImageBorderRadius','gridImageWidth','gridImageHeight'].forEach(prefix => {
            const el = document.getElementById(prefix + i);
            if(el) {
                el.addEventListener('input', updatePreview);
                el.addEventListener('change', updatePreview);
            }
        });
        
        if(textDiv && textInput){
            textDiv.addEventListener('input',()=>{
                textInput.value = textDiv.innerHTML;
                updatePreview();
            });
        }
        
        if(imageInput){
            imageInput.addEventListener('change',e=> {
                const file = e.target.files[0];
                if(file){
                    validateImageSize(file, function(isValid) {
                        if(!isValid) {
                            e.target.value = '';
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = ev => {
                            imageInput.setAttribute('data-preview-src', ev.target.result);
                            updatePreview();
                        }
                        reader.readAsDataURL(file);
                    });
                } else {
                    imageInput.removeAttribute('data-preview-src');
                    updatePreview();
                }
            });
        }
    }
}

// Función getGridHTML actualizada con manejo completo de bordes de botones
function getGridHTML() {
    const gridColumnsSelect = document.getElementById('gridColumns');
    const columns = gridColumnsSelect ? parseInt(gridColumnsSelect.value) || 2 : 2;
    
    const gapInput = document.getElementById('gridGap');
    const borderRadiusInput = document.getElementById('gridBorderRadius');
    
    const gap = gapInput ? parseInt(gapInput.value) || 0 : 0;
    const borderRadius = borderRadiusInput ? parseInt(borderRadiusInput.value) || 0 : 0;
    
    // Calcular flex-basis para columnas de ancho igual
    const flexBasis = `calc(${100/columns}% - ${gap * (columns - 1) / columns}px)`;
    
    let html = `<div style="display: flex; gap: ${gap}px; width: 100%; max-width: 600px; flex-wrap: wrap;">`;

    // Iterar solo sobre el número de columnas seleccionadas
    for (let i = 0; i < columns; i++) {
        const columnEl = document.getElementById('gridColumn' + i);
        if (!columnEl || columnEl.style.display === 'none') continue;
        
        const typeCheckboxes = document.querySelectorAll(`.grid-type-checkbox[data-index="${i}"]`);
        const checkedTypes = Array.from(typeCheckboxes).filter(cb => cb.checked).map(cb => cb.value);

        const bgColorInput = document.getElementById('gridBgColor' + i);
        const bgColor = bgColorInput ? bgColorInput.value : '#ffffff';

        html += `<div style="flex: 0 0 ${flexBasis}; background-color:${bgColor}; border-radius:${borderRadius}px; padding:15px; box-sizing: border-box; word-wrap: break-word; overflow-wrap: break-word; min-height: 100px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">`;

        if (checkedTypes.length === 0) {
            html += `<div style="min-height: 50px; color: #ccc; text-align: center; padding: 20px;">Columna ${i + 1} - Sin contenido</div>`;
        } else {
            // Procesar cada tipo de contenido seleccionado
            checkedTypes.forEach(type => {
                if (type === 'text') {
                    const editable = document.getElementById('gridText' + i);
                    if (editable && editable.innerHTML.trim() !== '') {
                        html += `<div class="mb-2 text-content" style="word-wrap: break-word; overflow-wrap: break-word; margin-bottom: 10px;">${editable.innerHTML}</div>`;
                    }
                } else if (type === 'image') {
                    const imgInput = document.querySelector(`input[name="grid_content[${i}][image]"]`);
                    const align = document.getElementById('gridImageAlign' + i)?.value || 'center';
                    const borderColor = document.getElementById('gridImageBorderColor' + i)?.value || '#000';
                    const borderWidth = document.getElementById('gridImageBorderWidth' + i)?.value || 0;
                    const borderRadiusImg = document.getElementById('gridImageBorderRadius' + i)?.value || 0;
                    
                    // Obtener dimensiones de imagen
                    const imageWidth = document.getElementById('gridImageWidth' + i)?.value || 200;
                    const imageHeight = document.getElementById('gridImageHeight' + i)?.value || '';

                    let src = '';
                    
                    // Determinar fuente de imagen
                    if (imgInput?.getAttribute('data-preview-src')) {
                        src = imgInput.getAttribute('data-preview-src');
                    } else if (imgInput && imgInput.files && imgInput.files.length > 0) {
                        const file = imgInput.files[0];
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imgInput.setAttribute('data-preview-src', e.target.result);
                            setTimeout(updatePreview, 100);
                        };
                        reader.readAsDataURL(file);
                        src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkNhcmdhbmRvLi4uPC90ZXh0Pjwvc3ZnPg==';
                    } else {
                        // Buscar imagen existente del servidor
                        const imageControlsDiv = document.getElementById('imageControls' + i);
                        const existingImg = imageControlsDiv?.querySelector('img[data-old-image]');
                        if (existingImg) {
                            src = existingImg.getAttribute('data-old-image') || existingImg.src;
                        }
                    }

                    if (src) {
                        // Construir estilo de imagen con dimensiones personalizadas
                        let imageStyle = `max-width:100%; width:${imageWidth}px;`;
                        if (imageHeight && imageHeight.trim() !== '') {
                            imageStyle += `height:${imageHeight}px; object-fit:cover;`;
                        } else {
                            imageStyle += `height:auto;`;
                        }
                        imageStyle += `border:${borderWidth}px solid ${borderColor}; border-radius:${borderRadiusImg}px;`;

                        html += `<div style="text-align:${align}; margin-bottom: 10px;"><img src="${src}" style="${imageStyle}"></div>`;
                    }
                } else if (type === 'button') {
                    const buttonCheckbox = document.getElementById('gridTypeButton' + i);
                    const textInput = document.getElementById('gridButtonText' + i);

                    // Verificar que el botón esté habilitado y tenga texto válido
                    if (buttonCheckbox && buttonCheckbox.checked && textInput && textInput.value && textInput.value.trim() !== '' && textInput.value.trim() !== 'Click aquí') {
                        const text = textInput.value.trim();
                        const link = document.getElementById('gridButtonLink' + i)?.value || '#';
                        const bgColorBtn = document.getElementById('gridButtonBgColor' + i)?.value || '#0d6efd';
                        const textColor = document.getElementById('gridButtonTextColor' + i)?.value || '#ffffff';
                        const fontSize = document.getElementById('gridButtonFontSize' + i)?.value || 16;
                        const borderRadiusBtn = document.getElementById('gridButtonBorderRadius' + i)?.value || 4;
                        
                        // OBTENER VALORES DE BORDE
                        const borderColor = document.getElementById('gridButtonBorderColor' + i)?.value || '#000000';
                        const borderWidth = document.getElementById('gridButtonBorderWidth' + i)?.value || 0;
                        
                        const bold = document.getElementById('gridButtonBold' + i)?.checked || false;
                        const italic = document.getElementById('gridButtonItalic' + i)?.checked || false;
                        const underline = document.getElementById('gridButtonUnderline' + i)?.checked || false;
                        
                        // OBTENER ALINEACIÓN DEL BOTÓN
                        let buttonAlign = 'center';
                        const alignLeft = document.getElementById('gridButtonAlignLeft' + i);
                        const alignCenter = document.getElementById('gridButtonAlignCenter' + i);
                        const alignRight = document.getElementById('gridButtonAlignRight' + i);
                        
                        if (alignLeft && alignLeft.checked) {
                            buttonAlign = 'left';
                        } else if (alignRight && alignRight.checked) {
                            buttonAlign = 'right';
                        } else if (alignCenter && alignCenter.checked) {
                            buttonAlign = 'center';
                        }

                        let textDecoration = underline ? 'underline' : 'none';

                        html += `<div style="margin-bottom: 10px; text-align: ${buttonAlign};"><a href="${link}" style="display:inline-block; padding:10px 20px; background-color:${bgColorBtn}; color:${textColor}; font-size:${fontSize}px; text-decoration:${textDecoration}; border-radius:${borderRadiusBtn}px; border:${borderWidth}px solid ${borderColor}; font-weight:${bold ? 'bold' : 'normal'}; font-style:${italic ? 'italic' : 'normal'}; max-width:100%; word-wrap:break-word; word-break:break-word; text-align:center;">${text}</a></div>`;
                    }
                }
            });
        }

        html += '</div>';
    }
    html += `</div>`;

    return html;
}
// --- BANNER SIMPLIFICADO ---
function setupBannerListeners() {
  const bannerElements = [
    "bannerBgColor",
    "bannerBgImageEnabled",
    "bannerBgImage",
    "bannerWidth",
    "bannerHeight",
    "bannerTextAlign",
    "bannerBorderRadius",
    "bannerPadding",
    "bannerGradientEnabled",
    "bannerGradientColor1",
    "bannerGradientColor2",
    "bannerGradientDirection",
    "bannerLinkEnabled",
    "bannerLinkUrl",
    "bannerIconEnabled",
    "bannerIcon",
    "bannerIconPosition",
    "bannerIconSize",
    "bannerTitle",
    "bannerSubtitle",
    "bannerTitleColor", 
    "bannerSubtitleColor"
  ]

  bannerElements.forEach((elementId) => {
    const el = document.getElementById(elementId)
    if (el) {
      el.addEventListener("input", updatePreview)
      el.addEventListener("change", updatePreview)
    }
  })

  // Handler for link enabled checkbox
  const bannerLinkEnabled = document.getElementById("bannerLinkEnabled")
  const bannerLinkControls = document.getElementById("bannerLinkControls")

  if (bannerLinkEnabled && bannerLinkControls) {
    bannerLinkEnabled.addEventListener("change", function () {
      bannerLinkControls.style.display = this.checked ? "block" : "none"
      updatePreview()
    })
  }

  // Handler for gradient enabled checkbox
  const bannerGradientEnabled = document.getElementById("bannerGradientEnabled")
  const bannerGradientControls = document.getElementById("bannerGradientControls")

  if (bannerGradientEnabled && bannerGradientControls) {
    bannerGradientEnabled.addEventListener("change", function () {
      bannerGradientControls.style.display = this.checked ? "block" : "none"
      updatePreview()
    })
  }

  // Handler for background image enabled checkbox
  const bannerBgImageEnabled = document.getElementById("bannerBgImageEnabled")
  const bannerBgImageControls = document.getElementById("bannerBgImageControls")

  if (bannerBgImageEnabled && bannerBgImageControls) {
    bannerBgImageEnabled.addEventListener("change", function () {
      bannerBgImageControls.style.display = this.checked ? "block" : "none"
      updatePreview()
    })
  }

  // Handler for icon enabled checkbox
  const bannerIconEnabled = document.getElementById("bannerIconEnabled")
  const bannerIconControls = document.getElementById("bannerIconControls")

  if (bannerIconEnabled && bannerIconControls) {
    bannerIconEnabled.addEventListener("change", function () {
      bannerIconControls.style.display = this.checked ? "block" : "none"
      updatePreview()
    })
  }

  // Background image handler
  const bannerBgImage = document.getElementById("bannerBgImage")
  if (bannerBgImage) {
    bannerBgImage.addEventListener("change", (e) => {
      const file = e.target.files[0]
      if (file) {
        validateImageSize(file, (isValid) => {
          if (!isValid) {
            e.target.value = ""
            return
          }
          const reader = new FileReader()
          reader.onload = (ev) => {
            bannerBgImage.setAttribute("data-preview-src", ev.target.result)
            updatePreview()
          }
          reader.readAsDataURL(file)
        })
      } else {
        bannerBgImage.removeAttribute("data-preview-src")
        updatePreview()
      }
    })
  }

  // Icon image handler
  const bannerIcon = document.getElementById("bannerIcon")
  if (bannerIcon) {
    bannerIcon.addEventListener("change", (e) => {
      const file = e.target.files[0]
      if (file) {
        validateImageSize(file, (isValid) => {
          if (!isValid) {
            e.target.value = ""
            return
          }
          const reader = new FileReader()
          reader.onload = (ev) => {
            bannerIcon.setAttribute("data-preview-src", ev.target.result)
            updatePreview()
          }
          reader.readAsDataURL(file)
        })
      } else {
        bannerIcon.removeAttribute("data-preview-src")
        updatePreview()
      }
    })
  }
}

function getBannerHTML() {
  // Configuración básica
  const width = document.getElementById("bannerWidth")?.value || 600
  const height = document.getElementById("bannerHeight")?.value || 300
  const borderRadius = document.getElementById("bannerBorderRadius")?.value || 0
  const padding = document.getElementById("bannerPadding")?.value || 40
  const textAlign = document.getElementById("bannerTextAlign")?.value || "center"

  // Link
  const linkEnabled = document.getElementById("bannerLinkEnabled")?.checked || false
  const linkUrl = document.getElementById("bannerLinkUrl")?.value || "#"

  // Imagen de fondo
  const bgImageEnabled = document.getElementById("bannerBgImageEnabled")?.checked || false
  const bgImageInput = document.getElementById("bannerBgImage")
  let bgImageSrc = ""
  if (bgImageEnabled && bgImageInput) {
    // Primero verificar si hay un preview cargado
    bgImageSrc = bgImageInput.getAttribute("data-preview-src") || ""
    
    // Si no hay preview, buscar imagen existente en el DOM
    if (!bgImageSrc) {
      const existingBgImg = document.querySelector('img[data-current-bg-image]')
      if (existingBgImg) {
        bgImageSrc = existingBgImg.src
      }
    }
  }

  // Gradiente
  const gradientEnabled = document.getElementById("bannerGradientEnabled")?.checked || false
  const gradientColor1 = document.getElementById("bannerGradientColor1")?.value || "#667eea"
  const gradientColor2 = document.getElementById("bannerGradientColor2")?.value || "#764ba2"
  const gradientDirection = document.getElementById("bannerGradientDirection")?.value || "to right"

  // Color sólido
  const bgColor = document.getElementById("bannerBgColor")?.value || "#f8f9fa"

  // Icono
  const iconEnabled = document.getElementById("bannerIconEnabled")?.checked || false
  const iconInput = document.getElementById("bannerIcon")
  const iconPosition = document.getElementById("bannerIconPosition")?.value || "top"
  const iconSize = document.getElementById("bannerIconSize")?.value || 60

  let iconSrc = ""
  if (iconEnabled && iconInput) {
    // Primero verificar si hay un preview cargado
    iconSrc = iconInput.getAttribute("data-preview-src") || ""
    
    // Si no hay preview, buscar imagen existente en el DOM
    if (!iconSrc) {
      const existingIconImg = document.querySelector('img[data-current-icon]')
      if (existingIconImg) {
        iconSrc = existingIconImg.src
      }
    }
  }

  // Contenido
   const title = document.getElementById("bannerTitle")?.value || ""
  const subtitle = document.getElementById("bannerSubtitle")?.value || ""
  
  // NUEVO: Obtener colores de texto
  const titleColor = document.getElementById("bannerTitleColor")?.value || "#ffffff"
  const subtitleColor = document.getElementById("bannerSubtitleColor")?.value || "#ffffff"
  

  // Determinar el fondo
  let backgroundStyle = ""
  if (bgImageEnabled && bgImageSrc) {
    backgroundStyle = `background-image: url('${bgImageSrc}'); background-size: cover; background-position: center; background-repeat: no-repeat;`
  } else if (gradientEnabled) {
    backgroundStyle = `background: linear-gradient(${gradientDirection}, ${gradientColor1}, ${gradientColor2});`
  } else {
    backgroundStyle = `background-color: ${bgColor};`
  }

  // Generar HTML del contenido
  let contentHTML = ""

  // Icono arriba
  if (iconEnabled && iconSrc && iconPosition === "top") {
    contentHTML += `
      <div style="margin-bottom: 15px; text-align: ${textAlign};">
        <img src="${iconSrc}" alt="Icon" style="width: ${iconSize}px; height: ${iconSize}px; display: inline-block;">
      </div>
    `
  }

  // Contenedor del texto y posible icono lateral
  const needsFlexContainer = iconEnabled && iconSrc && (iconPosition === "left" || iconPosition === "right")

  if (needsFlexContainer) {
    const justifyContent =
      textAlign === "center" ? "center" : textAlign === "right" ? "flex-end" : "flex-start"

    contentHTML += `<div style="display: flex; align-items: center; justify-content: ${justifyContent}; gap: 20px;">`

    if (iconPosition === "left") {
      contentHTML += `<img src="${iconSrc}" alt="Icon" style="width: ${iconSize}px; height: ${iconSize}px; flex-shrink: 0;">`
    }
  }

  // Texto (título y subtítulo)
  contentHTML += `<div style="text-align: ${textAlign};">`

  if (title) {
    contentHTML += `
      <div style="font-size: 28px; font-weight: bold; line-height: 1.3; margin: 0 0 10px 0; color: ${titleColor};">
        ${title}
      </div>
    `
  }

  if (subtitle) {
    contentHTML += `
      <div style="font-size: 16px; line-height: 1.5; margin: 0; color: ${subtitleColor}; opacity: 0.95;">
        ${subtitle}
      </div>
    `
  }

  contentHTML += `</div>` // Cierre del contenedor de texto

  // Icono derecha
  if (needsFlexContainer && iconPosition === "right") {
    contentHTML += `<img src="${iconSrc}" alt="Icon" style="width: ${iconSize}px; height: ${iconSize}px; flex-shrink: 0;">`
  }

  if (needsFlexContainer) {
    contentHTML += `</div>` // Cierre del flex container
  }

  // Envolver en link si está habilitado
  const wrapperOpenTag = linkEnabled
    ? `<a href="${linkUrl}" style="text-decoration: none; display: block;">`
    : "<div>"
  const wrapperCloseTag = linkEnabled ? "</a>" : "</div>"

  const bannerHTML = `
    <div style="margin: 20px 0; max-width: ${width}px; width: 100%;">
      ${wrapperOpenTag}
        <div style="
          ${backgroundStyle}
          height: ${height}px;
          border-radius: ${borderRadius}px;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: ${
            textAlign === "center" ? "center" : textAlign === "right" ? "flex-end" : "flex-start"
          };
          padding: ${padding}px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        ">
          ${contentHTML}
        </div>
      ${wrapperCloseTag}
    </div>
  `

  return bannerHTML
}

// --- ÍCONO-TEXTO ---
function setupIconTextListeners() {
    const iconTextRows = document.getElementById('iconTextRows');
    const iconTextGap = document.getElementById('iconTextGap');
    const iconTextBorderRadius = document.getElementById('iconTextBorderRadius');
    const iconTextLayout = document.getElementById('iconTextLayout');
    
    // Row selector listener
    if(iconTextRows) {
        iconTextRows.addEventListener('change', function() {
            const selectedRows = parseInt(this.value);
            
            // Show/hide rows based on selection
            for(let i = 0; i < 4; i++) {
                const rowEl = document.getElementById('iconTextRow' + i);
                if(rowEl) {
                    rowEl.style.display = i < selectedRows ? 'block' : 'none';
                }
            }
            
            updatePreview();
        });
    }
    
    // Layout selector listener
    if(iconTextLayout) {
        iconTextLayout.addEventListener('change', updatePreview);
    }
    
    if(iconTextGap) {
        iconTextGap.addEventListener('input', updatePreview);
        iconTextGap.addEventListener('change', updatePreview);
    }
    
    if(iconTextBorderRadius) {
        iconTextBorderRadius.addEventListener('input', updatePreview);
        iconTextBorderRadius.addEventListener('change', updatePreview);
    }
    
    // Set up listeners for all 4 possible rows
    for(let i=0;i<4;i++){
        // Position selector
        const positionSelect = document.getElementById('iconPosition' + i);
        if(positionSelect) {
            positionSelect.addEventListener('change', updatePreview);
        }
        
        // Background color
        const bgColorInput = document.getElementById('iconTextBgColor' + i);
        if(bgColorInput) {
            bgColorInput.addEventListener('input', updatePreview);
            bgColorInput.addEventListener('change', updatePreview);
        }
        
        // Icon controls
        ['iconSize','iconBorderColor','iconBorderWidth','iconBorderRadius'].forEach(prefix => {
            const el = document.getElementById(prefix + i);
            if(el) {
                el.addEventListener('input', updatePreview);
                el.addEventListener('change', updatePreview);
            }
        });
        
        // Text content
        const titleDiv = document.getElementById('iconTextTitle' + i);
        const titleInput = document.getElementById('iconTextTitleInput' + i);
        const descDiv = document.getElementById('iconTextDesc' + i);
        const descInput = document.getElementById('iconTextDescInput' + i);
        
        if(titleDiv && titleInput) {
            titleDiv.addEventListener('input', () => {
                titleInput.value = titleDiv.innerHTML;
                updatePreview();
            });
        }
        
        if(descDiv && descInput) {
            descDiv.addEventListener('input', () => {
                descInput.value = descDiv.innerHTML;
                updatePreview();
            });
        }
        
        // Icon image input
        const iconInput = document.querySelector(`input[name="icon_text_content[${i}][icon]"]`);
        if(iconInput) {
            iconInput.addEventListener('change', e => {
                const file = e.target.files[0];
                if(file) {
                    validateImageSize(file, function(isValid) {
                        if(!isValid) {
                            e.target.value = '';
                            return;
                        }
                        const reader = new FileReader();
                        reader.onload = ev => {
                            iconInput.setAttribute('data-preview-src', ev.target.result);
                            updatePreview();
                        }
                        reader.readAsDataURL(file);
                    });
                } else {
                    iconInput.removeAttribute('data-preview-src');
                    updatePreview();
                }
            });
        }
    }
}

// Text formatting functions for icon-text
function formatIconTextContent(id, command) {
    const el = document.getElementById(id);
    if (!el) return;
    
    el.focus();
    
    // Preserve font sizes before formatting
    preserveFontSizes(el);
    
    document.execCommand(command, false, null);
    
    // Restore font sizes after formatting
    const elementsWithFontSize = el.querySelectorAll('[data-font-size]');
    elementsWithFontSize.forEach(element => {
        const fontSize = element.getAttribute('data-font-size');
        if (fontSize) {
            element.style.fontSize = fontSize;
            element.removeAttribute('data-font-size');
        }
    });
    
    // Update corresponding hidden input
    let inputId = '';
    if (id.includes('iconTextTitle')) {
        inputId = id.replace('iconTextTitle', 'iconTextTitleInput');
    } else if (id.includes('iconTextDesc')) {
        inputId = id.replace('iconTextDesc', 'iconTextDescInput');
    }
    
    const hiddenInput = document.getElementById(inputId);
    if(hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function setIconTextSize(id, size) {
    if (!size) return;
    const el = document.getElementById(id);
    if (!el) return;
    
    // Focus the element first
    el.focus();
    
    // Remove any existing font size styling
    el.style.fontSize = '';
    
    // Apply the new font size
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        if (!range.collapsed) {
            // If there's a selection, apply to selection
            document.execCommand('fontSize', false, '7');
            const fontElements = el.querySelectorAll('font[size="7"]');
            fontElements.forEach(font => {
                font.style.fontSize = size + 'px';
                font.removeAttribute('size');
            });
        } else {
            // No selection, apply to entire element
            el.style.fontSize = size + 'px';
        }
    } else {
        // Fallback: apply to entire element
        el.style.fontSize = size + 'px';
    }
    
    // Update corresponding hidden input
    let inputId = '';
    if (id.includes('iconTextTitle')) {
        inputId = id.replace('iconTextTitle', 'iconTextTitleInput');
    } else if (id.includes('iconTextDesc')) {
        inputId = id.replace('iconTextDesc', 'iconTextDescInput');
    }
    
    const hiddenInput = document.getElementById(inputId);
    if(hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function openIconTextColorPicker(id, inputId) {
    const el = document.getElementById(id);
    if (!el) return;
    
    el.focus();

    colorPicker.oninput = e => {
        const color = e.target.value;
        document.execCommand('foreColor', false, color);
        const hiddenInput = document.getElementById(inputId);
        if (hiddenInput) {
            hiddenInput.value = el.innerHTML;
        }
        updatePreview();
    }

    colorPicker.click();
}

function getIconTextHTML() {
    const iconTextRowsSelect = document.getElementById('iconTextRows');
    if (!iconTextRowsSelect) return '';
    
    const rows = parseInt(iconTextRowsSelect.value) || 2;
    
    const gapInput = document.getElementById('iconTextGap');
    const borderRadiusInput = document.getElementById('iconTextBorderRadius');
    const layoutSelect = document.getElementById('iconTextLayout');
    
    const gap = gapInput ? parseInt(gapInput.value) || 15 : 15;
    const borderRadius = borderRadiusInput ? parseInt(borderRadiusInput.value) || 0 : 0;
    const layout = layoutSelect ? layoutSelect.value : 'vertical';
    
    // Determinar si es layout horizontal
    const isHorizontal = layout === 'horizontal';
    
    let html = '';
    
    if (isHorizontal) {
        // Layout horizontal: filas una al lado de otra
        html = `<div style="display: flex; flex-direction: row; gap: ${gap}px; width: 100%; flex-wrap: wrap;">`;
    } else {
        // Layout vertical: filas una debajo de otra
        html = `<div style="display: flex; flex-direction: column; gap: ${gap}px; width: 100%; max-width: 600px;">`;
    }

    for (let i = 0; i < rows; i++) {
        const rowEl = document.getElementById('iconTextRow' + i);
        if (!rowEl || rowEl.style.display === 'none') continue;
        
        const positionSelect = document.getElementById('iconPosition' + i);
        const position = positionSelect ? positionSelect.value : 'left';
        
        const bgColorInput = document.getElementById('iconTextBgColor' + i);
        const bgColor = bgColorInput ? bgColorInput.value : '#ffffff';
        
        const titleEl = document.getElementById('iconTextTitle' + i);
        const descEl = document.getElementById('iconTextDesc' + i);
        
        const title = titleEl ? titleEl.innerHTML : '';
        const description = descEl ? descEl.innerHTML : '';
        
        // Icon properties
        const iconSizeInput = document.getElementById('iconSize' + i);
        const iconBorderColorInput = document.getElementById('iconBorderColor' + i);
        const iconBorderWidthInput = document.getElementById('iconBorderWidth' + i);
        const iconBorderRadiusInput = document.getElementById('iconBorderRadius' + i);
        
        const iconSize = iconSizeInput ? iconSizeInput.value : 60;
        const iconBorderColor = iconBorderColorInput ? iconBorderColorInput.value : '#000';
        const iconBorderWidth = iconBorderWidthInput ? iconBorderWidthInput.value : 0;
        const iconBorderRadius = iconBorderRadiusInput ? iconBorderRadiusInput.value : 0;
        
        // Get icon source
        let iconSrc = '';
        const iconInput = document.querySelector(`input[name="icon_text_content[${i}][icon]"]`);
        
        if (iconInput && iconInput.getAttribute('data-preview-src')) {
            iconSrc = iconInput.getAttribute('data-preview-src');
        } else if (iconInput && iconInput.files && iconInput.files.length > 0) {
            iconSrc = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2RkZCIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTAiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5DYXJnYW5kby4uLjwvdGV4dD48L3N2Zz4=';
        } else {
            const existingImg = rowEl ? rowEl.querySelector('img[data-old-icon]') : null;
            if (existingImg) {
                iconSrc = existingImg.getAttribute('data-old-icon');
            }
        }
        
        if (!iconSrc) {
            iconSrc = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2VlZSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTAiIGZpbGw9IiNiYmIiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGR5PSIuM2VtIj5ÃCONO</text></svg>';
        }
        
        // Build the row HTML
       const iconHTML = `<div style="flex-shrink: 0; display: flex; align-items: center; justify-content: center; width: ${iconSize}px;">
            <img src="${iconSrc}" style="max-width: ${iconSize}px; max-height: ${iconSize}px; width: auto; height: auto; border: ${iconBorderWidth}px solid ${iconBorderColor}; border-radius: ${iconBorderRadius}px; object-fit: contain; display: block;">
        </div>`;
        
        const textHTML = `<div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
            ${title && title.trim() ? `<div class="icon-text-title" style="margin-bottom: 8px; font-weight: bold;">${title}</div>` : ''}
            ${description && description.trim() ? `<div class="icon-text-description">${description}</div>` : ''}
            ${(!title || !title.trim()) && (!description || !description.trim()) ? `<div style="color: #ccc; font-style: italic;">Fila ${i + 1} - Sin contenido de texto</div>` : ''}
        </div>`;
        
        // Determinar dirección del flex según la posición del ícono
        let flexDirection = 'row';
        if (position === 'right') {
            flexDirection = 'row-reverse';
        } else if (position === 'up') {
            flexDirection = 'column';
        }
        // En horizontal, cada celda toma ancho proporcional
        const cellStyle = isHorizontal ? 
            `flex: 1; min-width: ${100 / rows - gap}%; ` : 
            '';
        
        html += `<div style="${cellStyle}display: flex; flex-direction: ${flexDirection}; gap: 15px; background-color: ${bgColor}; border-radius: ${borderRadius}px; padding: 15px; align-items: center; min-height: 80px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            ${iconHTML}
            ${textHTML}
        </div>`;
    }
    
    html += '</div>';
    
    return html;
}
// --- SOCIAL MEDIA / PREVIEW FIXED ---

// Iconos PNG de Icons8 (compatibles con todos los clientes de email)
// --- SOCIAL MEDIA / PREVIEW FIXED ---

// Iconos monocromáticos de Icons8 (personalizables por color)
const socialIconsImages = {
  facebook: "https://img.icons8.com/ios-filled/100/facebook-new.png",
  instagram: "https://img.icons8.com/ios-filled/100/instagram-new.png",
  twitter: "https://img.icons8.com/ios-filled/100/twitter.png",
  linkedin: "https://img.icons8.com/ios-filled/100/linkedin.png",
  youtube: "https://img.icons8.com/ios-filled/100/youtube-play.png",
  tiktok: "https://img.icons8.com/ios-filled/100/tiktok.png",
  whatsapp: "https://img.icons8.com/ios-filled/100/whatsapp.png",
  telegram: "https://img.icons8.com/ios-filled/100/telegram-app.png",
  pinterest: "https://img.icons8.com/ios-filled/100/pinterest.png",
  snapchat: "https://img.icons8.com/ios-filled/100/snapchat.png",
  discord: "https://img.icons8.com/ios-filled/100/discord-logo.png",
  twitch: "https://img.icons8.com/ios-filled/100/twitch.png",
  reddit: "https://img.icons8.com/ios-filled/100/reddit.png",
  github: "https://img.icons8.com/ios-filled/100/github.png",
  website: "https://img.icons8.com/ios-filled/100/domain.png",
  email: "https://img.icons8.com/ios-filled/100/gmail.png",
}

function updatePreview() {
  const previewContainer = document.getElementById("socialPreview")
  if (previewContainer) {
    previewContainer.innerHTML = getSocialHTML()
  }
}

function setupSocialListeners() {
  const socialIconSize = document.getElementById("socialIconSize")
  const socialGap = document.getElementById("socialGap")
  const socialBorderRadius = document.getElementById("socialBorderRadius")
  const socialAlign = document.getElementById("socialAlign")

  // Listeners para configuración general
  if (socialIconSize) {
    socialIconSize.addEventListener("input", updatePreview)
    socialIconSize.addEventListener("change", updatePreview)
  }
  if (socialGap) {
    socialGap.addEventListener("input", updatePreview)
    socialGap.addEventListener("change", updatePreview)
  }
  if (socialBorderRadius) {
    socialBorderRadius.addEventListener("input", updatePreview)
    socialBorderRadius.addEventListener("change", updatePreview)
  }
  if (socialAlign) {
    socialAlign.addEventListener("change", updatePreview)
  }

  // Listeners para cada red social
  const networks = [
    "facebook",
    "instagram",
    "twitter",
    "linkedin",
    "youtube",
    "tiktok",
    "whatsapp",
    "telegram",
    "pinterest",
    "snapchat",
    "discord",
    "twitch",
    "reddit",
    "github",
    "website",
    "email",
  ]

  networks.forEach((network) => {
    const enabledCheckbox = document.querySelector(`.social-enabled-checkbox[data-network="${network}"]`)
    if (enabledCheckbox) {
      enabledCheckbox.addEventListener("change", function () {
        const controls = document.getElementById("socialControls" + network)
        if (controls) controls.style.display = this.checked ? "block" : "none"
        updatePreview()
      })
    }
    const urlInput = document.querySelector(`.social-url-input[data-network="${network}"]`)
    if (urlInput) {
      urlInput.addEventListener("input", updatePreview)
      urlInput.addEventListener("change", updatePreview)
    }
    const bgColorInput = document.querySelector(`.social-bg-color[data-network="${network}"]`)
    if (bgColorInput) {
      bgColorInput.addEventListener("input", updatePreview)
      bgColorInput.addEventListener("change", updatePreview)
    }
    const iconColorInput = document.querySelector(`.social-icon-color[data-network="${network}"]`)
    if (iconColorInput) {
      iconColorInput.addEventListener("input", updatePreview)
      iconColorInput.addEventListener("change", updatePreview)
    }
    const borderColorInput = document.querySelector(`.social-border-color[data-network="${network}"]`)
    if (borderColorInput) {
      borderColorInput.addEventListener("input", updatePreview)
      borderColorInput.addEventListener("change", updatePreview)
    }
    const borderWidthInput = document.querySelector(`.social-border-width[data-network="${network}"]`)
    if (borderWidthInput) {
      borderWidthInput.addEventListener("input", updatePreview)
      borderWidthInput.addEventListener("change", updatePreview)
    }
  })
}

function getSocialHTML() {
  const iconSizeInput = document.getElementById("socialIconSize")
  const gapInput = document.getElementById("socialGap")
  const borderRadiusInput = document.getElementById("socialBorderRadius")
  const alignInput = document.getElementById("socialAlign")

  const iconSize = iconSizeInput ? Number.parseInt(iconSizeInput.value, 10) || 40 : 40
  const gap = gapInput ? Number.parseInt(gapInput.value, 10) || 15 : 15
  const borderRadius = borderRadiusInput ? Number.parseInt(borderRadiusInput.value, 10) || 50 : 50
  const align = alignInput ? alignInput.value : "center"

  const networks = [
    "facebook",
    "instagram",
    "twitter",
    "linkedin",
    "youtube",
    "tiktok",
    "whatsapp",
    "telegram",
    "pinterest",
    "snapchat",
    "discord",
    "twitch",
    "reddit",
    "github",
    "website",
    "email",
  ]

  const enabledNetworks = []

  networks.forEach((network) => {
    const enabledCheckbox = document.querySelector(`.social-enabled-checkbox[data-network="${network}"]`)
    const urlInput = document.querySelector(`.social-url-input[data-network="${network}"]`)

    if (enabledCheckbox && enabledCheckbox.checked && urlInput && urlInput.value.trim() !== "") {
      const bgColorInput = document.querySelector(`.social-bg-color[data-network="${network}"]`)
      const iconColorInput = document.querySelector(`.social-icon-color[data-network="${network}"]`)
      const borderColorInput = document.querySelector(`.social-border-color[data-network="${network}"]`)
      const borderWidthInput = document.querySelector(`.social-border-width[data-network="${network}"]`)

      const bgColor = bgColorInput ? bgColorInput.value : "#6c757d"
      const iconColor = iconColorInput ? iconColorInput.value : "#ffffff"
      const borderColor = borderColorInput ? borderColorInput.value : "#000000"
      const borderWidth = borderWidthInput ? Number.parseInt(borderWidthInput.value, 10) || 0 : 0

      // Icons8 permite cambiar color: /100/COLORHEX/
      let iconUrl = socialIconsImages[network] || socialIconsImages["website"]
      const colorHex = iconColor.replace("#", "")
      iconUrl = iconUrl.replace("/100/", `/100/${colorHex}/`)

      enabledNetworks.push({
        network,
        url: urlInput.value.trim(),
        bgColor,
        iconColor,
        borderColor,
        borderWidth,
        iconUrl,
      })
    }
  })

  if (enabledNetworks.length === 0) {
    return '<div style="text-align:center; padding:20px; color:#999; font-family:Arial,sans-serif;">No hay redes sociales configuradas. Active y agregue URLs para mostrar los iconos.</div>'
  }

  const iconPadding = Math.round(iconSize * 0.2)
  const iconDisplaySize = iconSize - iconPadding * 2

  let html = `<div style="display: flex; gap: ${gap}px; justify-content: ${align}; align-items: center; flex-wrap: wrap; padding: 10px 0;">`

  enabledNetworks.forEach((item) => {
    const borderStyle = item.borderWidth > 0 ? `${item.borderWidth}px solid ${item.borderColor}` : "none"

    html += `
            <a href="${item.url}" target="_blank" rel="noopener noreferrer" title="${item.network}" style="
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: ${iconSize}px;
                height: ${iconSize}px;
                background-color: ${item.bgColor};
                border-radius: ${borderRadius}px;
                border: ${borderStyle};
                text-decoration: none;
                transition: transform 0.2s, opacity 0.2s;
                box-sizing: border-box;
                padding: ${iconPadding}px;
            " onmouseover="this.style.opacity='0.8'; this.style.transform='scale(1.08)';" onmouseout="this.style.opacity='1'; this.style.transform='scale(1)';">
                <img src="${item.iconUrl}" width="${iconDisplaySize}" height="${iconDisplaySize}" alt="${item.network}" style="display:block; border:0;" />
            </a>`
  })

  html += "</div>"
  return html
}
// --- INSTRUCTIVO FIXED ---
function setupInstructivoListeners() {
    const instructivoTitle = document.getElementById('instructivoTitle');
    const instructivoTitleColor = document.getElementById('instructivoTitleColor');
    const instructivoGeneralBgColor = document.getElementById('instructivoGeneralBgColor');
    const itemsCountSelect = document.getElementById('instructivoItemsCount');
    const instructivoShowButtons = document.getElementById('instructivoShowButtons');
    const instructivoButtonsCount = document.getElementById('instructivoButtonsCount');
    const instructivoButtonsConfig = document.getElementById('instructivoButtonsConfig');
    
    // Title listeners
    if(instructivoTitle) {
        instructivoTitle.addEventListener('input', updatePreview);
        instructivoTitle.addEventListener('change', updatePreview);
    }
    
    if(instructivoTitleColor) {
        instructivoTitleColor.addEventListener('input', updatePreview);
        instructivoTitleColor.addEventListener('change', updatePreview);
    }
    
    // General background color listener
    if(instructivoGeneralBgColor) {
        instructivoGeneralBgColor.addEventListener('input', updatePreview);
        instructivoGeneralBgColor.addEventListener('change', updatePreview);
    }
    
    // Items count selector
    if(itemsCountSelect) {
        itemsCountSelect.addEventListener('change', function() {
            const count = parseInt(this.value);
            for(let i = 0; i < 10; i++) {
                const itemEl = document.getElementById('instructivoItem' + i);
                if(itemEl) {
                    itemEl.style.display = i < count ? 'block' : 'none';
                }
            }
            updatePreview();
        });
    }
    
    // Show buttons toggle
    if(instructivoShowButtons && instructivoButtonsConfig) {
        instructivoShowButtons.addEventListener('change', function() {
            instructivoButtonsConfig.style.display = this.checked ? 'block' : 'none';
            updatePreview();
        });
    }
    
    // Buttons count selector
    if(instructivoButtonsCount) {
        instructivoButtonsCount.addEventListener('change', function() {
            const count = parseInt(this.value);
            for(let i = 0; i < 4; i++) {
                const btnEl = document.getElementById('instructivoButton' + i);
                if(btnEl) {
                    btnEl.style.display = i < count ? 'block' : 'none';
                }
            }
            updatePreview();
        });
    }
    
    // Set up listeners for all 10 possible items
    for(let i = 0; i < 10; i++) {
        // Background color
        const bgColorInput = document.getElementById('instructivoBgColor' + i);
        if(bgColorInput) {
            bgColorInput.addEventListener('input', updatePreview);
            bgColorInput.addEventListener('change', updatePreview);
        }
        
        // Label content - FIXED: Sync on load and on input
        const labelDiv = document.getElementById('instructivoLabel' + i);
        const labelInput = document.getElementById('instructivoLabelInput' + i);
        if(labelDiv && labelInput) {
            // Initial sync from div to hidden input
            labelInput.value = labelDiv.innerHTML;
            
            // Sync on input
            labelDiv.addEventListener('input', () => {
                labelInput.value = labelDiv.innerHTML;
                updatePreview();
            });
            
            // Sync on blur (when user leaves the field)
            labelDiv.addEventListener('blur', () => {
                labelInput.value = labelDiv.innerHTML;
            });
        }
        
        // Content - FIXED: Sync on load and on input
        const contentDiv = document.getElementById('instructivoContent' + i);
        const contentInput = document.getElementById('instructivoContentInput' + i);
        if(contentDiv && contentInput) {
            // Initial sync from div to hidden input
            contentInput.value = contentDiv.innerHTML;
            
            // Sync on input
            contentDiv.addEventListener('input', () => {
                contentInput.value = contentDiv.innerHTML;
                updatePreview();
            });
            
            // Sync on blur
            contentDiv.addEventListener('blur', () => {
                contentInput.value = contentDiv.innerHTML;
            });
        }
    }
    
    // Extra message - FIXED: Sync on load and on input
    const extraMessageDiv = document.getElementById('instructivoExtraMessage');
    const extraMessageInput = document.getElementById('instructivoExtraMessageInput');
    if(extraMessageDiv && extraMessageInput) {
        // Initial sync
        extraMessageInput.value = extraMessageDiv.innerHTML;
        
        // Sync on input
        extraMessageDiv.addEventListener('input', () => {
            extraMessageInput.value = extraMessageDiv.innerHTML;
            updatePreview();
        });
        
        // Sync on blur
        extraMessageDiv.addEventListener('blur', () => {
            extraMessageInput.value = extraMessageDiv.innerHTML;
        });
    }
    
    // Set up listeners for all 4 possible buttons
    for(let i = 0; i < 4; i++) {
        ['instructivoButtonText','instructivoButtonUrl','instructivoButtonStyle',
         'instructivoButtonBg','instructivoButtonTextColor','instructivoButtonBorder'].forEach(prefix => {
            const el = document.getElementById(prefix + i);
            if(el) {
                el.addEventListener('input', updatePreview);
                el.addEventListener('change', updatePreview);
            }
        });
    }
    
    // Initial preview update
    updatePreview();
}

// Text formatting functions for instructivo
function formatInstructivoContent(id, command) {
    const el = document.getElementById(id);
    if (!el) return;
    
    el.focus();
    preserveFontSizes(el);
    document.execCommand(command, false, null);
    
    const elementsWithFontSize = el.querySelectorAll('[data-font-size]');
    elementsWithFontSize.forEach(element => {
        const fontSize = element.getAttribute('data-font-size');
        if (fontSize) {
            element.style.fontSize = fontSize;
            element.removeAttribute('data-font-size');
        }
    });
    
    // Update corresponding hidden input
    let inputId = id + 'Input';
    const hiddenInput = document.getElementById(inputId);
    if(hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function setInstructivoTextSize(id, size) {
    if (!size) return;
    const el = document.getElementById(id);
    if (!el) return;
    
    el.focus();
    el.style.fontSize = '';
    
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);
        if (!range.collapsed) {
            document.execCommand('fontSize', false, '7');
            const fontElements = el.querySelectorAll('font[size="7"]');
            fontElements.forEach(font => {
                font.style.fontSize = size + 'px';
                font.removeAttribute('size');
            });
        } else {
            el.style.fontSize = size + 'px';
        }
    } else {
        el.style.fontSize = size + 'px';
    }
    
    let inputId = id + 'Input';
    const hiddenInput = document.getElementById(inputId);
    if(hiddenInput) {
        hiddenInput.value = el.innerHTML;
    }
    
    updatePreview();
}

function openInstructivoColorPicker(id, inputId) {
    const el = document.getElementById(id);
    if (!el) return;
    
    el.focus();

    // Assuming colorPicker is a global input[type="color"] element
    const colorPicker = document.getElementById('colorPicker') || createColorPicker();
    
    colorPicker.oninput = e => {
        const color = e.target.value;
        document.execCommand('foreColor', false, color);
        const hiddenInput = document.getElementById(inputId);
        if (hiddenInput) {
            hiddenInput.value = el.innerHTML;
        }
        updatePreview();
    }

    colorPicker.click();
}

// Helper to create color picker if it doesn't exist
function createColorPicker() {
    let picker = document.createElement('input');
    picker.type = 'color';
    picker.id = 'colorPicker';
    picker.style.position = 'absolute';
    picker.style.opacity = '0';
    picker.style.pointerEvents = 'none';
    document.body.appendChild(picker);
    return picker;
}

// Helper function for preserving font sizes (if not defined elsewhere)
function preserveFontSizes(element) {
    const elementsWithStyle = element.querySelectorAll('[style*="font-size"]');
    elementsWithStyle.forEach(el => {
        const fontSize = el.style.fontSize;
        if (fontSize) {
            el.setAttribute('data-font-size', fontSize);
        }
    });
}

// FUNCIÓN PRINCIPAL: Genera el HTML del instructivo para el preview
function getInstructivoHTML() {
    const titleInput = document.getElementById('instructivoTitle');
    const titleColorInput = document.getElementById('instructivoTitleColor');
    const generalBgColorInput = document.getElementById('instructivoGeneralBgColor');
    const itemsCountSelect = document.getElementById('instructivoItemsCount');
    const extraMessageDiv = document.getElementById('instructivoExtraMessage');
    const showButtonsCheckbox = document.getElementById('instructivoShowButtons');
    const buttonsCountSelect = document.getElementById('instructivoButtonsCount');
    
    if (!titleInput || !itemsCountSelect) return '';
    
    const title = titleInput.value || 'Información del programa';
    const titleColor = titleColorInput ? titleColorInput.value : '#c41e3a';
    const generalBgColor = generalBgColorInput ? generalBgColorInput.value : '#ffffff';
    const itemsCount = parseInt(itemsCountSelect.value) || 3;
    const extraMessage = extraMessageDiv ? extraMessageDiv.innerHTML : '';
    const showButtons = showButtonsCheckbox ? showButtonsCheckbox.checked : false;
    const buttonsCount = showButtons && buttonsCountSelect ? parseInt(buttonsCountSelect.value) : 0;
    
    // WRAPPER con color de fondo general
    let html = `<div style="width: 100%; max-width: 600px; font-family: Arial, Helvetica, sans-serif; background-color: ${generalBgColor}; padding: 20px; border-radius: 8px;">`;
    
    // Title
    html += `<div style="color: ${titleColor}; font-size: 20px; font-weight: bold; margin-bottom: 15px;">${title}</div>`;
    
    // Items - BLOQUES VERTICALES (NO TABLA)
    for(let i = 0; i < itemsCount; i++) {
        const itemEl = document.getElementById('instructivoItem' + i);
        if (!itemEl || itemEl.style.display === 'none') continue;
        
        const labelDiv = document.getElementById('instructivoLabel' + i);
        const contentDiv = document.getElementById('instructivoContent' + i);
        const bgColorInput = document.getElementById('instructivoBgColor' + i);
        
        const label = labelDiv ? labelDiv.innerHTML : '';
        const content = contentDiv ? contentDiv.innerHTML : '';
        const bgColor = bgColorInput ? bgColorInput.value : '#ffffff';
        
        // BLOQUE VERTICAL: Etiqueta arriba, contenido abajo
        html += `<div style="background-color: ${bgColor}; padding: 12px; margin-bottom: 10px; border: 1px solid #dee2e6; border-radius: 4px;">`;
        
        // Etiqueta en negrita
        if(label && label.trim()) {
            html += `<div style="font-weight: bold; color: #212529; font-size: 14px; margin-bottom: 5px;">${label}</div>`;
        }
        
        // Contenido debajo
        if(content && content.trim()) {
            html += `<div style="color: #495057; font-size: 14px; line-height: 1.5;">${content}</div>`;
        }
        
        html += `</div>`;
    }
    
    // Extra message
    if(extraMessage && extraMessage.trim()) {
        html += `<div style="margin-bottom: 15px; line-height: 1.6; font-size: 14px; color: #495057;">${extraMessage}</div>`;
    }
    
    // Buttons
    if(buttonsCount > 0) {
        html += '<div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;">';
        
        for(let i = 0; i < buttonsCount; i++) {
            const btnEl = document.getElementById('instructivoButton' + i);
            if (!btnEl || btnEl.style.display === 'none') continue;
            
            const textInput = document.getElementById('instructivoButtonText' + i);
            const urlInput = document.getElementById('instructivoButtonUrl' + i);
            const styleSelect = document.getElementById('instructivoButtonStyle' + i);
            const bgInput = document.getElementById('instructivoButtonBg' + i);
            const textColorInput = document.getElementById('instructivoButtonTextColor' + i);
            const borderInput = document.getElementById('instructivoButtonBorder' + i);
            
            const text = textInput ? textInput.value : `Botón ${i + 1}`;
            const url = urlInput ? urlInput.value : '#';
            const style = styleSelect ? styleSelect.value : 'solid';
            const bgColor = bgInput ? bgInput.value : '#c41e3a';
            const textColor = textColorInput ? textColorInput.value : '#ffffff';
            const borderColor = borderInput ? borderInput.value : '#c41e3a';
            
            const buttonStyle = style === 'solid' 
                ? `background-color: ${bgColor}; color: ${textColor}; border: 2px solid ${borderColor};`
                : `background-color: transparent; color: ${textColor}; border: 2px solid ${borderColor};`;
            
            html += `<a href="${url}" style="${buttonStyle} padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold; text-align: center; font-size: 14px;">${text || 'Botón'}</a>`;
        }
        
        html += '</div>';
    }
    
    html += '</div>'; // Cerrar wrapper
    
    return html;
}
// updatePreview necesita acceso al elemento preview (asegúrate que exista en el DOM)
function updatePreview(){
    const preview = document.getElementById('preview');
    if (!preview) return console.warn('Elemento #preview no encontrado.');
    
    const blockType = "{{ $block->type }}"; // si esto es blade, se reemplaza en servidor
    switch(blockType){
        case 'logo':
            if (typeof updateLogoPreview === 'function') { updateLogoPreview(); } else { preview.innerHTML = ''; }
            break;
        case 'image':
            if (typeof getImageHTML === 'function') preview.innerHTML = getImageHTML(); else preview.innerHTML = '';
            break;
        case 'grid':
            if (typeof getGridHTML === 'function') preview.innerHTML = getGridHTML(); else preview.innerHTML = '';
            break;
        case 'button':
            if (typeof getButtonHTML === 'function') preview.innerHTML = getButtonHTML(); else preview.innerHTML = '';
            break;
        case 'icono':
            if (typeof getIconTextHTML === 'function') preview.innerHTML = getIconTextHTML(); else preview.innerHTML = '';
            break;
        case 'banner':
            if (typeof getBannerHTML === 'function') preview.innerHTML = getBannerHTML(); else preview.innerHTML = '';
            break;
        case 'social':
            preview.innerHTML = getSocialHTML();
            break;
        case 'instructivo':
            preview.innerHTML = getInstructivoHTML();
            break;
        default:
            if (typeof getTextHTML === 'function') preview.innerHTML = getTextHTML(); else preview.innerHTML = '';
            break;
    }
}

// Update the DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    const blockType = "{{ $block->type }}";
    
    // Setup listeners según el tipo de bloque
    setupGridListeners();
    
    if(blockType === 'icono') {
        setupIconTextListeners();
    }
    
    if(blockType === 'banner') {
        setupBannerListeners();
    }
    if(blockType === 'social'){
        setupSocialListeners();
    }
    if(blockType ==='instructivo'){
        setupInstructivoListeners();
    }
    
    // Previsualización inicial
    updatePreview();
});

// Update the form submit event
ddocument.getElementById('mainForm').addEventListener('submit', function(e) {
    // Limpiar y actualizar todos los contenidos antes de enviar
    ['title','subtitle','message'].forEach(type=> {
        const editable = document.getElementById(type + 'Editable');
        const input = document.getElementById(type + 'Input');
        
        if(editable && input) {
            let content = editable.innerHTML;
            content = cleanUnderlineHTML(content);
            input.value = content;
        }
    });
    
    // Handle other form elements as before
    const gridGap = document.getElementById('gridGap');
    const gridBorderRadius = document.getElementById('gridBorderRadius');
    const iconTextGap = document.getElementById('iconTextGap');
    const iconTextBorderRadius = document.getElementById('iconTextBorderRadius');
    
    if (gridGap) {
        gridGap.setAttribute('value', gridGap.value);
    }
    
    if (gridBorderRadius) {
        gridBorderRadius.setAttribute('value', gridBorderRadius.value);
    }
    
    if (iconTextGap) {
        iconTextGap.setAttribute('value', iconTextGap.value);
    }
    
    if (iconTextBorderRadius) {
        iconTextBorderRadius.setAttribute('value', iconTextBorderRadius.value);
    }
    // Update banner text inputs
    const bannerTitleDiv = document.getElementById('bannerTitle');
    const bannerTitleInput = document.getElementById('bannerTitleInput');
    const bannerSubtitleDiv = document.getElementById('bannerSubtitle');
    const bannerSubtitleInput = document.getElementById('bannerSubtitleInput');

    if(bannerTitleDiv && bannerTitleInput) {
        bannerTitleInput.value = bannerTitleDiv.innerHTML;
    }
    if(bannerSubtitleDiv && bannerSubtitleInput) {
        bannerSubtitleInput.value = bannerSubtitleDiv.innerHTML;
    }
});

setupGridListeners();
updatePreview();

function preserveFontSizes(element) {
    // Find all elements with inline font-size styles and preserve them
    const elementsWithFontSize = element.querySelectorAll('[style*="font-size"]');
    elementsWithFontSize.forEach(el => {
        const fontSize = el.style.fontSize;
        if (fontSize) {
            el.setAttribute('data-font-size', fontSize);
        }
    });
}
// Toggle gradient controls visibility
document.getElementById('bannerGradientEnabled').addEventListener('change', function() {
    document.getElementById('bannerGradientControls').style.display = this.checked ? 'block' : 'none';
    updatePreview();
});
</script>

@endsection
