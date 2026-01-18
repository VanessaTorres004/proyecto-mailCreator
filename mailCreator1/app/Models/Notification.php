<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'campaign_id',
        'collaboration_id',
        'read',
        'action_url'
    ];

    protected $casts = [
        'read' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaigns::class);
    }

    public static function createNotification($userId, $type, $title, $message, $campaignId = null, $collaborationId = null, $actionUrl = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'campaign_id' => $campaignId,
            'collaboration_id' => $collaborationId,
            'action_url' => $actionUrl
        ]);
    }
}