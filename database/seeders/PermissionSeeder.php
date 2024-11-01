<?php

namespace Database\Seeders;

use App\Constants\ApplicationPermissionConstants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Users
        Permission::create(['name' => ApplicationPermissionConstants::viewUserManagementModule]);
        Permission::create(['name' => ApplicationPermissionConstants::viewUsers]);
        Permission::create(['name' => ApplicationPermissionConstants::viewUser]);
        Permission::create(['name' => ApplicationPermissionConstants::deleteUser]);
        Permission::create(['name' => ApplicationPermissionConstants::updateUser]);
        Permission::create(['name' => ApplicationPermissionConstants::createUser]);

        // Roles
        Permission::create(['name' => ApplicationPermissionConstants::viewUserRoles]);
        Permission::create(['name' => ApplicationPermissionConstants::updateUserRole]);
        Permission::create(['name' => ApplicationPermissionConstants::revokeUserRole]);
        Permission::create(['name' => ApplicationPermissionConstants::attachRole]);
    }
}
