@extends('layouts.app')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 
            0 4px 6px rgba(0, 0, 0, 0.05),
            0 10px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
        max-width: 420px;
        width: 100%;
        animation: fadeInUp 0.6s ease-out;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-header {
        background: white;
        border: none;
        padding: 40px 40px 20px;
        text-align: center;
        position: relative;
    }

    .login-title {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.5rem;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .login-subtitle {
        color: #718096;
        font-size: 0.9rem;
        margin-top: 8px;
        font-weight: 400;
    }

    .app-logo {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .app-logo::before {
        content: '✉';
        color: white;
        font-size: 22px;
    }

    .card-body {
        padding: 20px 40px 40px;
        background: white;
    }

    .form-floating {
        position: relative;
        margin-bottom: 20px;
    }

    .form-control {
        height: 52px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 18px 50px 6px 16px;
        font-size: 15px;
        transition: all 0.2s ease;
        background: #fafbfc;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.08);
        background: white;
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #fc8181;
        box-shadow: 0 0 0 3px rgba(252, 129, 129, 0.08);
    }

    .form-label {
        position: absolute;
        top: 17px;
        left: 16px;
        color: #718096;
        font-weight: 500;
        font-size: 15px;
        transition: all 0.2s ease;
        pointer-events: none;
        transform-origin: left top;
    }

    .form-control:focus ~ .form-label,
    .form-control:not(:placeholder-shown) ~ .form-label {
        transform: translateY(-11px) scale(0.82);
        color: #667eea;
        font-weight: 600;
    }

    .form-control.is-invalid ~ .form-label {
        color: #fc8181;
    }

    .input-icon {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 16px;
        transition: color 0.2s ease;
        pointer-events: none;
    }

    .form-control:focus ~ .input-icon {
        color: #667eea;
    }

    .invalid-feedback {
        display: block;
        margin-top: 6px;
        padding: 8px 12px;
        background: #fff5f5;
        border-left: 3px solid #fc8181;
        border-radius: 6px;
        color: #c53030;
        font-size: 13px;
        font-weight: 500;
    }

    .btn-login {
        width: 100%;
        height: 48px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        margin-top: 10px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .btn-login:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-login:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.25);
    }

    .btn-login:focus {
        box-shadow: 
            0 4px 12px rgba(102, 126, 234, 0.25),
            0 0 0 3px rgba(102, 126, 234, 0.15);
        color: white;
        outline: none;
    }

    .login-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }

    .version-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 14px;
        border-radius: 16px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
    }

    /* Loading state */
    .btn-login.loading {
        pointer-events: none;
        opacity: 0.85;
    }

    .btn-login.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 18px;
        height: 18px;
        margin: -9px 0 0 -9px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .login-container {
            padding: 15px;
        }
        
        .card-header {
            padding: 30px 30px 20px;
        }
        
        .card-body {
            padding: 20px 30px 30px;
        }
        
        .form-control {
            height: 50px;
            padding: 17px 48px 5px 14px;
        }
        
        .form-label {
            left: 14px;
            top: 16px;
        }
        
        .input-icon {
            right: 14px;
        }

        .app-logo {
            width: 52px;
            height: 52px;
        }

        .login-title {
            font-size: 1.35rem;
        }
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="card-header">
            <div class="app-logo"></div>
            <h1 class="login-title">{{ __('MailCreator') }}</h1>
            <p class="login-subtitle">{{ __('Inicie sesión para continuar') }}</p>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-floating">
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder=" ">
                    <label for="email" class="form-label">{{ __('Correo electrónico') }}</label>
                    <i class="fas fa-envelope input-icon"></i>
                    
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder=" ">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                    <i class="fas fa-lock input-icon"></i>
                    
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-login" id="loginBtn">
                    <span class="btn-text">{{ __('Iniciar Sesión') }}</span>
                </button>
            </form>

            <div class="login-footer">
                <div class="version-badge">v0.7</div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginBtn');
    
    form.addEventListener('submit', function() {
        btn.classList.add('loading');
        btn.querySelector('.btn-text').textContent = 'Iniciando sesión...';
    });
    
    // Auto-fade alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.invalid-feedback');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0.6';
        });
    }, 5000);
});
</script>
@endsection