@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-white">
                            <i class="fas fa-bell me-2"></i>Notificaciones
                            @if($notifications->where('read', false)->count() > 0)
                                <span class="badge bg-white text-primary rounded-pill ms-2">
                                    {{ $notifications->where('read', false)->count() }}
                                </span>
                            @endif
                        </h5>
                        @if($notifications->where('read', false)->count() > 0)
                            <a href="{{ route('notifications.mark-all-read') }}" class="btn btn-sm btn-outline-light text-white">
                                <i class="fas fa-check-double me-1"></i>
                                Marcar todas leídas
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        <div class="notification-item {{ $notification->read ? 'read' : 'unread' }} p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="notification-icon flex-shrink-0">
                                    @if($notification->type === 'assignment')
                                        <i class="fas fa-user-plus text-primary"></i>
                                    @elseif($notification->type === 'status_change')
                                        <i class="fas fa-sync-alt text-info"></i>
                                    @elseif($notification->type === 'deadline')
                                        <i class="fas fa-clock text-warning"></i>
                                    @else
                                        <i class="fas fa-bell text-secondary"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex align-items-start justify-content-between gap-2">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 {{ !$notification->read ? 'fw-semibold' : 'fw-normal' }} text-dark small">
                                                {{ $notification->title }}
                                            </h6>
                                            <p class="mb-2 text-muted small lh-sm">{{ $notification->message }}</p>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <small class="text-muted" style="font-size: 0.8rem;">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </small>
                                                @if($notification->campaign)
                                                    <span class="badge bg-light text-secondary border" style="font-size: 0.7rem;">
                                                        {{ $notification->campaign->title }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('notifications.mark-read', $notification->id) }}" 
                                           class="btn btn-sm {{ $notification->read ? 'btn-light border' : 'btn-primary' }} flex-shrink-0"
                                           title="{{ $notification->read ? 'Leída' : 'Marcar como leída' }}">
                                            <i class="fas fa-{{ $notification->read ? 'check' : 'eye' }}"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-bell-slash fa-4x text-muted mb-3 opacity-50"></i>
                                <h6 class="text-muted fw-semibold">No tienes notificaciones</h6>
                                <p class="text-muted small mb-0">Aquí aparecerán tus avisos importantes</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($notifications->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.notification-item {
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s ease;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item.unread {
    background-color: #f8f9ff;
    border-left: 3px solid #667eea;
}

.notification-item.read {
    background-color: #fff;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border-radius: 8px;
    font-size: 0.85rem;
}

.notification-item.unread .notification-icon {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card {
    border-radius: 0.5rem;
    overflow: hidden;
}

.btn-sm {
    padding: 0.3rem 0.7rem;
    font-size: 0.8rem;
}

.badge {
    font-weight: 500;
    padding: 0.25em 0.6em;
}

.empty-state {
    padding: 2rem 0;
}

@media (max-width: 768px) {
    .notification-item {
        padding: 0.75rem;
    }
    
    .notification-icon {
        width: 28px;
        height: 28px;
        font-size: 0.8rem;
    }
    
    .notification-item h6 {
        font-size: 0.9rem;
    }
}
</style>
@endsection