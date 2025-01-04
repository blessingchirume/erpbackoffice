<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use Spatie\Permission\Traits\HasRoles;
use App\Traits\DynamicRelationships;

class User extends Authenticatable implements AuditableContract
{
    use Auditable, HasApiTokens, HasFactory, Notifiable, HasRoles, DynamicRelationships;

    protected $connection = 'application';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'shop_id',
        'device_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function shop()
    {
        return $this->belongsToDynamic(Shop::class, 'shop_id', 'id', $this->company->company_db_name);
    }
}
