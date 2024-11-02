<?php

namespace Database\Seeders;

use App\Constants\ApplicationPermissionConstants;
use App\Constants\ApplicationRoleConstants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdmin = Role::create(['name' => ApplicationRoleConstants::SuperAdmin]);

        $systemAdminPermissions = [
            ApplicationPermissionConstants::viewUserManagementModule,
            ApplicationPermissionConstants::viewUsers,
            ApplicationPermissionConstants::viewUser,
            ApplicationPermissionConstants::createUser,
            ApplicationPermissionConstants::updateUser,
            ApplicationPermissionConstants::deleteUser,
            ApplicationPermissionConstants::viewUserRoles,
            ApplicationPermissionConstants::updateUserRole,
            ApplicationPermissionConstants::revokeUserRole,
            ApplicationPermissionConstants::attachRole,
            ApplicationPermissionConstants::createUser,

        ];
        $systemAdmin = Role::create(['name' => ApplicationRoleConstants::SystemAdmin]);
        $systemAdmin->syncPermissions($systemAdminPermissions);


        $teller = Role::create(['name' => ApplicationRoleConstants::Teller]);
    }
}
