<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;

class Admins
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()->role_id === Role::ADMINISTRATOR, 403, 'Nemate prava pristupa');

        return $next($request);
    }
}
