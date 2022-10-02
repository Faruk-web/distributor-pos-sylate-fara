<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Return_order extends Model
{
    use HasFactory;

    //customer info
    public function customer_info() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    // //Return invoice products
    // public function invoice_products() {
    //     return $this->hasMany(Ordered_product::class, 'invoice_id', 'invoice_id');
    // }



}
