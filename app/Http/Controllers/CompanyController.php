<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationRoleConstants;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required',
            'business_type' => 'required',
            'company_db_name' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ]);

        $tenant = Company::create([
            'name' => $request->get('company_name'),
            'email' => $request->get('company_name'),
            'business_type' => $request->get('business_type'),
            'company_db_name' => str_replace(' ', '_', $request->get('company_name')),
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'company_id' => $tenant->id
        ]);

        $user->assignRole(ApplicationRoleConstants::SystemAdmin);

        $tenant->createDatabase($tenant->company_db_name);

        return response('Successfully registered tenant. DB name is ' . $tenant->company_db_name . ' store it securely');
    }

    public function index()
    {
        $companies = Company::paginate(25);

        return view('tenants.index', compact('companies'));
    }

    public function create()
    {
        return view('tenants.create');
    }
}
