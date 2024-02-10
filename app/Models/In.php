<?php

namespace App\Models;

use App\Models\Items;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class In extends Model
{
    use HasFactory;
    protected $table = 'in';
    protected $fillable = [
    'complete',
    'id_itemPO',
    'Id_Inbound',
    'purchase_Id',
    'invoice',
    'SKU',
    'product_name',
    'categories',
    'price',
    'quantity',
    'unit',
    'notes',
    'file',
    'placement',
    'checked'
];

    public function items_in(){
        return $this->belongsTo(Items::class);
    }
    

}
