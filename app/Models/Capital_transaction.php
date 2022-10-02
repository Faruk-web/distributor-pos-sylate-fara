<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capital_transaction extends Model
{
    use HasFactory;

    // User info 
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Owner info
    public function owner_info() {
        return $this->belongsTo(Owners::class, 'owner_id');
    }

    //bank info
    public function bank_info() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
