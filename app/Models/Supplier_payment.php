<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_payment extends Model
{
    use HasFactory;

    //supplier info 
    public function supplier_info() {
        return $this->belongsTo(Supplier::class, 'supplier_code', 'code');
    }

    //bank info
    public function bank_info() {
        return $this->belongsTo(Bank::class, 'cheque_or_mfs_account', 'id');
    }

    //user info
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
