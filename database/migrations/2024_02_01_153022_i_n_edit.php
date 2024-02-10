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
        Schema::dropIfExists('in');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('in', function (Blueprint $table) {
            $table->id(); //!PK
            $table->string('Id_Inbound');
            $table->string('purchase_Id'); //!FK
            $table->string('SKU');//!FK
            $table->string('product_name');
            $table->string('categories'); 
            $table->number('price');
            $table->number('quantity');
            $table->string('unit');
            $table->string('notes');
            $table->string('file');
            $table->string('checked');
            $table->timestamps();
        });

    }
};
