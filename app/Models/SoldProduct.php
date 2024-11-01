<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SoldProduct extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

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
