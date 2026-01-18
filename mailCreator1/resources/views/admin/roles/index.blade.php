@extends('layouts.app')
@php
    $protectedRoles = ['admin', 'marketing', 'facultades'];
@endphp

@push('styles')
<style>
    .info-box {
        background: linear-gradient(145deg, #f0f9ff, #e0f2fe);
        border-left: 4px solid #0ea5e9;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .create-role-card {
        background: linear-gradient(145deg, #f0f9ff, #e0f2fe);
        border: 2px dashed #0ea5e9;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
    }

    .roles-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(58, 87, 232, 0.12);
        overflow: hidden;
    }

    .roles-table table {
        margin-bottom: 0;
    }

    .roles-table thead {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        color: white;
    }

    .roles-table thead th {
        border: none;
        padding: 20px;
        font-weight: 600;
        font-size: 1rem;
    }

    .roles-table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .roles-table tbody tr:hover {
        background: #f8f9fa;
    }

    .roles-table tbody td {
        padding: 20px;
        vertical-align: middle;
    }

    .role-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        margin-right: 15px;
    }

    .role-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 1rem;
    }

    .role-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-badge.marketing {
        background: #dbeafe;
        color: #1e40af;
    }

    .role-badge.facultades {
        background: #fce7f3;
        color: #9f1239;
    }

    .role-badge.default {
        background: #e0e7ff;
        color: #3730a3;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-delete-role {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        margin-left: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-delete-role:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        color: white;
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
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
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4" style="color: #2d3748; font-weight: 700;">
                <i class="bi bi-shield-lock-fill me-2"></i>Gestión de Roles y Permisos
            </h2>
            
            <div class="info-box">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong></strong> Los permisos se asignan por rol. Todos los usuarios con el mismo rol tendrán los mismos permisos.
            </div>
        </div>
    </div>

    {{-- CREAR NUEVO ROL --}}
    <div class="row">
        <div class="col-12">
            <div class="create-role-card">
                <h5 class="mb-3"><i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Rol</h5>
                <form action="{{ route('admin.roles.create') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-5">
                        <input type="text" name="role_name" class="form-control" placeholder="Nombre del rol (ej: ventas)" required>
                        <small class="text-muted">Solo letras minúsculas, sin espacios</small>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="role_display_name" class="form-control" placeholder="Nombre para mostrar (ej: Ventas)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-1"></i>Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TABLA DE ROLES --}}
    <div class="row">
        <div class="col-12">
            <div class="roles-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Nombre para mostrar</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            @if($role->name === 'admin')
                                @continue
                            @endif
                            
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="role-avatar">
                                            {{ strtoupper(substr($role->name, 0, 1)) }}
                                        </div>
                                        <span class="role-name">{{ $role->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge {{ $role->name }}">
                                        {{ strtoupper($role->name) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.roles.edit', $role->name) }}" class="btn btn-edit btn-sm">
                                            Editar
                                        </a>

                                        @if(!in_array($role->name, $protectedRoles))
                                            <form action="{{ route('admin.roles.delete', $role->id) }}" method="POST" 
                                                onsubmit="return confirm('¿Estás seguro de eliminar este rol?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete-role btn-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection