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
        Schema::create('out', function (Blueprint $table) {
            $table->id(); //!PK
            $table->string('SKU'); //!FK
            $table->integer('quantity');
            $table->date('date_out');
            $table->string('object'); //tujuan
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
