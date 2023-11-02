<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantItem;
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

    public function create($productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $variant = Variant::findOrFail($variantId);
        return view('admin.product.variant-item.create', compact('product', 'variant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productId' => ['required', 'integer'],
            'name' => ['required', 'max:200'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);
        $VariantItem = new VariantItem();
        $VariantItem->product_variant_id = $request->variantId;
        $VariantItem->name = $request->name;
        $VariantItem->price = $request->price;
        $VariantItem->is_default = $request->is_default;
        $VariantItem->status = $request->status;
        $VariantItem->save();
        toastr('Created Successfully', 'success', 'success');
        return redirect()->route('admin.product-variant-item.index', ["productId" => $request->productId, 'variantId' => $request->variantId]);
    }

    public function edit($variantItemId)
    {
        $variantItem = VariantItem::findOrFail($variantItemId);
        return view('admin.product.variant-item.edit', compact('variantItem'));
    }

    public function update(Request $request, $variantItemId)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);
        $VariantItem =  VariantItem::findOrFail($variantItemId);
        $VariantItem->name = $request->name;
        $VariantItem->price = $request->price;
        $VariantItem->is_default = $request->is_default;
        $VariantItem->status = $request->status;
        $VariantItem->save();
        toastr('Updated Successfully', 'success', 'success');
        return redirect()->route('admin.product-variant-item.index', ["productId" => $VariantItem->variant->product_id, 'variantId' => $VariantItem->variant->id]);
    }

    public function destroy($variantItemId)
    {
        $VariantItem = VariantItem::findOrFail($variantItemId);
        $VariantItem->delete();
        return response([
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $VariantItem = VariantItem::findOrFail($request->id);
        $VariantItem->status = $request->status === 'true' ? 1 : 0;
        $VariantItem->save();
        return response([
            'status' => 'success',
            'message' => 'Status has been updated'
        ]);
    }
}
