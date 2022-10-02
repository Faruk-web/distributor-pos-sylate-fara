<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Expense_group extends Model
{
    use HasFactory;

    // ledger heads
    public function ledger_heads() {
        return $this->HasMany(Ledger_Head::class, 'group_id', 'id')->where('shop_id', Auth::user()->shop_id);
    }
}
