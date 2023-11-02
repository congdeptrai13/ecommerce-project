<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantItem extends Model
{
    use HasFactory;
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'product_variant_id', 'id');
    }
}
