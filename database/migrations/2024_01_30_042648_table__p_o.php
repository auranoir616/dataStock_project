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
        Schema::create('purchase_order', function(Blueprint $table){
            $table->id(); //!PK
            $table->string('purchase_id');
            $table->date('create_date');
            $table->string('invoice');
            $table->string('supplier');
            $table->string('SKU'); //!fk
            $table->integer('quantity');
            $table->string('payment');
            $table->string('PO_status');
            $table->string('notes');
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
