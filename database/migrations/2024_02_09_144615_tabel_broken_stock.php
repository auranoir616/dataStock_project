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
        Schema::create('brokenstock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('broken_id');
            $table->string('SKU');
            $table->string('product');
            $table->integer('quantity');
            $table->string('notes');
            $table->string('file');
            $table->string('reference');
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
