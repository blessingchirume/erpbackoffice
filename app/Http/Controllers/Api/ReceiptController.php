<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
   public function index(){
    
    $receipts = Receipt::all()->map(function ($receipt) {
        return [
            "id" => $receipt->id,
            "title" => $receipt->title,
            "provider_id" => $receipt->provider->name ?? '',
            "user_id" => $receipt->user->name,
            "total" => $receipt->products->sum('stock'),
            "products" => $receipt->products->map(function($product){
                return [                
                    "product_id" => $product->id,
                    "product_name" => $product->product->name,
                    "stock" => $product->stock,
                    "stock_defective" => $product->stock_defective,
                ];
            })
        ];
    });

    return response($receipts);
   }
}
