<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RolePermission;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    /**
     * Mostrar panel de gestión de roles (Solo Admin)
     */
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para acceder a esta sección');
        }

        // Obtener todos los roles con sus permisos
        $roles = Role::all();
        $rolePermissions = [];

        foreach ($roles as $role) {
            $permissions = RolePermission::where('role_name', $role->name)->first();
            
            if (!$permissions) {
                $permissions = RolePermission::createDefaultForRole($role->name);
            }
            
            $rolePermissions[$role->name] = $permissions;
        }

        return view('admin.roles.index', [
            'title' => 'Gestión de Roles y Permisos',
            'roles' => $roles,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Crear un nuevo rol
     */
    public function createRole(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción');
        }

        $request->validate([
            'role_name' => 'required|string|unique:roles,name|max:255',
            'role_display_name' => 'required|string|max:255'
        ]);

        try {
            // Crear el rol en Spatie
            $role = Role::create([
                'name' => strtolower($request->role_name),
                'guard_name' => 'web'
            ]);

            // Crear permisos por defecto para el nuevo rol
            RolePermission::createDefaultForRole($role->name);

            Session::flash('message', 'Rol creado exitosamente: ' . $request->role_display_name);
            Session::flash('code', '200');

        } catch (\Exception $e) {
            Session::flash('message', 'Error al crear el rol: ' . $e->getMessage());
            Session::flash('code', '400');
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Actualizar permisos de un rol
     */
    public function updatePermissions(Request $request, $roleName)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción');
        }

        $permissions = RolePermission::where('role_name', $roleName)->first();
        
        if (!$permissions) {
            $permissions = new RolePermission(['role_name' => $roleName]);
        }

        $permissions->can_use_custom_header = $request->has('can_use_custom_header');
        $permissions->can_use_custom_footer = $request->has('can_use_custom_footer');
        $permissions->can_use_custom_logo = $request->has('can_use_custom_logo');
        $permissions->can_change_theme_color = $request->has('can_change_theme_color');
        $permissions->can_change_background_color = $request->has('can_change_background_color');
        $permissions->can_use_custom_text_sizes = $request->has('can_use_custom_text_sizes');
        
        $permissions->allowed_text_sizes = $request->input('allowed_text_sizes', [14, 16, 18]);
        $permissions->forced_theme_color = $request->input('forced_theme_color', '#C41E3A');
        $permissions->forced_background_color = $request->input('forced_background_color', '#FFFFFF');
        $permissions->forced_logo = $request->input('forced_logo', 'blanco.png');
        $permissions->forced_header = $request->input('forced_header', 'header0');
        $permissions->forced_footer = $request->input('forced_footer', 'footer0');

        $permissions->save();

        Session::flash('message', 'Permisos actualizados correctamente para ' . ucfirst($roleName));
        Session::flash('code', '200');

        return redirect()->back();
    }

    /**
     * Eliminar un rol
     */
    public function deleteRole($roleId)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para realizar esta acción');
        }

        try {
            $role = Role::findOrFail($roleId);
            
            // No permitir eliminar el rol admin
            if (in_array($role->name, ['admin', 'marketing', 'facultades'])) {
                Session::flash('message', "No se puede eliminar el rol '{$role->name}' porque es un rol protegido");
                Session::flash('code', '400');
                return redirect()->back();
            }


            // Verificar si hay usuarios con este rol
            $usersCount = User::role($role->name)->count();
            if ($usersCount > 0) {
                Session::flash('message', "No se puede eliminar el rol '{$role->name}' porque tiene {$usersCount} usuario(s) asignado(s)");
                Session::flash('code', '400');
                return redirect()->back();
            }

            // Eliminar permisos asociados
            RolePermission::where('role_name', $role->name)->delete();

            // Eliminar el rol
            $role->delete();

            Session::flash('message', 'Rol eliminado exitosamente');
            Session::flash('code', '200');

        } catch (\Exception $e) {
            Session::flash('message', 'Error al eliminar el rol: ' . $e->getMessage());
            Session::flash('code', '400');
        }

        return redirect()->route('admin.roles.index');
    }

    /**
     * Obtener permisos del usuario actual (basado solo en su rol)
     */
    public static function getUserPermissions()
    {
        $user = auth()->user();
        
        // Admin tiene todos los permisos
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

        // Obtener el primer rol del usuario
        $role = $user->roles->first();
        
        if (!$role) {
            // Sin rol, permisos mínimos
            return (object)[
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
            ];
        }

        // Obtener permisos del rol
        $permissions = RolePermission::where('role_name', $role->name)->first();
        
        if (!$permissions) {
            $permissions = RolePermission::createDefaultForRole($role->name);
        }

        return $permissions;
    }
    public function edit($roleName)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para acceder a esta sección');
        }

        $role = Role::where('name', $roleName)->firstOrFail();
        $permissions = RolePermission::where('role_name', $roleName)->first();
        
        if (!$permissions) {
            $permissions = RolePermission::createDefaultForRole($roleName);
        }
        
        return view('admin.roles.edit', [
            'title' => 'Editar Rol - ' . ucfirst($roleName),
            'role' => $role,
            'permissions' => $permissions
        ]);
    }
}