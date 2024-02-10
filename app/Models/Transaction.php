<?php

namespace App\Models;

use App\Models\User;
use App\Models\Items;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = ['transaction_id','username','SKU','quantity','price/unit','price','total_price','transaction_date'];

    public function items_transaction(){
        return $this->belongsTo(Items::class);
    }

    public function transaction_by_user(){
        return $this->belongsTo(User::class);
    }

}
