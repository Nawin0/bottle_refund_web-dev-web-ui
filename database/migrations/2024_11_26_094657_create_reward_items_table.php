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
        Schema::create('reward_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_code');
            $table->string('product_reward');
            $table->mediumText('details');
            $table->integer('stock');
            $table->integer('point');
            $table->mediumText('image');
            $table->integer('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reward_item');
    }
};
