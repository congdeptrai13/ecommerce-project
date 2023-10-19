<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTrait;
    public function index(BrandDataTable $datatable)
    {
        //
        return $datatable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "logo" => ["image", 'required', 'max:2048'],
            "name" => ['required', 'max:200'],
            'is_featured' => ["required"]
        ]);
        $brand = new Brand();
        $logoPath = $this->uploadImage($request, 'logo', 'uploads');
        $brand->logo = $logoPath;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        Toastr('Created Successfully', 'success');
        return redirect()->route('admin.brand.index');
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
        $brand = Brand::find($id);
        //
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            "logo" => ["image", 'max:2048'],
            "name" => ['required', 'max:200', 'unique:brands,name,' . $id],
            'is_featured' => ["required"]
        ]);
        $brand = Brand::find($id);
        $logoPath = $this->updateImage($request, 'logo', 'uploads', $brand->logo);

        $brand->logo =  !empty($logoPath) ? $logoPath : $brand->logo;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        Toastr('Updated Successfully', 'success');
        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $brand = Brand::find($id);
        $this->deleteImage($brand->logo);
        $brand->delete();
        return response([
            'status' => 'success',
            'message' => "Deleted Successfuly"
        ]);
    }

    public function changeStatus(Request $request)
    {
        $brand = Brand::find($request->id);
        $brand->status = $request->status === 'true' ? 1 : 0;
        $brand->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }
}
