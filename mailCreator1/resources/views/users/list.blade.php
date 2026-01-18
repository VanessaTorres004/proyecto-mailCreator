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
        font-size: 1.2rem;
        border-bottom: 3px solid #3a57e8;
    }

    .card-body {
        background: linear-gradient(145deg, #ffffff, #f8faff);
        padding: 30px;
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

    /* Buscador mejorado */
    .search-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(58, 87, 232, 0.08);
        border: 1px solid rgba(58, 87, 232, 0.1);
    }

    .input-group {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(58, 87, 232, 0.1);
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px 0 0 12px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
    }

    .form-control:focus {
        border-color: #3a57e8;
        box-shadow: 0 0 0 0.2rem rgba(58, 87, 232, 0.25);
        background: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        border: none;
        border-radius: 0 12px 12px 0;
        padding: 15px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a47d8, #5670da);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(58, 87, 232, 0.4);
        color: white;
    }

    /* Tabla mejorada */
    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(58, 87, 232, 0.08);
        border: 1px solid rgba(58, 87, 232, 0.05);
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #f8faff, #e8f0fe);
        border-bottom: 2px solid #3a57e8;
    }

    .table thead th {
        color: #2c3e50;
        font-weight: 700;
        padding: 20px;
        border: none;
        font-size: 1rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }

    .table tbody tr:hover {
        background: linear-gradient(145deg, #f8faff, #f0f3ff);
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(58, 87, 232, 0.1);
    }

    .table tbody td {
        padding: 20px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid rgba(58, 87, 232, 0.05);
        font-size: 0.95rem;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* User avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3a57e8, #667eea);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 12px;
        box-shadow: 0 4px 15px rgba(58, 87, 232, 0.3);
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-name {
        font-weight: 600;
        color: #2d3748;
    }

    /* Role badges */
    .role-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-admin {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .role-user {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    }

    .role-editor {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        color: white;
        box-shadow: 0 4px 15px rgba(237, 137, 54, 0.3);
    }

    /* Botones de acción */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-sm::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-sm:hover::before {
        left: 100%;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f6ad55, #ed8936);
        color: white;
        box-shadow: 0 4px 15px rgba(246, 173, 85, 0.3);
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(246, 173, 85, 0.4);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #fc8181, #e53e3e);
        color: white;
        box-shadow: 0 4px 15px rgba(252, 129, 129, 0.3);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #e53e3e, #c53030);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(252, 129, 129, 0.4);
        color: white;
    }

    /* Paginación */
    .pagination {
        margin-top: 30px;
    }

    .pagination .page-link {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        margin: 0 3px;
        padding: 10px 15px;
        color: #3a57e8;
        background: white;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: #3a57e8;
        color: white;
        border-color: #3a57e8;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(58, 87, 232, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        border-color: #3a57e8;
        color: white;
        box-shadow: 0 4px 15px rgba(58, 87, 232, 0.4);
    }

    /* Estado vacío */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-state::before {
        content: '👤';
        display: block;
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h5 {
        color: #4a5568;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 20px;
        }
        
        .search-container {
            padding: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .user-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .user-avatar {
            margin-right: 0;
            margin-bottom: 8px;
        }
    }

    /* Animaciones */
    .table tbody tr {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .table tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .table tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .table tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .table tbody tr:nth-child(5) { animation-delay: 0.5s; }

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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    <!-- Buscador -->
                    <div class="search-container">
                        <form method="GET" action="{{ route('users.list') }}" class="row align-items-center">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Buscar usuario por nombre o correo..."
                                           value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                            @if(request('search'))
                                <div class="col-md-4 mt-2 mt-md-0">
                                    <a href="{{ route('users.list') }}" class="btn btn-outline-secondary">
                                        Limpiar búsqueda
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Tabla -->
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Correo electrónico</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users->count() > 0)
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="user-info">
                                                        <div class="user-avatar">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                        <span class="user-name">{{ $user->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $user->email }}</span>
                                                </td>
                                                <td>
                                                    @foreach($user->getRoleNames() as $role)
                                                        <span class="role-badge role-{{ strtolower($role) }}">
                                                            {{ $role }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('users.edit', $user->id) }}" 
                                                           class="btn btn-warning btn-sm"
                                                           title="Editar usuario">
                                                            Editar
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm"
                                                                    title="Eliminar usuario">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="empty-state">
                                                <div>
                                                    <h5>No se encontraron usuarios</h5>
                                                    <p class="mb-0">
                                                        @if(request('search'))
                                                            No hay resultados para "{{ request('search') }}"
                                                        @else
                                                            No existen usuarios registrados
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación -->
                    @if ($users->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection