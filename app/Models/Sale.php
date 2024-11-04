<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Sale extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $connection = 'mysql';

    protected $fillable = [
        'client_id',
        'user_id',
        'discount',
        'change',
        'tendered_amount',
        'currency_id'
    ];

    protected $casts = [
        'discount' => 'double',
        'tendered_amount' => 'double',
        'change' => 'double',
        'total_amount' => 'double'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
    public function products()
    {
        return $this->hasMany('App\Models\SoldProduct');
    }

    public function grand_total()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->total_amount + ($product->total_amount * $product->applied_vat);
        }
        return $total;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
