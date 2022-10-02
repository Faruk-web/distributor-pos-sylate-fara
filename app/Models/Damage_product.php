<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damage_product extends Model
{
    use HasFactory;

    //Product Info
    public function product_info() {
        return $this->belongsTo(Product::class, 'pid');
    }

    
}
