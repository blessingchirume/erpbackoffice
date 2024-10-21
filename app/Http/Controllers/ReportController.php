<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function SalesReport() 
    {
        return response([

            'gross_sales' => 125,
            'refunds' => 10000,
            'credit_notes' => 100,
            'discounts' => 23,
            'net_sales' => 102,
            'cost_of_sales' => 78

        ]);
    }
}
