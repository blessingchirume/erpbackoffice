<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'name' => 'No category'
        ]);

        PaymentMethod::create([
            'name' => 'CASH',
            'description' => 'Cash Payments'

        ]);

        Currency::create([
            'name' => 'USD',
            'rate' => 1.0
        ]);
    }
}
