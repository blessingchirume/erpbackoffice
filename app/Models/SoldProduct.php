<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    protected $connection = 'mysql';
    protected $fillable = [
        'sale_id', 'product_id', 'price', 'qty', 'total_amount', 'item_cost'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function sale()
    {
        return $this->belongsTo('App\Models\Sale');
    }
}
