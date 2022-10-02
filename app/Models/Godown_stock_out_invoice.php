<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Godown_stock_out_invoice extends Model
{
    use HasFactory;

    //Branch id to name return
    public function branch_info() {
        return $this->belongsTo(Branch_setting::class, 'branch_id');
    }

    //User id to user info
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Transferable Product info
    public function products() {
        return $this->hasMany(Product_tracker::class, 'invoice_id', 'invoice_id');
    }


}
