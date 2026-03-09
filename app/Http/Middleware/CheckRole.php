<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Récupération de la valeur string de l'enum (admin, assistante, etc.)
        $userRole = $request->user()->role instanceof \App\Enums\UserRole 
            ? $request->user()->role->value 
            : $request->user()->role;
        
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Accès interdit : Cette section est réservée au rôle [ ' . implode(', ', $roles) . ' ]. Votre rôle actuel est [ ' . $userRole . ' ].');
    }
}
