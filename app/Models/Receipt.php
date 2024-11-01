<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Receipt extends Model implements Auditable
{
    protected $connection = 'mysql';

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title', 'provider_id', 'user_id', 'currency_id', 'rate'
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
