<?php

namespace Database\Seeders;

## https://spatie.be/docs/laravel-permission/v3/advanced-usage/seeding

use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        \collect(
            Arr::flatten(
                config('permission-list')
            ),
            ...[
                //
            ],
        )->each(fn ($permissionName) => Permission::firstOrCreate(['name' => $permissionName]));

        // create roles and assign created permissions

        // this can be done as separate statements
        \collect([
            'writer' => [
                'edit articles',
            ],
            'moderator' => [
                'publish articles',
                'unpublish articles',
            ],
        ])->each(function ($rolePermissions, $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        });

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());
    }
}
