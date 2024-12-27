<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationRoleConstants;
use App\Helpers\DynamicDatabaseConnection;
use App\Models\Company;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'business_type' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|string|regex:/[0-9]/|not_regex:/[a-z]/|min:4|max:4',
            'phone_number' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10',

        ]);

        if ($validator->fails()) {
            return back()->withError($validator->errors() . "\n", 422);
        }

        try {
            $user = User::create([
                'phone_number' => $request->get('phone_number'),
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

            $tenant->createDatabase($tenant->company_db_name);

            $user->company_id = $tenant->id;

            $connection = new DynamicDatabaseConnection();

            $user->shop_id = Shop::on($connection->getDynamicConnection($tenant->company_db_name))->orderBy('id', 'asc')->first()->id;

            $user->save();

            return redirect('/login')->withStatus('Successfully registered tenant. Kindly login to start trading');

        } catch (QueryException $e) {
            return back()->withError('A database error occurred. ' . $e->getMessage());
        }

    }

    public function create()
    {
        return view('tenants.create');
    }

    public function index()
    {
        $companies = Company::paginate(25);

        return view('tenants.index', compact('companies'));
    }
}
