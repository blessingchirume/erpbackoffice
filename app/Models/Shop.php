<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $connection = 'mysql'; // Default tenant connection

    protected $fillable = ['name', 'address'];


    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function receipts(){
        return $this->hasMany(Receipt::class);
    }
     
    public function users(){
        return $this->hasMany(User::class);
    }
    
}
