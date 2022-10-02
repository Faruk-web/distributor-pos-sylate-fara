<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRenew extends Model
{
    use HasFactory;
    
    //Request user info
    public function user_info() {
        return $this->belongsTo(User::class, 'renew_by');
    }
    
    
}
