<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    //User info
    public function user_info() {
        return $this->belongsTo(User::class, 'added_by');
    }

    //bank info
    public function bank_info() {
        return $this->belongsTo(Bank::class, 'cash_or_bank');
    }

    //Branch info
    public function brnach_info() {
        return $this->belongsTo(Branch_setting::class, 'branch_id');
    }



}
