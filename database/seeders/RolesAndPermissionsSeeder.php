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

        $globalPermissions = array_values((array) config('permission-list.global_permissions'));

        // this can be done as separate statements
        \collect([
            'writer' => [
                'edit articles',
                'painel:access',
            ],
            'moderator' => [
                'publish articles',
                'unpublish articles',
                'painel:access',
            ],
        ])->each(function ($rolePermissions, $roleName) use ($globalPermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions([
                ...$rolePermissions,
                ...$globalPermissions,
            ]);
        });

        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        // $superAdminRole->givePermissionTo(Permission::all());
        $superAdminRole->syncPermissions(Permission::all());
    }
}
