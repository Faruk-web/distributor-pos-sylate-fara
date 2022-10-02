<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiplePayments extends Model
{
    use HasFactory;
    
    //Bank info
    function bank_info() {
        return $this->belongsTo(Bank::class, 'deposit_to');
    }
    
    
}
