<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BreadcrumbsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $breadcrumbs = [
            ['title' => 'Inicio', 'url' => route('home')]
        ];

        $currentRoute = Route::currentRouteName();

        if ($currentRoute) {
            $routes = [
                'users.list' => ['title' => 'Listado de usuarios', 'url' => route('users.list')],
                'users.add' => ['title' => 'Agregar usuario', 'url' => route('users.add')],
                'users.edit' => ['title' => 'Editar usuario'],
                'campaigns.add' => ['title' => 'Agregar campaña', 'url' => route('campaigns.add')],
                'campaigns.list' => ['title' => 'Listar campañas', 'url' => route('campaigns.list')],
            ];

            if (isset($routes[$currentRoute])) {
                //dd($routes[$currentRoute]);
                $breadcrumbs[]= $routes[$currentRoute]; // ✅ Agrega correctamente el array sin romper la estructura
            }
        }
        //dd($breadcrumbs);
        view()->share('breadcrumbs', $breadcrumbs);

        return $next($request);
    }
}
