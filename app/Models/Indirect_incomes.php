<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indirect_incomes extends Model
{
    // Ledger Head 
    public function head_name() {
        return $this->belongsTo(Ledger_Head::class, 'ledger_head');
    }

    //bank info
    public function bank_info() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    
    //User info
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    use HasFactory;
}
