<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger_Head extends Model
{
    use HasFactory;
    
    protected $fillable = ['shop_id', 'group_id', 'head_name', 'is_edit', 'created_at'];

    //group name
    public function group_name() {
        return $this->belongsTo(Expense_group::class, 'group_id');
    }
}
