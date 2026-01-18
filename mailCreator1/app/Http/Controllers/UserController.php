<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
         // Facultades no puede acceder a gestión de usuarios
         $this->middleware('role:admin|marketing')->except(['dashboard']);
    }

    public function dashboard()
    {
        return view('home');
    }

    public function listUsers(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->paginate(5);

        return view('users.list', [
            'users' => $users,
            'title' => 'Listado de usuarios',
            'request'=>$request
        ]);
    }

    public function createUser(Request $request)
    {
        $user = new User();
        
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'roles' => 'required|array|min:1'
            ], [
                'roles.required' => 'Debe seleccionar al menos un rol.',
                'roles.min' => 'Debe seleccionar al menos un rol.'
            ]);
            
            try {
                $user = User::create($request->all());
                $user->syncRoles($request->roles);

                return redirect()->route('users.list')->with([
                    'message' => 'El usuario se ha ingresado exitosamente',
                    'code' => '200'
                ]);
            } catch (\Exception $e) {
                return back()->with([
                    'message' => 'Se ha presentado un error, por favor comuníquese con el administrador',
                    'code' => '400'
                ])->withInput();
            }
        }

        $roles = Role::all();

       return view('users.form', [
        'title' => 'Crear Usuario',
        'action' => route('users.store'),
        'message' => 'Crea un nuevo usuario para la aplicación',
        'class' => 'users',
        'roles' => $roles
    ]);
    }

    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$id}",
                'password' => 'nullable|min:6'
            ]);

            try {
                $userData = $request->except(['_token', '_method']);

                if (empty($userData['password'])) {
                    unset($userData['password']);
                }

                $user->update($userData);
                $user->syncRoles($request->roles);
                
                return redirect()->route('users.list')->with([
                    'message' => 'El usuario se ha editado exitosamente',
                    'code' => '200'
                ]);

            } catch (\Exception $e) {
                return back()->with([
                    'message' => 'Se ha presentado un error, por favor comuníquese con el administrador',
                    'code' => '400'
                ])->withInput();
            }
        }

        $roles = Role::all();

        return view('users.form', [
            'title' => "Editar Usuario: {$user->first_name} {$user->last_name}",
            'action' => route('users.update', $user->id),
            'user' => $user,
            'message' => 'Edita un usuario de la aplicación',
            'roles' => $roles
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            session()->flash('message', "El usuario no existe");
            session()->flash('code', "404");
            return redirect()->route('users.list');
        }

        if ($user->delete()) {
            session()->flash('message', "El usuario ha sido eliminado correctamente");
            session()->flash('code', '200');
        } else {
            session()->flash('message', "Hubo un problema al eliminar al usuario");
            session()->flash('code', '500');
        }

        return redirect()->route('users.list');
    }
}