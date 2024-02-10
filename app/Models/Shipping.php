<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shipping';
    protected $fillable = [
        'shipping_id',
        'receipt',
        'SKU',
        'product',
        'quantity',
        'price',
        'discount',
        'tax',
        'shipping_cost',
        'total_cost',
        'destination',
        'name',
        'expedition',
        'status',
        'file',
        'status',
        'notes',
        'submited_in?'
    ]
    ;
    

}
