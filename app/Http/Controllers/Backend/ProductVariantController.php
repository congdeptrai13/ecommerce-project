<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductVariantDataTable $dataTable)
    {
        //
        $product = Product::find($request->product);
        return $dataTable->render("admin.product.product-variant.index", compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.product.product-variant.create');
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
        return redirect()->route('admin.product-variant.index', ["product" => $request->product]);
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
    public function edit(string $id)
    {
        //
        $variant = Variant::find($id);
        return view('admin.product.product-variant.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required'],
        ]);

        $variant = Variant::find($id);
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        toastr('Updated Successfully', 'success', 'success');
        return redirect()->route('admin.product-variant.index', ["product" => $variant->product_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = Variant::find($id);
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
