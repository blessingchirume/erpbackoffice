<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionType extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $connection = 'mysql';

    protected $fillable = ['type', 'description'];
    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }
}
