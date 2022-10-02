<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_transaction extends Model
{
    use HasFactory;

    // Ledger Head 
    public function head_name() {
        return $this->belongsTo(Ledger_Head::class, 'ledger_head');
    }

    //bank info
    public function bank_info() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
