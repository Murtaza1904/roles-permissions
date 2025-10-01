<?php

declare(strict_types=1);

namespace Murtaza1904\RolesPermissions\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (! $request->user() || ! $request->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized - Permission required: ' . $permission);
        }

        return $next($request);
    }
}
