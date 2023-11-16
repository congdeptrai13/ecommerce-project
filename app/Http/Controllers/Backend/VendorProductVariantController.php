<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, VendorProductVariantDataTable $dataTable)
    {
        //
        $product = Product::find($request->product);
        // check product vendor
        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        return $dataTable->render("vendor.products.product-variant.index", compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $product = Product::find($request->product);
        return view('vendor.products.product-variant.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product' => ['required'],
            'name' => ['required', 'max:200'],
            'status' => ['required'],
        ]);

        $variant = new Variant();
        $variant->product_id = $request->product;
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        toastr('Created Successfully', 'success', 'success');
        return redirect()->route('vendor.product-variant.index', ["product" => $request->product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        //
        $variant = Variant::find($id);
        $product = Product::find($variant->product_id);
        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        return view('vendor.products.product-variant.edit', compact('variant', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required'],
        ]);

        $variant = Variant::find($id);
        if ($variant->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        toastr('Updated Successfully', 'success', 'success');
        return redirect()->route('vendor.product-variant.index', ["product" => $variant->product_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = Variant::find($id);
        if ($variant->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        $VariantItemCheck = VariantItem::where('product_variant_id', $id)->count();
        if ($VariantItemCheck > 0) {
            return response([
                'status' => "error",
                'message' => 'This Variant contains VariantItem. Please delete all variant item related this one'
            ]);
        }
        $variant->delete();
        return response([
            'status' => "success",
            'message' => 'Deleted Successfully'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $variant = Variant::find($request->id);
        $variant->status = $request->status === 'true' ? 1 : 0;
        $variant->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }
}
