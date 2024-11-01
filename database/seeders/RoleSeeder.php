<?php

namespace Database\Seeders;

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
        $systemAdmin = Role::create(['name' => ApplicationRoleConstants::SystemAdmin]);
        $superAdmin = Role::create(['name' => ApplicationRoleConstants::Teller]);
    }
}
