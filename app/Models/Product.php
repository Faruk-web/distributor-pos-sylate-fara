<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class Product extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class, 'p_cat');
    }

    //Begin:: unit name
    public function unit_type_name() {
        return $this->belongsTo(Unit_type::class, 'p_unit_type');
    }
    //End:: unit name

    //Begin:: Brand name
    public function brand_info() {
        return $this->belongsTo(Brand::class, 'p_brand');
    }
    //End:: Brand name

    
    //begin:: products stocks
    public function branch_stocks() {
        return $this->hasMany(Product_stock::class, 'pid', 'id');
    }
    //End:: products stocks
    
    //begin:: purchase stocks
    public function purchase_stocks() {
        return $this->hasMany(Product_tracker::class, 'product_id', 'id')->where('status', 1);
    }
    //End:: purchase stocks
    
    
    
    
}
