<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWithVariation extends Model
{
    use HasFactory;
    
    public function variation_list_info() {
        return $this->belongsTo(VariationList::class, 'variation_list_id');
    }
}
