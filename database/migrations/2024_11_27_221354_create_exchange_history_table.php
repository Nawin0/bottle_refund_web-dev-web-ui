<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchange_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone_no');
            $table->string('product_code');
            $table->integer('point');
            $table->mediumText('image64');
            $table->integer('quantity');
            $table->integer('address');
            $table->integer('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_history');
    }
};
