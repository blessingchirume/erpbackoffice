<?php

namespace Database\Seeders;

use App\Constants\ApplicationRoleConstants;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::create([
            'name' => 'Logarithmn',
            'email' => 'chirume37@gmail.com',
            'business_type' => 'Software Development Company',
            'company_db_name' => config()->get('database.connections.application.database')
        ]);
        $user = \App\Models\User::factory()->create([
            'name' => 'Blessing Chirume',
            'email' => 'chirume37@gmail.com',
            'password' => Hash::make('db$@dm1n'),
            'company_id' => $company->id
        ]);

        $user->assignRole(ApplicationRoleConstants::SuperAdmin);
    }
}
