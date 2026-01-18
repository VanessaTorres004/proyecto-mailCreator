<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $table = 'campaigns';
    
    protected $fillable = [
        'id',
        'title',
        'link',
        'color',
        'background',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'instagram',
        'tiktok',
        'menus',
        'logo',
        'user_id',
        'header_template',
        'footer_template',
        'envio',
        'cuenta',
        'asunto',
        'destino',
        'created_at'
    ];
    
    // Usuario creador de la campaña
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Colaboradores asignados a la campaña
    public function collaborators()
    {
        return $this->hasMany(CampaignCollaborator::class, 'campaign_id');
    }
    
  
    
    // Bloques de contenido de la campaña
    public function blocks()
    {
        return $this->hasMany(Blocks::class, 'campaign_id');
    }
}