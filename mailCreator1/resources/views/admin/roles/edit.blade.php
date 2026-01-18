@extends('layouts.app')

@push('styles')
<style>
    .role-header-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .role-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2rem;
        border: 4px solid rgba(255,255,255,0.3);
        margin-right: 20px;
    }

    .role-details h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: #ffffff !important;
    }

    .role-details .role-description {
        opacity: 0.9;
        font-size: 1rem;
        margin-top: 5px;
        color: #ffffff !important;
    }

    .permissions-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(58, 87, 232, 0.12);
        padding: 25px;
        margin-bottom: 30px;
    }

    .permissions-card h5 {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .permission-group {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #3a57e8;
    }

    .permission-group h6 {
        color: #3a57e8;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .form-check {
        margin-bottom: 12px;
        padding-left: 1.8rem;
    }

    .form-check-input:checked {
        background-color: #3a57e8;
        border-color: #3a57e8;
    }

    .btn-save {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(58, 87, 232, 0.4);
        color: white;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
        color: white;
    }

    .text-sizes-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .text-size-option {
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>
@endpush

@section('content')

@if (session('message'))
<div class="container-fluid p-3">
    <div class="alert alert-{{ session('code') === '200' ? 'success' : 'danger' }}">
        {{ session('message') }}
    </div>
</div>
@endif

<div class="container-fluid p-3">
    {{-- ROLE HEADER --}}
    <div class="role-header-card">
        <div class="d-flex align-items-center">
            <div class="role-icon-large">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <div class="role-details">
                <h2>Editar Rol: {{ strtoupper($role->name) }}</h2>
                <div class="role-description">Configuración de permisos globales para este rol</div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.roles.update', $role->name) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- CUSTOM PERMISSIONS --}}
        <div class="permissions-card">
            <h5><i class="bi bi-sliders me-2"></i>Permisos del Rol</h5>

            <div class="permission-group">
                <h6><i class="bi bi-envelope-fill me-2"></i>Permisos de Campaña</h6>
                
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_use_custom_header" id="can_use_custom_header" 
                        {{ $permissions && $permissions->can_use_custom_header ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_use_custom_header">
                        Permitir headers personalizados
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_use_custom_footer" id="can_use_custom_footer"
                        {{ $permissions && $permissions->can_use_custom_footer ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_use_custom_footer">
                        Permitir footers personalizados
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_use_custom_logo" id="can_use_custom_logo"
                        {{ $permissions && $permissions->can_use_custom_logo ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_use_custom_logo">
                        Permitir logos personalizados
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_change_theme_color" id="can_change_theme_color"
                        {{ $permissions && $permissions->can_change_theme_color ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_change_theme_color">
                        Permitir cambiar color de tema
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_change_background_color" id="can_change_background_color"
                        {{ $permissions && $permissions->can_change_background_color ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_change_background_color">
                        Permitir cambiar color de fondo
                    </label>
                </div>
            </div>

            <div class="permission-group">
                <h6><i class="bi bi-font me-2"></i>Permisos de Bloques</h6>
                
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="can_use_custom_text_sizes" id="can_use_custom_text_sizes"
                        {{ $permissions && $permissions->can_use_custom_text_sizes ? 'checked' : '' }}>
                    <label class="form-check-label" for="can_use_custom_text_sizes">
                        Permitir todos los tamaños de texto
                    </label>
                </div>

                <div class="text-sizes-container" id="text_sizes_options" 
                     style="display: {{ $permissions && $permissions->can_use_custom_text_sizes ? 'none' : 'flex' }}">
                    <small class="text-muted w-100 mb-2">Tamaños permitidos:</small>
                    @foreach([12, 14, 16, 18, 20, 24, 28, 32] as $size)
                    <div class="text-size-option">
                        <input type="checkbox" name="allowed_text_sizes[]" value="{{ $size }}" 
                            id="size_{{ $size }}"
                            {{ $permissions && in_array($size, $permissions->allowed_text_sizes ?? [14,16,18]) ? 'checked' : '' }}>
                        <label for="size_{{ $size }}">{{ $size }}px</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-cancel">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
            <button type="submit" class="btn btn-save">
                <i class="bi bi-save me-2"></i>Guardar Cambios
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('can_use_custom_text_sizes')?.addEventListener('change', function() {
    document.getElementById('text_sizes_options').style.display = this.checked ? 'none' : 'flex';
});
</script>
@endpush

@endsection