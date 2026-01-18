@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10">
            <!-- Header Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold text-white">
                            <i class="fas fa-users-cog me-2"></i>{{ $title }}
                        </h5>
                        <a href="{{ url('campaigns/list') }}" class="btn btn-outline-light btn-sm text-white">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
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

                    <!-- Assignment Form -->
                    <div class="bg-light rounded-3 p-4 mb-4">
                        <h6 class="text-primary fw-semibold mb-3">
                            <i class="fas fa-user-plus me-2"></i>Asignar Nuevo Colaborador
                        </h6>
                        <form method="POST" action="{{ url('campaigns/' . $campaign->id . '/assign-collaborator') }}">
                            @csrf
                            
                            <div class="row g-3">
                               <div class="col-md-6">
                        <label for="marketing_user_id" class="form-label small fw-semibold">
                            Usuario Marketing
                        </label>
                        <select name="marketing_user_id" id="marketing_user_id" class="form-select form-select-sm">
                            <option value="">Seleccionar usuario...</option>
                            @foreach($marketingUsers as $marketingUser)
                                <option value="{{ $marketingUser->id }}" {{ old('marketing_user_id') == $marketingUser->id ? 'selected' : '' }}>
                                    {{ $marketingUser->name }} ({{ $marketingUser->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('marketing_user_id')
                            <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="facultades_user_id" class="form-label small fw-semibold">
                            Usuario Facultades
                        </label>
                        <select name="facultades_user_id" id="facultades_user_id" class="form-select form-select-sm">
                            <option value="">Seleccionar usuario...</option>
                            @foreach($facultadesUsers as $facultadesUser)
                                <option value="{{ $facultadesUser->id }}" {{ old('facultades_user_id') == $facultadesUser->id ? 'selected' : '' }}>
                                    {{ $facultadesUser->name }} ({{ $facultadesUser->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('facultades_user_id')
                            <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                        @enderror
                    </div>

                                </div>

                                <div class="col-md-6">
                                    <label for="deadline" class="form-label small fw-semibold">
                                        <i class="far fa-calendar-alt me-1"></i>Plazo de Entrega
                                    </label>
                                    <input type="datetime-local" name="deadline" id="deadline" class="form-control form-control-sm">
                                    @error('deadline')
                                        <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="instructions" class="form-label small fw-semibold">
                                        Instrucciones Detalladas
                                    </label>
                                    <textarea name="instructions" id="instructions" class="form-control form-control-sm" rows="4" 
                                        placeholder="Describe las tareas y expectativas para esta asignación..."></textarea>
                                    @error('instructions')
                                        <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm px-4" style="margin-top: 10px";>
                                        <i class="fas fa-paper-plane me-2"></i>Asignar Colaborador
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Existing Collaborators -->
                    @if($existingCollaborators->count() > 0)
                        <div class="mt-4">
                            <h6 class="text-secondary fw-semibold mb-3" style="padding-left: 10px;">
                                <i class="fas fa-list me-2"></i>Colaboradores Asignados 
                                <span class="badge bg-secondary rounded-pill ms-2">{{ $existingCollaborators->count() }}</span>
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle">
                                    <thead class="table-light">
                                        <tr class="small">
                                            <th class="fw-semibold">Usuario</th>
                                            <th class="fw-semibold">Asignado Por</th>
                                            <th class="fw-semibold text-center">Estado</th>
                                            <th class="fw-semibold">Plazo</th>
                                            <th class="fw-semibold">Asignación</th>
                                            <th class="fw-semibold text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        @foreach($existingCollaborators as $collab)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold">{{ $collab->user->name }}</div>
                                                        <div class="text-muted" style="font-size: 0.85rem;">{{ $collab->user->email }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $collab->assignedBy->name }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $collab->getStatusBadgeColor() }} rounded-pill px-3">
                                                        {{ $collab->getStatusLabel() }}
                                                    </span>
                                                    @if($collab->isOverdue())
                                                        <div class="mt-1">
                                                            <small class="text-danger fw-semibold">
                                                                <i class="fas fa-exclamation-triangle"></i> Vencido
                                                            </small>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($collab->deadline)
                                                        <i class="far fa-calendar text-muted me-1"></i>
                                                        <span class="text-muted">{{ $collab->deadline->format('d/m/Y H:i') }}</span>
                                                    @else
                                                        <span class="text-muted fst-italic">Sin plazo</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $collab->created_at->format('d/m/Y') }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        @if($collab->status === 'returned_for_review')
                                                            <button type="button" class="btn btn-outline-success" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#completeModal{{ $collab->id }}"
                                                                title="Completar">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-warning" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#changesModal{{ $collab->id }}"
                                                                title="Solicitar Cambios">
                                                                <i class="fas fa-undo"></i>
                                                            </button>
                                                        @endif
                                                        
                                                        <a href="{{ url('campaigns/' . $campaign->id . '/remove-collaborator/' . $collab->id) }}" 
                                                           class="btn btn-outline-danger"
                                                           onclick="return confirm('¿Remover este colaborador?')"
                                                           title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>

                                                    <!-- Complete Modal -->
                                                    <div class="modal fade" id="completeModal{{ $collab->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow">
                                                                <form method="POST" action="{{ url('campaigns/collaboration/' . $collab->id . '/update-status') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="completed">
                                                                    <div class="modal-header bg-success bg-opacity-10 border-0">
                                                                        <h6 class="modal-title fw-semibold text-success">
                                                                            <i class="fas fa-check-circle me-2"></i>Marcar como Completado
                                                                        </h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="small text-muted mb-3">¿Confirmar la finalización de esta colaboración?</p>
                                                                        <div class="mb-3">
                                                                            <label class="form-label small fw-semibold">Comentarios</label>
                                                                            <textarea name="admin_comments" class="form-control form-control-sm" rows="3" 
                                                                                placeholder="Comentarios finales (opcional)"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0">
                                                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-sm btn-success">
                                                                            <i class="fas fa-check me-1"></i>Completar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Changes Modal -->
                                                    <div class="modal fade" id="changesModal{{ $collab->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 shadow">
                                                                <form method="POST" action="{{ url('campaigns/collaboration/' . $collab->id . '/update-status') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="needs_changes">
                                                                    <div class="modal-header bg-warning bg-opacity-10 border-0">
                                                                        <h6 class="modal-title fw-semibold text-warning">
                                                                            <i class="fas fa-undo me-2"></i>Solicitar Cambios
                                                                        </h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label small fw-semibold">
                                                                                Cambios Requeridos <span class="text-danger">*</span>
                                                                            </label>
                                                                            <textarea name="admin_comments" class="form-control form-control-sm" rows="4" required 
                                                                                placeholder="Detalla los cambios necesarios..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer border-0">
                                                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-sm btn-warning">
                                                                            <i class="fas fa-paper-plane me-1"></i>Enviar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
    transition: background-color 0.2s ease;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}

.modal-content {
    border-radius: 0.5rem;
}

.form-select-sm, .form-control-sm {
    border-radius: 0.375rem;
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
}
</style>
@endsection