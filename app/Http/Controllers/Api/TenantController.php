<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    //
    public function Get($code) {
        $tenant = Tenant::with('domains')->where('id', $code)->first();
        return response([
            'tenant_id' => $tenant->id,
            'domain' => $tenant->domains->first()->domain
        ]); 
    }

    public function RegisterTenant($code) {

        $tenant = Tenant::where()->first();
        return $tenant; 
    }

    public function DeleteAccount($code) {

        $tenant = Tenant::where()->first();
        return $tenant; 
    }
}
