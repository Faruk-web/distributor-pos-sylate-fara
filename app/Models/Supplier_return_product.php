<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_return_product extends Model
{
    use HasFactory;

    
    public function product_info() {
        return $this->belongsTo(Product::class, 'product_id');
     }
}
