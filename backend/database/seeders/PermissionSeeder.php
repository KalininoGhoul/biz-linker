<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::findOrCreate(PermissionsEnum::REMOVE_ORGANIZATION->value);

        $organization = Role::findOrCreate(RolesEnum::ORGANIZATION->value);

        $admin = Role::findOrCreate(RolesEnum::ADMIN->value);
        $admin->givePermissionTo(PermissionsEnum::REMOVE_ORGANIZATION->value);
    }
}
