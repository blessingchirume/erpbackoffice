<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\ProductCategory;
use App\Models\Shop;
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

        Client::create([
            'name' => 'CASH CUSTOMER',
            'document_id' => 1
        ]);

        Shop::create([
            'name' => 'Default Shop',
            'address' => ""
        ]);
    }
}
