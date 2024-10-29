<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $connection = 'mysql';
    protected $fillable = ['type', 'description'];
    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }
}
