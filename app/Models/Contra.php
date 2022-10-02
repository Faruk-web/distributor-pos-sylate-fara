<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contra extends Model
{
    use HasFactory;

    //User info
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }

    //sender info
    public function sender_info() {
        return $this->belongsTo(Bank::class, 'sender');
    }

    //Receiver info
    public function receiver_info() {
        return $this->belongsTo(Bank::class, 'receiver');
    }
    
}
