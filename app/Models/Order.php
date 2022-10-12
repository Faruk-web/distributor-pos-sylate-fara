<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    //customer info
    public function customer_info() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    //customer info
    public function sr_info() {
        return $this->belongsTo(User::class, 'sr_id');
    }


    //invoice products
    public function invoice_products() {
        return $this->hasMany(Ordered_product::class, 'invoice_id', 'invoice_id');
    }
    
    //invoice products
    public function multiple_payments() {
        return $this->hasMany(MultiplePayments::class, 'invoice_id', 'invoice_id');
    }
    

    


}
