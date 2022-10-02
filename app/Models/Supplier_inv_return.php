<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_inv_return extends Model
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
    // public function invoice_products($id) {
    //     return $this->hasMany(Supplier_return_product::class, 'supp_invoice_id', 'supp_invoice_id')->where('how_many_times_edited', 2);
    // }


}
