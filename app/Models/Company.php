<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Company extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'name' ,
        'email',
        'business_type',
        'company_db_name'
    ];
    // use HasFactory;

    public function createDatabase($dbName)
    {
        //Create a new DB with the company db_name attribute

        $new_db = DB::statement("CREATE DATABASE {$dbName}" );

        //Now migrate over all Company specific migrations

        if($new_db)
        {
            config()->set('database.connections.mysql.database', $dbName);

            DB::purge('mysql');

            DB::reconnect('mysql');

            return Artisan::call( 'migrate', [
                '--seed' => true,
                '--force' => true,
                '--database' => 'mysql',
                '--path' => 'database/migrations/tenant',
            ]);
        }

    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
