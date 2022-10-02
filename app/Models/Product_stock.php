<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_stock extends Model
{
    use HasFactory;

    //begin:: product stock branch id to name
    public function branch_info() {
        return $this->belongsTo(Branch_setting::class, 'branch_id');
    }
    //End:: product stock branch id to name

    //Product Info
    public function product_info() {
        return $this->belongsTo(Product::class, 'pid');
    }
    
    //begin:: purchase stocks
    public function purchase_stocks() {
        return $this->hasMany(Product_tracker::class, 'product_id', 'pid')->where('status', 1);
    }
    //End:: purchase stocks
    

    
}
