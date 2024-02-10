<?php

namespace App\Models;

use App\Models\Items;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Out extends Model
{
    use HasFactory;
    protected $table = 'out';
    protected $fillable = ['SKU','quantity','date_out','object'];

    public function items_out(){
        return $this->belongsTo(Items::class);
    }

}
