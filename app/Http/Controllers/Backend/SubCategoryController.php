<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\subCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(subCategoryDataTable $dataTable)
    {
        //
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $category = Category::all();
        return view('admin.sub-category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'category' => ['required'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name'],
            'status' => ['required']
        ]);
        $subcategory = new SubCategory();
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->status = $request->status;
        $subcategory->save();
        Toastr('Created Successfully', 'success');
        return redirect()->route('admin.sub-category.index');
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
        $category = Category::all();
        $subCategory = SubCategory::find($id);
        //
        return view('admin.sub-category.edit', compact('category', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'category' => ['required'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name,' . $id],
            'status' => ['required']
        ]);
        $subcategory = SubCategory::find($id);
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->status = $request->status;
        $subcategory->save();
        Toastr('Updated Successfully', 'success');
        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $subCategory = Subcategory::find($id);
        $childCategory = ChildCategory::where("sub_category_id", $subCategory->id)->count();
        if ($childCategory > 0) {
            return response([
                'status' => 'error',
                'message' => 'this sub category contains child-category. Pls delete child category first'
            ]);
        }
        $subCategory->delete();
        return response([
            'status' => 'success',
            'message' => 'Deleted Successfully'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $SubCategory = SubCategory::find($request->id);
        $SubCategory->status = $request->status === 'true' ? 1 : 0;
        $SubCategory->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }
}
