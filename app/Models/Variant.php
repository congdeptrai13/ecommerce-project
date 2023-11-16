<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    public function variantItem()
    {
        return $this->hasMany(VariantItem::class, 'product_variant_id', 'id');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
