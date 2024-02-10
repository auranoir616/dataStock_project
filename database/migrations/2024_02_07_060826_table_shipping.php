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
        Schema::create('shipping', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shipping_id');
            $table->string('receipt');
            $table->string('SKU');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('discount');
            $table->integer('tax');
            $table->integer('shipping_cost');
            $table->integer('total_cost');
            $table->string('destination');
            $table->string('name');
            $table->string('expedition');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
