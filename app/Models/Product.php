<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $connection = 'mysql';
    protected $fillable = [
        'serial_number',
        'name',
        'description',
        'product_category_id',
        'unit_cost',
        'price',
        'stock',
        'stock_defective'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category_id')->withTrashed();
    }

    public function solds()
    {
        return $this->hasMany('App\Models\SoldProduct');
    }

    public function receiveds()
    {
        return $this->hasMany('App\Models\ReceivedProduct');
    }

    public function priceList(){
        return $this->hasMany(PriceList::class, 'product_id', 'id');
    }
}
