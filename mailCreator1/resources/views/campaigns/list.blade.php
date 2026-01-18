@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #f8f9fa;
        min-height: 100vh;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        background: white;
    }

    .card-header {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        border: none;
        padding: 14px 20px;
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 12px 12px 0 0;
    }

    .card-body {
        padding: 16px;

    }

    .alert {
        border: none;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.8rem;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 3px solid #28a745;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 3px solid #dc3545;
    }

    .search-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #e9ecef;
    }

    .input-group {
        border-radius: 6px;
        overflow: hidden;
    }

    .form-control {
        border: 1px solid #dee2e6;
        border-radius: 6px 0 0 6px;
        padding: 6px 10px;
        font-size: 0.8rem;
        height: 32px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #3a57e8;
        box-shadow: 0 0 0 0.15rem rgba(58, 87, 232, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #3a57e8, #667eea);
        border: none;
        border-radius: 0 6px 6px 0;
        padding: 6px 14px;
        font-size: 0.8rem;
        height: 32px;
        transition: all 0.2s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a47d8, #5670da);
        box-shadow: 0 2px 8px rgba(58, 87, 232, 0.3);
    }

    .btn-outline-secondary {
        border: 1px solid #6c757d;
        color: #6c757d;
        padding: 6px 12px;
        font-size: 0.8rem;
        height: 32px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        color: white;
    }

    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .table {
        margin: 0;
        font-size: 0.8rem;
    }

    .table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table thead th {
        color: #495057;
        font-weight: 600;
        padding: 8px 12px;
        border: none;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .table tbody tr {
        transition: background 0.15s ease;
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .table tbody td {
        padding: 6px 12px;
        vertical-align: middle;
        border: none;
        color: #495057;
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        font-weight: 500;
    }

    .no-records {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .no-records i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.3;
    }

    .btn-group-sm .btn {
        padding: 5px 9px;
        margin: 0 1px;
        border-radius: 5px;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        border-width: 1px;
    }

    .btn-outline-success {
        border-color: #28a745;
        color: #28a745;
    }

    .btn-outline-success:hover {
        background: #28a745;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-primary {
        border-color: #3a57e8;
        color: #3a57e8;
    }

    .btn-outline-primary:hover {
        background: #3a57e8;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-info {
        border-color: #17a2b8;
        color: #17a2b8;
    }

    .btn-outline-info:hover {
        background: #17a2b8;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-1px);
    }

    /* Added delegate button style */
    .btn-outline-warning {
        border-color: #ffc107;
        color: #ffc107;
    }

    .btn-outline-warning:hover {
        background: #ffc107;
        color: #212529;
        transform: translateY(-1px);
    }

    .status-indicator {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .status-active {
        background: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.4);
    }

    .status-inactive {
        background: #6c757d;
    }

    .pagination {
        margin-top: 16px;
        margin-bottom: 0;
    }

    .pagination .page-item {
        margin: 0 2px;
    }

    .pagination .page-link {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.85rem;
        color: #3a57e8;
        transition: all 0.2s ease;
        background: white;
    }

    .pagination .page-link:hover {
        background: #3a57e8;
        color: white;
        border-color: #3a57e8;
    }

    .pagination .page-item.active .page-link {
        background: #3a57e8;
        border-color: #3a57e8;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }

    nav[role="navigation"] {
        display: block !important;
        width: 100%;
    }

    .fas {
        font-size: 0.85rem;
    }

    .text-muted {
        font-size: 0.8rem;
    }

    strong {
        font-weight: 600;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 14px;
        }
        
        .search-container {
            padding: 12px;
        }
        
        .btn-group-sm .btn {
            padding: 4px 7px;
            margin: 1px;
        }

        .table {
            font-size: 0.8rem;
        }

        .table thead th,
        .table tbody td {
            padding: 8px 10px;
        }
    }

    .container-fluid {
        padding: 12px !important;
    }

    * {
        animation: none !important;
        transition-duration: 0.15s !important;
    }
</style>
@endpush

@section('content')

    @include('components.breadcrumb', compact('breadcrumbs'))

    @if (session('message'))
        <div class="container-fluid">
            <div class="alert alert-{{ session('code') === '200' ? 'success' : 'danger' }}">
                <i class="fas fa-{{ session('code') === '200' ? 'check-circle' : 'exclamation-triangle' }} me-2"></i>
                {{ session('message') }}
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ $title }}
                    </div>

                    <div class="card-body">
                        <div class="search-container">
                            <form method="GET" action="{{ route('campaigns.list') }}" class="row align-items-center g-2">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Buscar campaña..."
                                               value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                @if(request('search'))
                                    <div class="col-md-4">
                                        <a href="{{ route('campaigns.list') }}" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-times me-1"></i>Limpiar
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>

                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:50px">#</th>
                                            <th>Campaña</th>
                                            <th style="width:140px">Fecha</th>
                                            <th style="width:350px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($campaigns->count() > 0)
                                            @foreach ($campaigns as $campaign)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $loop->iteration }}</span>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $campaign->title }}</strong>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ \Carbon\Carbon::parse($campaign->created_at)->format('d/m/Y H:i') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a class="btn btn-outline-success" 
                                                               title="Previsualización"
                                                               href="{{ url('view/' . $campaign->id) }}" 
                                                               target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            <a class="btn btn-outline-primary" 
                                                               title="Editar"
                                                               href="{{ url('campaigns/edit/' . $campaign->id) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                            <a class="btn btn-outline-info" 
                                                               title="Bloques"
                                                               href="{{ url('blocks/list/' . $campaign->id) }}">
                                                                <i class="fas fa-cube"></i>
                                                            </a>

                                                            <!-- Added delegate button for admin users -->
                                                            @role('admin')
                                                            <a class="btn btn-outline-warning" 
                                                               title="Delegar"
                                                               href="{{ url('campaigns/delegate/' . $campaign->id) }}">
                                                                <i class="fas fa-user-plus"></i>
                                                            </a>
                                                            @endrole
                                                            
                                                            <a href="{{ url('campaigns/delete/' . $campaign->id) }}"
                                                               class="btn btn-outline-danger" 
                                                               title="Eliminar"
                                                               onclick="return confirm('¿Está seguro que desea eliminar esta campaña?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                            
                                                            <a href="{{ url('campaigns/download/' . $campaign->id) }}"
                                                               class="btn btn-outline-success" 
                                                               title="Descargar"
                                                               onclick="return confirm('¿Desea descargar este correo?')">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            
                                                            <a class="btn btn-outline-secondary" 
                                                               title="Copiar"
                                                               href="{{ url('campaigns/copy/' . $campaign->id) }}"
                                                               onclick="return confirm('¿Desea copiar esta campaña?')">
                                                                <i class="fas fa-copy"></i>
                                                            </a>
                                                            
                                                            @if ($campaign->envio == 1)
                                                                <a class="btn btn-outline-success" 
                                                                   title="Enviar"
                                                                   href="{{ url('send/' . $campaign->id) }}"
                                                                   onclick="return confirm('¿Desea enviar este correo?')">
                                                                    <i class="fas fa-paper-plane"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="no-records">
                                                    <i class="fas fa-folder-open d-block"></i>
                                                    <strong>No se encontraron campañas</strong>
                                                    <p class="mb-0 mt-1 text-muted">
                                                        @if(request('search'))
                                                            No hay resultados para "{{ request('search') }}"
                                                        @else
                                                            No existen campañas registradas
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 px-3">
                            <div class="text-muted small">
                                Mostrando {{ $campaigns->firstItem() ?? 0 }} a {{ $campaigns->lastItem() ?? 0 }} de {{ $campaigns->total() }} campañas
                            </div>
                            <div class="pagination-controls">
                                @if($campaigns->onFirstPage())
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-chevron-left"></i> Anterior
                                    </button>
                                @else
                                    <a href="{{ $campaigns->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-chevron-left"></i> Anterior
                                    </a>
                                @endif
                                
                                <span class="mx-2 text-muted small">
                                    Página {{ $campaigns->currentPage() }} de {{ $campaigns->lastPage() }}
                                </span>
                                
                                @if($campaigns->hasMorePages())
                                    <a href="{{ $campaigns->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                                        Siguiente <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        Siguiente <i class="fas fa-chevron-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
