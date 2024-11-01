<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Provider extends Model implements Auditable
{

    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $connection = 'mysql';
    protected $fillable = [
        'name', 'description', 'email', 'phone', 'paymentinfo', 'address'
    ];

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function receipts()
    {
        return $this->hasMany('App\Models\Receipt');
    }
}
