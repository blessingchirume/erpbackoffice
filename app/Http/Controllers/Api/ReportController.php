<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function SalesReport($start, $end)
    {

        $sales = Sale::whereDate('created_at', '>=', date('Y/m/d'))->whereDate('created_at', '<=', date('Y/m/d'))->get();

        return response([

            'gross_sales' => $sales->sum('total_amount'),
            'refunds' => 0,
            'credit_notes' => 0,
            'discounts' => $sales->sum('discount'),
            'net_sales' => $sales->sum('total_amount') - $sales->sum('discount'),
            'cost_of_sales' => $sales->sum(function ($item) {
                return $item->costOfSales();
            })
        ]);
    }
}
