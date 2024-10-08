<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'title', 'provider_id', 'user_id'
    ];

    public function provider()
    {
        return $this->belongsTo('App\Models\Provider');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function products()
    {
        return $this->hasMany('App\Models\ReceivedProduct');
    }
}
