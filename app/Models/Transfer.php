<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Transfer extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $connection = 'mysql';

    protected $fillable = [
        'title', 'sended_amount', 'received_amount', 'sender_method_id', 'receiver_method_id', 'reference'
    ];

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function sender_method()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'sender_method_id');
    }

    public function receiver_method()
    {
        return $this->belongsTo('App\Models\PaymentMethod', 'receiver_method_id');
    }
}
