<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop_setting extends Model
{
    use HasFactory;

    //Shop banks
    public function banks() {
        return $this->hasMany(Bank::class, 'shop_id', 'shop_code');
    }

    //branches
    public function shop_branches() {
        return $this->hasMany(Branch_setting::class, 'shop_id', 'shop_code');
    }
    
    //orders
    public function orders() {
        return $this->hasMany(Order::class, 'shop_id', 'shop_code');
    }
    
    //orders
    public function customers() {
        return $this->hasMany(Customer::class, 'shop_id', 'shop_code');
    }
    
    //products
    public function products() {
        return $this->hasMany(Product::class, 'shop_id', 'shop_code');
    }
    
    //users
    public function users() {
        return $this->hasMany(User::class, 'shop_id', 'shop_code');
    }
    
    //renew Status
    public function renew_status() {
        return $this->hasMany(BusinessRenew::class, 'shop_id', 'shop_code')->orderBy('id', 'desc');
    }
    
    //resellers info
    public function reseller() {
        return $this->BelongsTo(User::class, 'reseller_id');
    }
    
    
    
    
    
    
    
    
    
    


}
