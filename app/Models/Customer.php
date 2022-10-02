<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Customer branch
    public function branch_name() {
        return $this->belongsTo(Branch_setting::class, 'branch_id');
    }
}
