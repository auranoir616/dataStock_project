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
        Schema::create('returnIn', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('return_id');
            $table->string('shipping_id');
            $table->string('receipt');
            $table->string('SKU');
            $table->string('product');
            $table->integer('quantity');
            $table->string('expedition');
            $table->string('date_sent'); 
            $table->string('notes');
            $table->string('files');
            $table->string('placement');
            $table->string('check');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return', function (Blueprint $table) {
            //
        });
    }
};
