<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('client_id');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->default(0.0);
            $table->decimal('tendered_amount', 10, 2)->default(0.0);
            $table->decimal('change', 10, 2)->default(0.0);
            $table->timestamp('finalized_at')->nullable();
            $table->foreign('user_id')->references('id')->on(config()->get('database.connections.application.database', 'inventory').'.users');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
