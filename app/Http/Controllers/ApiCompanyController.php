<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationRoleConstants;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiCompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'business_type' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $user->assignRole(ApplicationRoleConstants::SystemAdmin);

        $tenant = Company::create([
            'name' => $request->get('company_name'),
            'email' => $request->get('email'),
            'business_type' => $request->get('business_type'),
            'company_db_name' => str_replace(' ', '_', $request->get('company_name')),
        ]);

        $user->company_id = $tenant->id;

        $user->save();

        $tenant->createDatabase($tenant->company_db_name);

        return response('Successfully registered tenant. Kindly login to start trading', 200);
    }

}
