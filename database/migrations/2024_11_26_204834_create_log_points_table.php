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
        Schema::create('log_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone_no'); 
            $table->string('barcode')->nullable();
            $table->integer('point');
            $table->date('created_date')->nullable();
            $table->time('created_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_points');
    }
};
