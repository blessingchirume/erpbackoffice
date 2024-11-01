<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = Currency::create([
            'name' => 'USD',
            'rate' => 1
        ]);

        $currency = Currency::create([
            'name' => 'ZiG',
            'rate' => 29.3
        ]);
    }
}
