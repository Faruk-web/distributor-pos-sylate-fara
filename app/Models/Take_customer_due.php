<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Take_customer_due extends Model
{
    use HasFactory;

    //customer info
    public function customer_info() {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }

    //branch info
    public function branch_info() {
        return $this->belongsTo(Branch_setting::class, 'branch_id');
    }

    //Received user info
    public function received_user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }


}
