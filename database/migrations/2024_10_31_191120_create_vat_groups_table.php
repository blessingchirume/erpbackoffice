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
        Schema::create('vat_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('rate', 10, 2)->default(0.0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vat_groups');
    }
};
