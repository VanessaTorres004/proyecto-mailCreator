<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role_name',
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
        'forced_footer'
    ];

    protected $casts = [
        'can_use_custom_header' => 'boolean',
        'can_use_custom_footer' => 'boolean',
        'can_use_custom_logo' => 'boolean',
        'can_change_theme_color' => 'boolean',
        'can_change_background_color' => 'boolean',
        'can_use_custom_text_sizes' => 'boolean',
        'allowed_text_sizes' => 'array'
    ];

    /**
     * Obtener permisos por rol
     */
    public static function getPermissionsForRole($roleName)
    {
        return self::where('role_name', $roleName)->first();
    }

    /**
     * Crear permisos por defecto para un rol
     */
    public static function createDefaultForRole($roleName)
    {
        return self::create([
            'role_name' => $roleName,
            'can_use_custom_header' => false,
            'can_use_custom_footer' => false,
            'can_use_custom_logo' => false,
            'can_change_theme_color' => false,
            'can_change_background_color' => false,
            'can_use_custom_text_sizes' => false,
            'allowed_text_sizes' => [14, 16, 18], // Solo tamaños básicos
            'forced_theme_color' => '#C41E3A',
            'forced_background_color' => '#FFFFFF',
            'forced_logo' => 'blanco.png',
            'forced_header' => 'header0',
            'forced_footer' => 'footer0'
        ]);
    }
}