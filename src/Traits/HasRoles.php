<?php

declare(strict_types=1);

namespace Murtaza1904\RolesPermissions\Traits;

use Murtaza1904\RolesPermissions\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->roles->map->permissions->flatten()->unique('id');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->contains('name', $permission);
    }

    /**
     * Assign a role to the user (ignores duplicates).
     */
    public function assignRole(Role $role): void
    {
        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole(Role $role): void
    {
        $this->roles()->detach($role->id);
    }

    /**
     * Sync roles for the user (replace all existing roles).
     *
     * @param array<int, int|string|Role> $roles
     */
    public function syncRoles(array $roles): void
    {
        $roleIds = collect($roles)->map(function ($role) {
            return $role instanceof Role ? $role->id : $role;
        })->all();

        $this->roles()->sync($roleIds);
    }

    /**
     * Check if user has ANY of the given roles.
     *
     * @param array<int, string> $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
    }

    /**
     * Check if user has ALL of the given roles.
     *
     * @param array<int, string> $roles
     */
    public function hasAllRoles(array $roles): bool
    {
        return collect($roles)->every(fn ($role) => $this->hasRole($role));
    }
}
