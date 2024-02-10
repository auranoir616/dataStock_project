<?php

namespace App\Models;

use App\Models\In;
use App\Models\Out;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items';
    // protected $primaryKey = 'SKU';
    protected $fillable = ['SKU','name','categories','unit','price','quantity','notes','date_in','exp_date'];

    public function transactions_(){
        return $this->hasMany(Transaction::class, 'SKU');
    }

    public function in_(){
        return $this->hasMany(In::class, 'SKU');
    }
    public function out_(){
        return $this->hasMany(Out::class, 'SKU');
    }
    public function po_(){
        return $this->hasMany(PO::class, 'SKU');
    }

}
