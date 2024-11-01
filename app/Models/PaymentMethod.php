<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentMethod extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $connection = 'mysql';
    protected $fillable = ['name', 'description'];
    public function transactions() {
        return $this->hasMany(Transaction::class, 'payment_method_id', 'id');
    }
}
