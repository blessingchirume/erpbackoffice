<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'business_type' => 'required',
            'company_db_name' => 'required'
        ]);

        $tenant = Company::create($request->all());

        //  create db from tenant db 

        $tenant->createDatabase($tenant->company_db_name);

        //  run migrations and seeds from created db 

        return redirect()->route('tenant.register.success')->withStatus('Successfully registered tenant. DB name is '. $tenant->company_db_name .' store it securely');
    }
}
