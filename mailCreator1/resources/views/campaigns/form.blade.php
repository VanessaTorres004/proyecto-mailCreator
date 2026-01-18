@php
    // Obtener permisos del usuario actual
    $permissions = \App\Http\Controllers\RolePermissionsController::getUserPermissions();
@endphp

@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(58, 87, 232, 0.12);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        border: none;
        padding: 20px 25px;
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .card-body {
        padding: 30px;
        background: #ffffff;
    }

    .alert {
        border: none;
        border-radius: 12px;
        padding: 15px 20px;
        font-weight: 500;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .control-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 6px;
        display: block;
        font-size: 0.9rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #ffffff;
        height: 40px;
    }

    .form-control:focus {
        border-color: #3a57e8;
        box-shadow: 0 0 0 0.15rem rgba(58, 87, 232, 0.2);
        background: white;
    }

    .form-control-color {
        width: 50px;
        height: 42px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 2px;
    }

    .form-control-color:hover {
        transform: scale(1.05);
        box-shadow: 0 3px 12px rgba(58, 87, 232, 0.2);
    }

    .logo-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .logo-option {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .logo-option:hover {
        border-color: #3a57e8;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(58, 87, 232, 0.15);
    }

    .logo-option.selected {
        border-color: #3a57e8;
        background: linear-gradient(145deg, #f8faff, #e8f0fe);
        box-shadow: 0 6px 20px rgba(58, 87, 232, 0.2);
    }

    .logo-option .logo-image-container {
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .logo-option img {
        max-width: 100%;
        max-height: 80px;
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 6px;
    }

    .logo-option#logo-blanco .logo-image-container {
        background-color: #c10230;
        border-radius: 8px;
        padding: 10px;
    }

    .custom-logo-preview {
        background: white;
        border: 3px dashed #cbd5e0;
        border-radius: 12px;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .custom-logo-preview:hover {
        border-color: #3a57e8;
        background: #f7fafc;
        transform: scale(1.02);
    }

    .custom-logo-preview.empty {
        background: linear-gradient(145deg, #ffffff, #f1f5f9);
    }

    .custom-logo-preview img {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        display: block;
    }

    .custom-logo-preview .placeholder-content {
        text-align: center;
        padding: 30px;
    }

    .custom-logo-preview .placeholder-content i {
        font-size: 3rem;
        color: #3a57e8;
        display: block;
        margin-bottom: 15px;
    }

    .custom-logo-preview .placeholder-content span {
        display: block;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .custom-logo-preview .placeholder-content small {
        color: #718096;
        font-size: 0.85rem;
    }

    .custom-logo-preview .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(58, 87, 232, 0.9);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: white;
    }

    .custom-logo-preview:hover .overlay {
        opacity: 1;
    }

    .custom-logo-preview .overlay i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .custom-logo-preview .overlay span {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .menu-item {
        background: #f8f9fa;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-item .form-control {
        margin-bottom: 0;
    }

    .form-check-input:checked {
        background-color: #3a57e8;
        border-color: #3a57e8;
    }

    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.3em;
    }

    .btn {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        color: white;
        box-shadow: 0 6px 18px rgba(58, 87, 232, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a47d8, #5670da);
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(58, 87, 232, 0.4);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1fa185);
        transform: translateY(-2px);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333, #a71e2a);
        transform: translateY(-2px);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #495057);
        transform: translateY(-2px);
        color: white;
    }

    .btn-add {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        padding: 0;
        flex-shrink: 0;
    }

    .image-preview-container {
        margin-top: 15px;
        text-align: center;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-preview {
        max-width: 250px;
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .text-danger {
        color: #dc3545;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 4px;
    }

    .conditional-fields {
        background: linear-gradient(145deg, #f0f9ff, #e0f2fe);
        border: 2px solid #0ea5e9;
        border-radius: 12px;
        padding: 20px;
        margin-top: 15px;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .logo-options {
            grid-template-columns: 1fr;
        }
        
        .menu-item {
            flex-direction: column;
            align-items: stretch;
        }
        
        .card-body {
            padding: 20px;
        }
    }
</style>

<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-colorpicker/css/colorpicker.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/bootstrap-switch/static/stylesheets/bootstrap-switch.css')}}" />
@endpush

@section('content')

@include('components.breadcrumb', compact('breadcrumbs'))

@if (session('message'))
<div class="container-fluid p-3">
    <div class="alert alert-{{ session('code') === '200' ? 'success' : 'danger' }}">
        {{ session('message') }}
    </div>
</div>
@endif

<div class="container-fluid p-3">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0" style="color: white;">Crear campaña</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-10 mx-auto">
                        <form action="{{$action}}" class="form-horizontal" id="validation-form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label" for="title">Título de la Campaña:</label>
                                        <input type="text" name="title" id="title" class="form-control" value="{{$campaign->title}}" data-rule-required="true" data-rule-minlength="3" placeholder="Ingrese el título de la campaña" />
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="link">Enlace a:</label>
                                        <input type="text" name="link" id="link" class="form-control" value="{{$campaign->link}}" data-rule-required="true" placeholder="https://ejemplo.com" />
                                        @error('link')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
    {{-- COLOR DE TEMA --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Color del Tema:</label>
            
            @if($permissions->can_change_theme_color)
                {{-- USUARIO PUEDE CAMBIAR COLOR --}}
                <div class="d-flex align-items-center gap-2">
                    <input type="color" id="colorPicker" class="form-control-color" 
                        value="{{ $campaign->color }}"
                        onchange="document.getElementById('colorInput').value = this.value;">
                    <input type="text" class="form-control" id="colorInput" 
                        name="color" value="{{ $campaign->color }}" 
                        data-rule-required="true"
                        oninput="document.getElementById('colorPicker').value = this.value;"
                        placeholder="#3a57e8">
                </div>
            @else
                {{-- COLOR FORZADO --}}
                <input type="hidden" name="color" value="{{ $permissions->forced_theme_color }}">
                <div class="d-flex align-items-center gap-2">
                    <input type="color" class="form-control-color" value="{{ $permissions->forced_theme_color }}" disabled>
                    <input type="text" class="form-control" value="{{ $permissions->forced_theme_color }}" disabled>
                </div>
                <small class="text-muted">
                    <i class="bi bi-lock-fill"></i> Color forzado por tu rol
                </small>
            @endif
        </div>
    </div>

    {{-- COLOR DE FONDO --}}
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">Color de Fondo:</label>
            
            @if($permissions->can_change_background_color)
                {{-- USUARIO PUEDE CAMBIAR COLOR --}}
                <div class="d-flex align-items-center gap-2">
                    <input type="color" id="backgroundPicker" class="form-control-color"
                        value="{{ $campaign->background }}"
                        onchange="document.getElementById('backgroundInput').value = this.value;">
                    <input type="text" class="form-control" id="backgroundInput"
                        name="background" value="{{ $campaign->background }}"
                        data-rule-required="true"
                        oninput="document.getElementById('backgroundPicker').value = this.value;"
                        placeholder="#ffffff">
                </div>
            @else
                {{-- COLOR FORZADO --}}
                <input type="hidden" name="background" value="{{ $permissions->forced_background_color }}">
                <div class="d-flex align-items-center gap-2">
                    <input type="color" class="form-control-color" value="{{ $permissions->forced_background_color }}" disabled>
                    <input type="text" class="form-control" value="{{ $permissions->forced_background_color }}" disabled>
                </div>
                <small class="text-muted">
                    <i class="bi bi-lock-fill"></i> Color forzado por tu rol
                </small>
            @endif
        </div>
    </div>
</div>

                            <div class="form-group">
                                <label class="control-label">Redes Sociales:</label>
                                <p class="text-muted mb-2">Las redes sociales por defecto son las de UDLA, pero puedes cambiar el enlace o dejarlo vacío.</p>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="facebook">Facebook:</label>
                                            <input type="text" name="facebook" id="facebook" class="form-control" value="{{$campaign->facebook ?: 'UDLAEcuador'}}" data-rule-minlength="3" placeholder="Usuario de Facebook" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="twitter">Twitter:</label>
                                            <input type="text" name="twitter" id="twitter" class="form-control" value="{{$campaign->twitter ?: 'UDLAEcuador'}}" data-rule-minlength="3" placeholder="Usuario de Twitter" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="linkedin">LinkedIn:</label>
                                            <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{$campaign->linkedin ?: 'school/universidad-de-las-americas-ecuador/'}}" data-rule-minlength="3" placeholder="Perfil de LinkedIn" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="youtube">YouTube:</label>
                                            <input type="text" name="youtube" id="youtube" class="form-control" value="{{$campaign->youtube ?: 'user/UDLAUIO'}}" data-rule-minlength="3" placeholder="Canal de YouTube" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="instagram">Instagram:</label>
                                            <input type="text" name="instagram" id="instagram" class="form-control" value="{{$campaign->instagram ?: 'udlaecuador/'}}" data-rule-minlength="3" placeholder="Usuario de Instagram" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="tiktok">TikTok:</label>
                                            <input type="text" name="tiktok" id="tiktok" class="form-control" value="{{$campaign->tiktok ?: '@udlaec/'}}" data-rule-minlength="3" placeholder="Usuario de TikTok" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
    <label class="control-label">Logo de Campaña:</label>
    
    @if($permissions->can_use_custom_logo)
        {{-- USUARIO PUEDE ELEGIR: Muestra todos los logos --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <p class="text-muted mb-3">Selecciona un logo predefinido o sube uno personalizado</p>
                <div class="logo-options">
                    <div class="logo-option {{ $campaign->logo == 'blanco.png' ? 'selected' : '' }}" id="logo-blanco" onclick="selectLogo('blanco')">
                        <input class="form-check-input d-none" type="radio" name="logo_type" id="logo_type_blanco" value="blanco.png" {{ $campaign->logo == 'blanco.png' ? 'checked' : '' }}>
                        <div class="logo-image-container">
                            <img src="{{ asset('img/blanco.png') }}" alt="Logo UDLA blanco" id="preview-blanco">
                        </div>
                        <span class="d-block small font-weight-bold mt-2">Logo UDLA Blanco</span>
                    </div>

                    <div class="logo-option {{ $campaign->logo == 'rojo.png' ? 'selected' : '' }}" id="logo-rojo" onclick="selectLogo('rojo')">
                        <input class="form-check-input d-none" type="radio" name="logo_type" id="logo_type_rojo" value="rojo.png" {{ $campaign->logo == 'rojo.png' ? 'checked' : '' }}>
                        <div class="logo-image-container">
                            <img src="{{ asset('img/rojo.png') }}" alt="Logo UDLA rojo" id="preview-rojo">
                        </div>
                        <span class="d-block small font-weight-bold mt-2">Logo UDLA Rojo</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Logo Personalizado --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border: 2px solid #e2e8f0;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <h6 class="mb-0" style="color: white;">
                            <i class="fa fa-upload me-2" style="margin-bottom:10px"></i>Logo Personalizado
                        </h6>
                    </div>
                    <div class="card-body" style="background: #f8f9fa;">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <input type="file" class="d-none" id="logo_file" name="logo" accept="image/*" onchange="previewCustomLogo(this)">
                                <input class="form-check-input d-none" type="radio" name="logo_type" id="logo_type_personalizado" value="personalizado" {{ !in_array($campaign->logo, ['blanco.png', 'rojo.png']) ? 'checked' : '' }}>
                                
                                <button type="button" class="btn btn-primary btn-lg w-100" onclick="document.getElementById('logo_file').click()">
                                    <i class="fa fa-cloud-upload me-2"></i>Seleccionar Archivo
                                </button>
                            </div>
                            <div class="col-md-8">
                                <div id="preview-personalizado" class="custom-logo-preview {{ !in_array($campaign->logo, ['blanco.png', 'rojo.png']) && $campaign->logo ? '' : 'empty' }}" onclick="document.getElementById('logo_file').click()">
                                    @if(!in_array($campaign->logo, ['blanco.png', 'rojo.png']) && $campaign->logo)
                                        <img src="{{ asset('storage/logos/'.$campaign->logo) }}" alt="Logo personalizado">
                                    @else
                                        <div class="placeholder-content">
                                            <i class="fa fa-image"></i>
                                            <span>Vista previa del logo</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- USUARIO RESTRINGIDO: Solo muestra el logo forzado, sin opciones --}}
        <input type="hidden" name="logo_type" value="{{ $permissions->forced_logo }}">
        
        <div class="alert alert-info d-flex align-items-center">
            <i class="bi bi-lock-fill me-2" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Logo asignado por tu rol:</strong><br>
                <small>Tu rol solo puede usar el logo: <strong>{{ $permissions->forced_logo }}</strong></small>
            </div>
        </div>
        
        <div class="text-center p-4 bg-light rounded">
            @if($permissions->forced_logo == 'blanco.png')
                <div style="background-color: #c10230; padding: 20px; border-radius: 8px; display: inline-block;">
                    <img src="{{ asset('img/blanco.png') }}" alt="Logo forzado" style="max-width: 200px; height: auto;">
                </div>
            @else
                <img src="{{ asset('img/'.$permissions->forced_logo) }}" alt="Logo forzado" style="max-width: 200px; height: auto; border-radius: 8px;">
            @endif
            <p class="text-muted mt-3 mb-0">Este es el único logo disponible para tu rol</p>
        </div>
    @endif
</div>
                            <!-- SECCIÓN DE MENÚ COMENTADA
                            <div class="form-group">
                                <label class="control-label">Menú:</label>
                                <div class="menu-item">
                                    <input type="text" name="menu_url[]" class="form-control" data-rule-url="true" value="{{$campaign->menus[0]['url'] ?? ''}}" placeholder="https://ejemplo.com"/>
                                    <input type="text" name="menu_nombres[]" class="form-control" value="{{$campaign->menus[0]['nombre'] ?? ''}}" data-rule-minlength="3" placeholder="Nombre del enlace" />
                                    <button type="button" class="btn btn-success btn-add" onclick="addMenu(1)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                
                                <div id="menus">
                                    @if(count($campaign->menus ?? []) > 1)
                                        @for($i = 1; $i < count($campaign->menus); $i++)
                                            <div id="{{$i}}" class="menu-item">
                                                <input type="text" value="{{$campaign->menus[$i]['url']}}" name="menu_url[]" class="form-control" data-rule-required="true" data-rule-url="true" placeholder="https://ejemplo.com"/>
                                                <input type="text" value="{{$campaign->menus[$i]['nombre']}}" name="menu_nombres[]" class="form-control" data-rule-required="true" data-rule-minlength="3" placeholder="Nombre del enlace" />
                                                <button type="button" class="btn btn-success btn-add" onclick="addMenu({{$i+1}})">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-add" onclick="removeMenu({{$i}})">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                            -->
                            
                            <div class="form-group">
                                <label class="control-label">Configuración de Envío:</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="envio" name="envio" value="1" {{ $campaign->envio == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="envio" id="envioStatusLabel">
                                        ¿Desea enviar este correo? {{ $campaign->envio == 1 ? 'SÍ' : 'NO' }}
                                    </label>
                                </div>
                                
                                <div id="correoCampos" class="conditional-fields" style="display: {{ $campaign->envio == 1 ? 'block' : 'none' }};">
                                    <div class="form-group">
                                        <label class="control-label" for="cuenta">Cuenta:</label>
                                        <input type="text" name="cuenta" id="cuenta" class="form-control" value="{{ $campaign->cuenta }}" placeholder="correo@ejemplo.com" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="asunto">Asunto:</label>
                                        <input type="text" name="asunto" id="asunto" class="form-control" value="{{ $campaign->asunto }}" placeholder="Asunto del correo" />
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="control-label" for="destino">Para (separados con ;):</label>
                                        <input type="text" name="destino" id="destino" class="form-control" value="{{ $campaign->destino }}" placeholder="correo1@ejemplo.com;correo2@ejemplo.com" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
    {{-- HEADER --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="header_template" class="control-label">Header personalizado:</label>
            
            @if($permissions->can_use_custom_header)
                {{-- USUARIO PUEDE ELEGIR HEADER --}}
                <select name="header_template" id="header_template" class="form-control" data-img-path="{{ asset('img/headers') }}">
                    <option value="header0" {{ $campaign->header_template == 'header0' ? 'selected' : '' }}>Header por defecto</option>
                    <option value="" {{ $campaign->header_template == '' ? 'selected' : '' }}>Sin Header</option>
                    @foreach (File::files(resource_path('views/components/headers')) as $file)
                        @php $name = basename($file, '.blade.php'); @endphp
                        @if (!in_array($name, ['header0', 'defaulth']))
                            <option value="{{ $name }}" {{ $campaign->header_template == $name ? 'selected' : '' }}>
                                {{ ucfirst($name) }}
                            </option>
                        @endif
                    @endforeach
                </select>
            @else
                {{-- HEADER FORZADO --}}
                <input type="hidden" name="header_template" value="{{ $permissions->forced_header }}">
                <input type="text" class="form-control" value="{{ $permissions->forced_header }}" disabled>
                <small class="text-muted">
                    <i class="bi bi-lock-fill"></i> Tu rol solo puede usar este header
                </small>
            @endif
            
            <div id="header_preview" class="image-preview-container">
                @php
                    $selectedHeader = $permissions->can_use_custom_header 
                        ? ($campaign->header_template && $campaign->header_template !== '' ? $campaign->header_template : null)
                        : $permissions->forced_header;
                @endphp
                @if($selectedHeader)
                    <img src="{{ asset('img/headers/'.$selectedHeader.'.png') }}" alt="Header Preview" class="image-preview">
                @endif
            </div>
        </div>
    </div>
    
    {{-- FOOTER --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="footer_template" class="control-label">Footer personalizado:</label>
            
            @if($permissions->can_use_custom_footer)
                {{-- USUARIO PUEDE ELEGIR FOOTER --}}
                <select name="footer_template" id="footer_template" class="form-control" data-img-path="{{ asset('img/footers') }}">
                    <option value="footer0" {{ $campaign->footer_template == 'footer0' ? 'selected' : '' }}>Footer por defecto</option>
                    <option value="" {{ $campaign->footer_template == '' ? 'selected' : '' }}>Sin Footer</option>
                    @foreach (File::files(resource_path('views/components/footers')) as $file)
                        @php $name = basename($file, '.blade.php'); @endphp
                        @if (!in_array($name, ['footer0', 'defaultf']))
                            <option value="{{ $name }}" {{ $campaign->footer_template == $name ? 'selected' : '' }}>
                                {{ ucfirst($name) }}
                            </option>
                        @endif
                    @endforeach
                </select>
            @else
                {{-- FOOTER FORZADO --}}
                <input type="hidden" name="footer_template" value="{{ $permissions->forced_footer }}">
                <input type="text" class="form-control" value="{{ $permissions->forced_footer }}" disabled>
                <small class="text-muted">
                    <i class="bi bi-lock-fill"></i> Tu rol solo puede usar este footer
                </small>
            @endif
            
            <div id="footer_preview" class="image-preview-container">
                @php
                    $selectedFooter = $permissions->can_use_custom_footer
                        ? ($campaign->footer_template && $campaign->footer_template !== '' ? $campaign->footer_template : null)
                        : $permissions->forced_footer;
                @endphp
                @if($selectedFooter)
                    <img src="{{ asset('img/footers/'.$selectedFooter.'.png') }}" alt="Footer Preview" class="image-preview">
                @endif
            </div>
        </div>
    </div>
</div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href ='{{url('campaigns/list')}}'">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Guardar Campaña
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectLogo(type) {
    // Remover selección de todos los logos predefinidos
    document.querySelectorAll('.logo-option').forEach(el => el.classList.remove('selected'));
    
    // Agregar selección al logo clickeado
    const logoElement = document.getElementById('logo-' + type);
    logoElement.classList.add('selected');
    
    // Marcar el radio button correspondiente
    document.getElementById('logo_type_' + type).checked = true;
}

function previewCustomLogo(input) {
    const preview = document.getElementById('preview-personalizado');
    const radioBtn = document.getElementById('logo_type_personalizado');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Remover selección de logos predefinidos
            document.querySelectorAll('.logo-option').forEach(el => el.classList.remove('selected'));
            
            // Marcar el radio button de personalizado
            radioBtn.checked = true;
            
            // Actualizar la vista previa
            preview.classList.remove('empty');
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Logo personalizado" id="custom-logo-img">
                <div class="overlay">
                    <i class="fa fa-sync-alt"></i>
                    <span>Cambiar logo</span>
                </div>
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('envio').addEventListener('change', function() {
    const isChecked = this.checked;
    const label = document.getElementById('envioStatusLabel');
    const campos = document.getElementById('correoCampos');
    
    label.textContent = '¿Desea enviar este correo? ' + (isChecked ? 'SÍ' : 'NO');
    campos.style.display = isChecked ? 'block' : 'none';
});

function updatePreview(selectId, previewId) {
    const select = document.getElementById(selectId);
    const preview = document.getElementById(previewId);
    const basePath = select.getAttribute('data-img-path');

    select.addEventListener('change', function () {
        if (this.value) {
            preview.innerHTML = `<img src="${basePath}/${this.value}.png" alt="Preview" class="image-preview">`;
        } else {
            preview.innerHTML = `<div class="text-muted">Vista previa del ${selectId.includes('header') ? 'header' : 'footer'}</div>`;
        }
    });
}

updatePreview('header_template', 'header_preview');
updatePreview('footer_template', 'footer_preview');

function addMenu(index) {
    const menuHtml = `
        <div id="${index}" class="menu-item">
            <input type="text" name="menu_url[]" class="form-control" data-rule-required="true" data-rule-url="true" placeholder="https://ejemplo.com"/>
            <input type="text" name="menu_nombres[]" class="form-control" data-rule-required="true" data-rule-minlength="3" placeholder="Nombre del enlace" />
            <button type="button" class="btn btn-success btn-add" onclick="addMenu(${index + 1})">
                <i class="fa fa-plus"></i>
            </button>
            <button type="button" class="btn btn-danger btn-add" onclick="removeMenu(${index})">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    `;
    document.getElementById('menus').insertAdjacentHTML('beforeend', menuHtml);
}

function removeMenu(index) {
    document.getElementById(index).remove();
}

// Hacer que al hacer clic en la vista previa personalizada se seleccione automáticamente
document.addEventListener('DOMContentLoaded', function() {
    const customPreview = document.getElementById('preview-personalizado');
    if (customPreview) {
        customPreview.addEventListener('click', function() {
            // Si ya hay una imagen, también selecciona el radio button
            if (!this.classList.contains('empty')) {
                document.getElementById('logo_type_personalizado').checked = true;
                document.querySelectorAll('.logo-option').forEach(el => el.classList.remove('selected'));
            }
        });
    }
});
</script>

@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/jquery-validation/dist/additional-methods.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap-switch/static/js/bootstrap-switch.js')}}"></script>
@endpush