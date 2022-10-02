<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier_invoice;
use App\Models\Supplier_inv_return;

class Supplier extends Model
{
    use HasFactory;

    //Individual Supplier invoice total 
    public static function invoice_total_sum($id) {
        $total_sum = Supplier_invoice::where('supplier_id', $id)->sum('total_gross');
        return $total_sum;
    }

    //Individual Supplier instant Paid
    public static function instant_paid($id) {
        $total_sum = Supplier_invoice::where('supplier_id', $id)->sum('paid');
        return $total_sum;
    }

    //Supplier Product Return
    public static function supplier_product_return($id) {
        $total_sum = Supplier_inv_return::where('supplier_id', $id)->sum('total_gross');
        return $total_sum;
    }

    //Supplier Others Paid
    public static function supplier_others_paid($code) {
        $total_sum = Supplier_payment::where('supplier_code', $code)->sum('paid');
        return $total_sum;
    }

    

    

    


}
