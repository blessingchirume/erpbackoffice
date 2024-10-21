<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    const ALPHA_NUMERIC = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuUuVvWwXxYyZz1234567890';

    public function register()
    {

        return view('auth.tenants.register');
    }

    public function success()
    {

        return view('auth.tenants.success');
    }

    //     public static function quickRandom($length = 16)
    // {
    //     $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    //     return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    // }

    public function store(Request $request)
    {
        $tenant1 = Tenant::create(['id' => Str::random(8)]);

        $tenant1->domains()->create(['domain' => $request->get('app_name').'.retailmate.co.zw']);

        return redirect()->route('tenant.register.success')->withStatus('Successfully registered tenant. Your tenant id is '. $tenant1->id .' store it securely');
    }
}
