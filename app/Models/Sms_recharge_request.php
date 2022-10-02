<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sms_recharge_request extends Model
{
    
    //Request user info
    public function user_info() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    //shop info
    public function shop_info() {
        return $this->belongsTo(Shop_setting::class, 'shop_id', 'shop_code');
    }
    
    

    
    use HasFactory;
}
