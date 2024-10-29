<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $connection = 'mysql';
    
    protected $fillable = [
        'client_id',
        'user_id',
        'discount',
        'change',
        'tendered_amount'
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
