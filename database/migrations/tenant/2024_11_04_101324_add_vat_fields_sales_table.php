<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sold_products', function (Blueprint $table) {
            $table->double('applied_vat', 10, 2)->after('total_amount')->default(1.0);
        });

//        Schema::table('sales', function (Blueprint $table) {
//            $table->double('applied_vat', 10, 2)->default(1.0);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('applied_vat');
        });
    }
};
