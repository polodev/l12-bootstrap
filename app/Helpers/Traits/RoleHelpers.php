<?php

namespace App\Helpers\Traits;

trait RoleHelpers
{
    /**
     * Check if current authenticated user has a specific role
     */
    public static function hasRole(string $role): bool
    {
        return auth()->check() && auth()->user()->hasRole($role);
    }

    /**
     * Check if current authenticated user has any of the specified roles
     */
    public static function hasAnyRole(array|string $roles): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole($roles);
    }

    /**
     * Check if current authenticated user has all specified roles
     */
    public static function hasAllRoles(array $roles): bool
    {
        return auth()->check() && auth()->user()->hasAllRoles($roles);
    }

    /**
     * Check if current authenticated user is admin
     */
    public static function isAdmin(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get all available roles
     */
    public static function getAllRoles(): array
    {
        return [
            'admin' => 'Administrator',
            'editor' => 'Content Editor',
            'teacher' => 'Teacher',
            'student' => 'Student',
            'user' => 'Regular User',
        ];
    }

    /**
     * Get display name for a role
     */
    public static function getRoleDisplayName(string $role): string
    {
        $roles = self::getAllRoles();
        return $roles[$role] ?? ucfirst($role);
    }
}