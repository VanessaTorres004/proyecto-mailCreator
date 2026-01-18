<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignCollaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'assigned_by',
        'instructions',
        'deadline',
        'status',
        'admin_comments'
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Get the campaign that was delegated
     */
    public function campaign()
    {
        return $this->belongsTo(Campaigns::class, 'campaign_id');
    }

    /**
     * Get the user who was assigned the campaign
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who assigned the campaign
     */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Check if the deadline has passed
     */
    public function isOverdue()
    {
        return $this->deadline && $this->deadline->isPast() && $this->status !== 'completed';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        switch ($this->status) {
        case 'pending':
            return 'secondary';
        case 'in_progress':
            return 'info';
        case 'returned_for_review':
            return 'warning';
        case 'needs_changes':
            return 'danger';
        case 'completed':
            return 'success';
        default:
            return 'secondary';
    }
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
        case 'pending':
            return 'Pendiente';
        case 'in_progress':
            return 'En Progreso';
        case 'returned_for_review':
            return 'En Revisión';
        case 'needs_changes':
            return 'Requiere Cambios';
        case 'completed':
            return 'Completado';
        default:
            return 'Desconocido';
    }
    }
}
