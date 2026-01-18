@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-white">
                            <i class="fas fa-tasks me-2"></i>{{ $title }}
                        </h5>
                        <span class="badge bg-white text-primary px-3 py-2">
                            {{ $collaborations->count() }} Asignaciones
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('message'))
                        <div class="alert alert-{{ session('code') === '200' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                            <i class="fas fa-{{ session('code') === '200' ? 'check-circle' : 'exclamation-circle' }} me-2"></i>
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($collaborations->count() > 0)
                        <div class="row g-3">
                            @foreach($collaborations as $collab)
                                <div class="col-md-6 col-xl-4">
                                    <div class="card collaboration-card status-{{ $collab->status }} h-100 border-0 shadow-sm">
                                        <div class="card-body p-3">
                                            <!-- Header -->
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h6 class="card-title mb-0 fw-semibold text-truncate pe-2" style="flex: 1;">
                                                    {{ $collab->campaign->title }}
                                                </h6>
                                                <span class="badge bg-{{ $collab->getStatusBadgeColor() }} rounded-pill px-2 flex-shrink-0">
                                                    {{ $collab->getStatusLabel() }}
                                                </span>
                                            </div>

                                            <!-- Info -->
                                            <div class="mb-3">
                                                <div class="d-flex align-items-center mb-1 small text-muted">
                                                    <i class="fas fa-user-tie me-2" style="width: 14px;"></i>
                                                    <span>{{ $collab->assignedBy->name }}</span>
                                                </div>
                                                <div class="d-flex align-items-center small text-muted">
                                                    <i class="far fa-calendar me-2" style="width: 14px;"></i>
                                                    <span>{{ $collab->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                            </div>

                                            @if($collab->deadline)
                                                <div class="mb-3">
                                                    <span class="badge {{ $collab->isOverdue() ? 'bg-danger overdue' : 'bg-info' }} d-inline-flex align-items-center">
                                                        <i class="far fa-clock me-1"></i>
                                                        <span class="small">{{ $collab->deadline->format('d/m/Y H:i') }}</span>
                                                        @if($collab->isOverdue())
                                                            <i class="fas fa-exclamation-triangle ms-1"></i>
                                                        @endif
                                                    </span>
                                                </div>
                                            @endif

                                            <!-- Instructions -->
                                            @if($collab->instructions)
                                                <div class="mb-3">
                                                    <div class="small fw-semibold text-secondary mb-1">Instrucciones:</div>
                                                    <div class="p-2 bg-light rounded small text-muted" style="max-height: 80px; overflow-y: auto; line-height: 1.4;">
                                                        {{ $collab->instructions }}
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Admin Comments -->
                                            @if($collab->admin_comments)
                                                <div class="mb-3">
                                                    <div class="small fw-semibold text-warning mb-1">
                                                        <i class="fas fa-comment-dots me-1"></i>Comentarios:
                                                    </div>
                                                    <div class="p-2 bg-warning bg-opacity-10 border border-warning rounded small" style="line-height: 1.4;">
                                                        {{ $collab->admin_comments }}
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Actions -->
                                            <div class="d-flex gap-1 flex-wrap">
                                                @if($collab->status === 'pending' || $collab->status === 'needs_changes')
                                                    <form method="POST" action="{{ url('campaigns/collaboration/' . $collab->id . '/update-status') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="in_progress">
                                                        <button type="submit" class="btn btn-info btn-sm px-2 py-1" title="Iniciar">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($collab->status === 'in_progress')
                                                    <form method="POST" action="{{ url('campaigns/collaboration/' . $collab->id . '/update-status') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="returned_for_review">
                                                        <button type="submit" class="btn btn-warning btn-sm px-2 py-1" title="Enviar a Revisión">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ url('blocks/list/' . $collab->campaign_id) }}" class="btn btn-primary btn-sm px-2 py-1" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ url('view/' . $collab->campaign_id) }}" class="btn btn-outline-success btn-sm px-2 py-1" target="_blank" title="Vista Previa">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ url('campaigns/download/' . $collab->campaign_id) }}" class="btn btn-outline-secondary btn-sm px-2 py-1" title="Descargar">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-inbox fa-4x text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted fw-semibold">No tienes colaboraciones asignadas</h5>
                            <p class="text-muted small">Cuando un administrador te asigne una campaña, aparecerá aquí.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.collaboration-card {
    border-left: 3px solid;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.collaboration-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.12) !important;
}

.collaboration-card.status-pending { border-left-color: #6c757d; }
.collaboration-card.status-in_progress { border-left-color: #0dcaf0; }
.collaboration-card.status-returned_for_review { border-left-color: #ffc107; }
.collaboration-card.status-needs_changes { border-left-color: #dc3545; }
.collaboration-card.status-completed { border-left-color: #198754; }

.overdue {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.btn-sm {
    font-size: 0.8rem;
}

.badge {
    font-size: 0.7rem;
    font-weight: 500;
}

/* Scrollbar personalizado */
.bg-light::-webkit-scrollbar {
    width: 4px;
}

.bg-light::-webkit-scrollbar-track {
    background: transparent;
}

.bg-light::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 2px;
}
</style>
@endsection