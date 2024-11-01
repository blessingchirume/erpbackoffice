<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ReceivedProduct extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $connection = 'mysql';

    protected $fillable = [
        'receipt_id', 'product_id', 'stock', 'stock_defective'
    ];

    public function receipt()
    {
        return $this->belongsTo('App\Models\Receipt');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
