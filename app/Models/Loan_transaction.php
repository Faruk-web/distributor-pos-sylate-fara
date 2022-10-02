<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan_transaction extends Model
{
    use HasFactory;

    // User info 
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Lender info
    public function lender_info() {
        return $this->belongsTo(Loan_person::class, 'lender_id');
    }

    //bank info
    public function bank_info() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
