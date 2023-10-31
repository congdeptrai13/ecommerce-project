<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantItemController extends Controller
{
    //
    public function index(VariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = Variant::findOrFail($variantId);
        return $dataTable->render("admin.product.variant-item.index", compact('product', 'variant'));
    }
}
