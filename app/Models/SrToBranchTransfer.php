<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrToBranchTransfer extends Model
{
    use HasFactory;

    public function senderBranchInfo() {
        return $this->belongsTo(Branch_setting::class, 'branch_id');
    }

    public function sr_info() {
        return $this->belongsTo(User::class, 'sender_sr_id');
    }


}
