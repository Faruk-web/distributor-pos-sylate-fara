<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchToBranchTransfer extends Model
{
    use HasFactory;

    public function senderBranchInfo() {
        return $this->belongsTo(Branch_setting::class, 'sender_branch_id');
    }

    public function receiverBranchInfo() {
        return $this->belongsTo(Branch_setting::class, 'receiver_branch_id');
    }

    


}
