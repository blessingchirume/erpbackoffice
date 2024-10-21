<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function SalesReport($start, $end) 
    {
        $cost_of_sales = 0;
        $sales = Sale::whereDate('created_at', '>=', '2024/09/31')->whereDate('created_at', '<=', '2024/10/16')->get();
        $sales->map(function($p) use ($cost_of_sales) {
            $cost_of_sales += $p->products->sum('qty');
        });
        // return response($sales);
        return response([

            'gross_sales' => $sales->sum('total_amount'),
            'refunds' => 0,
            'credit_notes' => 0,
            'discounts' => $sales->sum('discount'),
            'net_sales' => $sales->sum('total_amount') - $sales->sum('discount'),
            'cost_of_sales' => $cost_of_sales
        ]);
    }
}
