<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ProductCategory extends Model implements Auditable
{
    protected $connection = 'mysql';
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $table = 'product_categories';
    protected $fillable = ['name'];
    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
