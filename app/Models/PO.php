<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
    use HasFactory;
    protected $table = 'purchase_order';
    protected $primaryKey = 'id';
    protected $fillable = ['purchase_id','create_date','invoice','supplier','SKU','quantity','price','PO_status','notes','discount','tax','total_cost','file','submited'];
    
    public function items_po(){
        return $this->belongsTo(Items::class);
    }

}   
