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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('SKU');   //! PK
            $table->string('name');
            $table->string('categories');
            $table->string('unit');
            $table->integer('price');
            $table->integer('quantity');
            $table->string('notes');
            $table->date('date_in');
            $table->date('exp_date');
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
