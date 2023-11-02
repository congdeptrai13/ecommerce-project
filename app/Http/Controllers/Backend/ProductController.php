<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\SubCategory;
use App\Models\Variant;
use App\Models\VariantItem;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;

class ProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $datatable)
    {
        //
        return $datatable->render("admin.product.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => ['required'],
            'category' => ['required'],
            'sub_category' => ['nullable'],
            'child_category' => ['nullable'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:300'],
            'status' => ['required']
        ]);
        $product = new Product();
        $thumbImagePath = $this->uploadImage($request, 'thumb_image', 'uploads');
        $product->thumb_image = $thumbImagePath;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();

        toastr('Created Successfully', 'success');
        return redirect()->route('admin.products.index');
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
        $product = Product::find($id);
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $childCategories = ChildCategory::all();
        $brands = Brand::all();
        return view('admin.product.edit', compact('product', 'categories', 'brands', 'subCategories', 'childCategories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => ['required'],
            'category' => ['required'],
            'sub_category' => ['nullable'],
            'child_category' => ['nullable'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:300'],
            'status' => ['required']
        ]);
        $product = Product::FindOrFail($id);
        $thumbImagePath = $this->updateImage($request, 'thumb_image', 'uploads', $product->thumb_image);
        $product->thumb_image = !empty($thumbImagePath) ? $thumbImagePath : $product->thumb_image;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();

        toastr('Updated Successfully', 'success');
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        //xóa ảnh thumbnail image
        $this->deleteImage($product->thumb_image);

        // xóa ảnh từ image gallery
        $productImageGallery = ProductImageGallery::where("product_id", $product->id)->get();
        if (count($productImageGallery) > 0) {
            foreach ($productImageGallery as $imageGallery) {
                $this->deleteImage($imageGallery->image);
                $imageGallery->delete();
            }
        }


        // xóa các product variant
        $variants = Variant::where('product_id', $product->id)->get();
        foreach ($variants as $variant) {
            $variant->variantItem()->delete();
            $variant->delete();
        }
        $product->delete();

        return response([
            'status' => "success",
            'message' => 'Deleted Successfully'
        ]);
    }

    public function getSubCategories(Request $request)
    {
        $subCategory = SubCategory::where('category_id', $request->id)->get();
        return $subCategory;
    }

    public function getChildCategories(Request $request)
    {
        $childCategory = ChildCategory::where('sub_category_id', $request->id)->get();
        return $childCategory;
    }

    public function changeStatus(Request $request)
    {
        $product = Product::find($request->id);
        $product->status = $request->status === 'true' ? 1 : 0;
        $product->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }
}
