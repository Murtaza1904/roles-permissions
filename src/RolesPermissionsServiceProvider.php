<?php

declare(strict_types=1);

namespace Murtaza1904\RolesPermissions;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class RolesPermissionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Blade @role directive
        Blade::directive('role', function ($roles) {
            return "<?php if(auth()->check() && auth()->user()->hasAnyRole((array) $roles)): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // Blade @permission directive
        Blade::directive('permission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPermission($permission)): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });
        
        // Publish migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'roles-permissions-migrations');

        // Register middleware aliases
        $this->app['router']->aliasMiddleware('role', \Murtaza1904\RolesPermissions\Http\Middleware\RoleMiddleware::class);
        $this->app['router']->aliasMiddleware('permission', \Murtaza1904\RolesPermissions\Http\Middleware\PermissionMiddleware::class);
    }

    public function register(): void
    {
        //
    }
}
