<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Str;
use Yoeunes\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        //
        return $dataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => ["required", 'not_in:empty'],
            'name' => ['required', 'max:200', 'unique:categories,name'],
            'status' => ['required']
        ]);

        $category = new Category();
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();
        Toastr('Created Successfully', 'success');
        return redirect()->route('admin.category.index');
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
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'icon' => ["required", 'not_in:empty'],
            'name' => ['required', 'max:200', 'unique:categories,name,' . $id],
            'status' => ['required']
        ]);

        $category = Category::find($id);
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();
        Toastr('Updated Successfully', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::find($id);
        $subCategory = SubCategory::where('category_id', $category->id)->count();
        if ($subCategory > 0) {
            return response([
                'status' => 'error',
                'message' => 'this category contains sub-category. Pls delete sub category first'
            ]);
        }
        $category->delete();
        Toastr('Deleted Successfully', 'success');
        return response([
            'status' => 'success',
            'message' => 'deleted successfully'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $category = Category::find($request->id);
        $category->status = $request->status === 'true' ? 1 : 0;

        $category->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }
}
