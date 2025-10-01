<?php

declare(strict_types=1);

namespace Murtaza1904\RolesPermissions\Tests;

use Orchestra\Testbench\TestCase;
use Murtaza1904\RolesPermissions\Models\Role;

final class RolesTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [\Murtaza1904\RolesPermissions\RolesPermissionsServiceProvider::class];
    }

    public function test_role_creation(): void
    {
        $role = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $this->assertDatabaseHas('roles', ['slug' => 'admin']);
    }
}
