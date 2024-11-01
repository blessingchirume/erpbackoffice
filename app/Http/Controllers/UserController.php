<?php

namespace App\Http\Controllers;

use App\Constants\ApplicationPermissionConstants;
use App\Constants\ApplicationRoleConstants;
use App\Http\Requests\UserRequest;
use App\Models\Role;
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
        return view('users.create', compact('roles'));
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
            "created_at" => Carbon::now()
        ]);

        $user = User::find($id);

        $user->assignRole(Role::findById($request->get('user_role_id')));

        return redirect()->route('users.index')->withStatus('User successfully created.');
    }

    public function edit(User $user)
    {
        if (!Gate::allows(ApplicationPermissionConstants::updateUser)) {
            abort(401);
        }
        return view('users.edit', compact('user'));
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
