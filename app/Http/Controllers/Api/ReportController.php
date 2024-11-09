<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;

class ReportController extends Controller
{
    public function SalesReport($start, $end)
    {
        $cost_of_sales = 0;

        $gross_sales = 0;

        $sales = Sale::whereDate('created_at', '>=', date('Y/m/d'))->whereDate('created_at', '<=', date('Y/m/d'))->get();
        $x = $sales->map(function ($p) use ($cost_of_sales) {

        });
        // return response($sales);
        return response([

            'gross_sales' => $sales->sum('total_amount'),
            'refunds' => 0,
            'credit_notes' => 0,
            'discounts' => $sales->sum('discount'),
            'net_sales' => $sales->sum('total_amount') - $sales->sum('discount') - $cost_of_sales,
            'cost_of_sales' => $sales[0]->costOfSales()
        ]);
    }
}
