<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    
    public function variation_lists() {
        return $this->HasMany(VariationList::class, 'variation_id', 'id');
    }
    
    
}
