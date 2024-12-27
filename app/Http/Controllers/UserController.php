<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationPermissionConstants;
use App\Constants\ApplicationRoleConstants;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Gate::allows(ApplicationPermissionConstants::viewUsers)) {
            abort(401);
        }
        $users = Auth::user()->company->users;
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Gate::allows(ApplicationPermissionConstants::createUser)) {
            abort(401);
        }
        $roles = Role::whereNot('name', ApplicationRoleConstants::SuperAdmin)->get();

        if (!Auth::user()->company->company_db_name) {
            return response()->json(['error' => 'Tenant database not found for this user'], 404);
        }
    
        // Set up the dynamic connection
        config(['database.connections.dynamic' => array_merge(
            config('database.connections.mysql'), // Base tenant connection
            ['database' => Auth::user()->company->company_db_name]        // Set tenant database
        )]);
    
        // Purge any previous connection cache
        DB::purge('dynamic');
    
        // Query shops using the dynamic connection
        $shops = Shop::on('dynamic')->get();

        return view('users.create', compact('roles', 'shops'));
    }

    public function store(UserRequest $request)
    {
        if (!Gate::allows(ApplicationPermissionConstants::createUser)) {
            abort(401);
        }
        $request->merge(['password' => Hash::make($request->get('password'))]);
        $request->merge(['company_id' => Auth::user()->company->id]);

        $id = DB::connection('application')->table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'company_id' => $request->company_id,
            'shop_id' => $request->shop_id,
            "created_at" => Carbon::now()
        ]);

        $user = User::find($id);

        $user->assignRole(Role::findById($request->get('user_role_id'))->name);

        return redirect()->route('users.index')->withStatus('User successfully created.');
    }

    public function edit(User $user)
    {
        if (!Gate::allows(ApplicationPermissionConstants::updateUser)) {
            abort(401);
        }
        $roles = Role::whereNot('name', ApplicationRoleConstants::SuperAdmin)->get();

        // Set up the dynamic connection
        config(['database.connections.dynamic' => array_merge(
            config('database.connections.mysql'), // Base tenant connection
            ['database' => Auth::user()->company->company_db_name]        // Set tenant database
        )]);
    
        // Purge any previous connection cache
        DB::purge('dynamic');
    
        // Query shops using the dynamic connection
        $shops = Shop::on('dynamic')->get();

        return view('users.edit', compact('user', 'roles', 'shops'));
    }

    public function update(UserRequest $request, User $user)
    {
        if (!Gate::allows(ApplicationPermissionConstants::updateUser)) {
            abort(401);
        }
        $hasPassword = $request->get('password');

        $request->merge(['password' => Hash::make($request->get('password'))]);

        $request->except([$hasPassword ? '' : 'password']);

        $user->update($request->all());

        return redirect()->route('users.index')->withStatus('User successfully updated.');
    }

    public function destroy(User $user)
    {
        if (!Gate::allows(ApplicationPermissionConstants::deleteUser)) {
            abort(401);
        }
        
        $user->delete();

        return redirect()->route('users.index')->withStatus('User successfully deleted.');
    }
}
