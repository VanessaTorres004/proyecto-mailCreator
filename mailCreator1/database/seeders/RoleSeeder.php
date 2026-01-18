<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        // Permisos para Marketing
        RolePermission::updateOrCreate(
            ['role_name' => 'marketing'],
            [
                'can_use_custom_header' => false,
                'can_use_custom_footer' => false,
                'can_use_custom_logo' => false,
                'can_change_theme_color' => false,
                'can_change_background_color' => false,
                'can_use_custom_text_sizes' => false,
                'allowed_text_sizes' => [14, 16, 18],
                'forced_theme_color' => '#C41E3A',
                'forced_background_color' => '#FFFFFF',
                'forced_logo' => 'blanco.png',
                'forced_header' => 'header0',
                'forced_footer' => 'footer0'
            ]
        );

        // Permisos para Facultades
        RolePermission::updateOrCreate(
            ['role_name' => 'facultades'],
            [
                'can_use_custom_header' => false,
                'can_use_custom_footer' => false,
                'can_use_custom_logo' => false,
                'can_change_theme_color' => false,
                'can_change_background_color' => false,
                'can_use_custom_text_sizes' => false,
                'allowed_text_sizes' => [14, 16, 18],
                'forced_theme_color' => '#C41E3A',
                'forced_background_color' => '#FFFFFF',
                'forced_logo' => 'blanco.png',
                'forced_header' => 'header0',
                'forced_footer' => 'footer0'
            ]
        );
    }
}