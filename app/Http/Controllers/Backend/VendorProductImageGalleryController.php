<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductImageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTrait;
    public function index(Request $request, VendorProductImageGalleryDataTable $dataTable)
    {
        //
        $product = Product::findOrFail($request->product);
        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        return  $dataTable->render("vendor.products.image-gallery.index", compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'image.*' => ["required", 'image', 'max:2048']
        ]);
        $ProductImagePath = $this->uploadMultiImage($request, 'image', 'uploads');
        foreach ($ProductImagePath as $path) {
            $productImageGallery = new ProductImageGallery();
            $productImageGallery->product_id = $request->product_id;
            $productImageGallery->image = $path;
            $productImageGallery->save();
        }
        toastr('Created Successfully', 'success');
        return redirect()->back();
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $productImageGallery = ProductImageGallery::find($id);
        if ($productImageGallery->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        $this->deleteImage($productImageGallery->image);
        $productImageGallery->delete();
        return response([
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ]);
    }
}
