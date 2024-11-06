<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index(){
        $methods = PaymentMethod::all();
         return response($methods, 200);
    }
}
