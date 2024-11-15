<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationRoleConstants;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'password' => 'required|string|regex:/[0-9]/|not_regex:/[a-z]/|min:4|max:4',
            'phone_number' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',

        ]);

        $user = User::create([
            'phone_numer' => $request->get('phone_number'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $user->assignRole(ApplicationRoleConstants::SystemAdmin);

        $tenant = Company::create([
            'name' => $request->get('company_name'),
            'email' => $request->get('company_email'),
            'business_type' => $request->get('business_type'),
            'company_db_name' => str_replace(' ', '_', $request->get('company_name')),
        ]);

        $user->company_id = $tenant->id;

        $user->save();

        $tenant->createDatabase($tenant->company_db_name);

        return redirect('/login')->withStatus('Successfully registered tenant.\n
         Your login credentials have been sent to the email you provided');
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
