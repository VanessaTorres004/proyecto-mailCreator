@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(58, 87, 232, 0.15);
        overflow: hidden;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
    }

    .card-header {
        background: white;
        border: none;
        padding: 25px 30px;
        color: #2d3748;
        font-weight: 600;
        font-size: 1.3rem;
        border-bottom: 3px solid #3a57e8;
    }

    .card-body {
        padding: 40px;
        background: linear-gradient(145deg, #ffffff, #f8faff);
    }

    /* Alertas mejoradas */
    .alert {
        border: none;
        border-radius: 15px;
        padding: 20px 25px;
        font-weight: 500;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .alert::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
    }

    .alert-success::before {
        background: #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
    }

    .alert-danger::before {
        background: #dc3545;
    }

    /* Form container */
    .form-container {
        background: white;
        border-radius: 15px;
        padding: 35px;
        box-shadow: 0 8px 25px rgba(58, 87, 232, 0.08);
        border: 1px solid rgba(58, 87, 232, 0.05);
        position: relative;
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3a57e8, #667eea);
        border-radius: 15px 15px 0 0;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 10px;
        display: block;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px 18px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        border-color: #3a57e8;
        box-shadow: 0 0 0 0.2rem rgba(58, 87, 232, 0.25);
        background: white;
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: #e53e3e;
        box-shadow: 0 0 0 0.2rem rgba(229, 62, 62, 0.25);
    }

    /* Input icons */
    .input-group-icon {
        position: relative;
    }

    .input-group-icon .form-control {
        padding-left: 50px;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .form-control:focus ~ .input-icon {
        color: #3a57e8;
    }

    /* Password toggle */
    .password-toggle {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #a0aec0;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .password-toggle:hover {
        color: #3a57e8;
    }

    /* Role checkboxes */
    .roles-container {
        background: linear-gradient(145deg, #f8faff, #e8f0fe);
        border: 2px solid rgba(58, 87, 232, 0.1);
        border-radius: 15px;
        padding: 25px;
        margin-top: 10px;
    }

    .roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .role-option {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .role-option:hover {
        border-color: #3a57e8;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(58, 87, 232, 0.15);
    }

    .role-option.selected {
        border-color: #3a57e8;
        background: linear-gradient(145deg, #f8faff, #e8f0fe);
        box-shadow: 0 8px 25px rgba(58, 87, 232, 0.2);
    }

    .role-option.selected::after {
        content: '✓';
        position: absolute;
        top: 8px;
        right: 8px;
        background: #3a57e8;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
        margin: 0;
    }

    .form-check-input:checked {
        background-color: #3a57e8;
        border-color: #3a57e8;
        box-shadow: 0 0 0 3px rgba(58, 87, 232, 0.2);
    }

    .form-check-label {
        font-weight: 600;
        color: #4a5568;
        cursor: pointer;
        margin: 0;
        text-transform: capitalize;
    }

    .role-description {
        font-size: 0.85rem;
        color: #718096;
        margin-top: 4px;
    }

    /* Role icons */
    .role-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: bold;
        color: white;
        margin-right: 8px;
    }

    .role-admin .role-icon {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .role-user .role-icon {
        background: linear-gradient(135deg, #48bb78, #38a169);
    }

    .role-editor .role-icon {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
    }

    .role-manager .role-icon {
        background: linear-gradient(135deg, #9f7aea, #805ad5);
    }

    /* Error messages */
    .text-danger {
        color: #e53e3e;
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 8px;
        display: flex;
        align-items: center;
    }

    .text-danger::before {
        content: '⚠';
        margin-right: 6px;
        font-size: 1rem;
    }

    /* Buttons */
    .btn {
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        color: white;
        box-shadow: 0 8px 20px rgba(58, 87, 232, 0.3);
        padding: 15px 40px;
        font-size: 1.1rem;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a47d8, #5670da);
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(58, 87, 232, 0.4);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #495057);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(108, 117, 125, 0.4);
        color: white;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        padding-top: 25px;
        border-top: 2px solid #f1f5f9;
    }

    /* Form title */
    .form-title {
        color: #3a57e8;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }

    .form-title::before {
        content: '👤';
        margin-right: 10px;
        font-size: 1.3rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 25px;
        }

        .form-container {
            padding: 25px;
        }

        .roles-grid {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column-reverse;
            gap: 15px;
        }

        .btn {
            width: 100%;
        }
    }

    /* Animation */
    .form-container {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
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
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Crear Usuario</h4>
                </div>
                <div class="card-body">
                    <div class="form-container">
                        <div class="form-title">Información del Usuario</div>
                        
                        <form action="{{$action}}" method="POST" id="userForm">
                            @csrf
                            
                            <div class="form-section">
                                <label class="form-label">Nombre Completo</label>
                                <div class="input-group-icon">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name ?? '') }}" 
                                           placeholder="Ingrese el nombre completo">
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-section">
                                <label class="form-label">Correo Electrónico</label>
                                <div class="input-group-icon">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}"
                                           placeholder="ejemplo@correo.com">
                                    <i class="fas fa-envelope input-icon"></i>
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-section">
                                <label class="form-label">
                                    Contraseña 
                                    @if(isset($user))
                                        <span class="text-muted">(dejar en blanco para mantener la actual)</span>
                                    @endif
                                </label>
                                <div class="input-group-icon">
                                    <input type="password" name="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Ingrese la contraseña">
                                    <i class="fas fa-lock input-icon"></i>
                                    <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-section">
                                <label class="form-label">Roles del Usuario</label>
                                <div class="roles-container">
                                    <div class="roles-grid">
                                        @foreach ($roles as $role)
                                            <div class="role-option role-{{ strtolower($role->name) }} {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}"
                                                 onclick="toggleRole(this, {{ $role->id }})">
                                                <div class="role-icon">
                                                    @if($role->name == 'admin')
                                                        👑
                                                    @elseif($role->name == 'user')
                                                        👤
                                                    @elseif($role->name == 'editor')
                                                        ✏️
                                                    @elseif($role->name == 'manager')
                                                        💼
                                                    @else
                                                        🔧
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input class="form-check-input d-none" type="checkbox" name="roles[]" 
                                                           value="{{ $role->id }}" id="role_{{ $role->id }}"
                                                           {{ isset($user) && $user->hasRole($role->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                                        {{ ucfirst($role->name) }}
                                                    </label>
                                                    <div class="role-description">
                                                        @switch($role->name)
                                                            @case('admin')
                                                                Acceso completo al sistema
                                                                @break
                                                            @case('user')
                                                                Usuario estándar
                                                                @break
                                                            @case('editor')
                                                                Puede editar contenido
                                                                @break
                                                            @case('manager')
                                                                Gestiona usuarios y contenido
                                                                @break
                                                            @default
                                                                Rol personalizado
                                                        @endswitch
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('roles')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.password-toggle');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

function toggleRole(element, roleId) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    const isSelected = element.classList.contains('selected');
    
    if (isSelected) {
        element.classList.remove('selected');
        checkbox.checked = false;
    } else {
        element.classList.add('selected');
        checkbox.checked = true;
    }
}

// Form validation feedback
document.getElementById('userForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
    submitBtn.disabled = true;
    
    // Re-enable if there's an error (this would be handled by the backend)
    setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>

@endsection