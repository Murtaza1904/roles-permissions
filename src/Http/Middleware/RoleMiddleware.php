<?php

declare(strict_types=1);

namespace Murtaza1904\RolesPermissions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            abort(403, 'Unauthorized - Role required: ' . $role);
        }

        return $next($request);
    }
}
