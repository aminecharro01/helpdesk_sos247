<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware générique pour vérifier qu'un utilisateur possède
 * l'un des rôles requis pour accéder à la route.
 * Usage dans les routes :
 *     Route::get('/admin', AdminController::class)
 *          ->middleware(['role:admin']);
 *     Route::middleware(['role:admin,agent'])->group(function() { ... });
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Autoriser si le rôle de l'utilisateur figure dans la liste d'arguments
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Sinon, renvoyer une erreur 403 « Accès interdit »
        abort(Response::HTTP_FORBIDDEN, 'Accès non autorisé.');
    }
}
