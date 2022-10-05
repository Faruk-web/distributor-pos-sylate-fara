<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchToSRproductsTransfer extends Model
{
    use HasFactory;

    public function senderBranchInfo() {
        return $this->belongsTo(Branch_setting::class, 'sender_branch_id');
    }

    public function sr_info() {
        return $this->belongsTo(User::class, 'sr_id');
    }


}
