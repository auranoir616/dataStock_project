<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnIn extends Model
{
    use HasFactory;
    protected $table = 'returnIn';
    protected $fillable = [
            'return_id',
            'shipping_id',
            'receipt',
            'SKU',
            'product',
            'quantity', 
            'expedition',
            'date_sent',
            'notes',
            'files',
            'placement',
            'check',
            'submited'
        ];

}
