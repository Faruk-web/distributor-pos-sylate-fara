<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class Supplier_invoice extends Model
{
    use HasFactory;

    //Invoice supplier_id to supplier_name
    public function supplier_name() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    //Invoice supplier_id to supplier_company name
    public function supplier_company_name() {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    //invoice product
    public function invoice_products() {
        return $this->hasMany(Product_tracker::class, 'invoice_id', 'supp_invoice_id')->where('product_form','!=', 'SUPP_R');;
    }

    
    
    

    
}
