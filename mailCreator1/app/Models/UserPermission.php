<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'can_use_custom_header',
        'can_use_custom_footer',
        'can_use_custom_logo',
        'can_change_theme_color',
        'can_change_background_color',
        'can_use_custom_text_sizes',
        'allowed_text_sizes',
        'forced_theme_color',
        'forced_background_color',
        'forced_logo',
        'forced_header',
        'forced_footer',
        'use_custom_permissions'
    ];

    protected $casts = [
        'can_use_custom_header' => 'boolean',
        'can_use_custom_footer' => 'boolean',
        'can_use_custom_logo' => 'boolean',
        'can_change_theme_color' => 'boolean',
        'can_change_background_color' => 'boolean',
        'can_use_custom_text_sizes' => 'boolean',
        'allowed_text_sizes' => 'array',
        'use_custom_permissions' => 'boolean'
    ];

    /**
     * Relación con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener permisos efectivos del usuario (personalizados o heredados del rol)
     */
    public static function getEffectivePermissions($userId)
    {
        $user = User::find($userId);
        if (!$user) return null;

        // Si es admin, todos los permisos
        if ($user->hasRole('admin')) {
            return (object)[
                'can_use_custom_header' => true,
                'can_use_custom_footer' => true,
                'can_use_custom_logo' => true,
                'can_change_theme_color' => true,
                'can_change_background_color' => true,
                'can_use_custom_text_sizes' => true,
                'allowed_text_sizes' => [12, 14, 16, 18, 20, 24, 28, 32],
                'forced_theme_color' => null,
                'forced_background_color' => null,
                'forced_logo' => null,
                'forced_header' => null,
                'forced_footer' => null
            ];
        }

        // Buscar permisos personalizados del usuario
        $userPerms = self::where('user_id', $userId)->first();

        // Si tiene permisos personalizados y están activados
        if ($userPerms && $userPerms->use_custom_permissions) {
            return $userPerms;
        }

        // Si no tiene permisos personalizados, heredar del rol
        $roleName = null;
        if ($user->hasRole('marketing')) {
            $roleName = 'marketing';
        } elseif ($user->hasRole('facultades')) {
            $roleName = 'facultades';
        }

        if ($roleName) {
            $rolePerms = RolePermission::getPermissionsForRole($roleName);
            if ($rolePerms) {
                return $rolePerms;
            }
        }

        // Por defecto, sin permisos
        return RolePermission::createDefaultForRole('default');
    }
}