<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function variant()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }
}
