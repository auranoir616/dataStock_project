<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broken extends Model
{
    use HasFactory;
    protected $table = 'brokenstock';
    protected $fillable = ['broken_id','SKU','product','quantity','notes','file','reference'];

}
