<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $datatable)
    {
        //
        return $datatable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => ['required', 'max:200'],
            'type' => ['required'],
            'min_cost' => ['nullable', 'integer'],
            'cost' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);
        $shipping = new ShippingRule();
        $shipping->name = $request->name;
        $shipping->type = $request->type;
        $shipping->min_cost = $request->min_cost;
        $shipping->cost = $request->cost;
        $shipping->status = $request->status;
        $shipping->save();

        toastr('Create Shipping rule successfully', 'success', 'Success');
        return redirect()->route('admin.shipping-rule.index');
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
        $shipping = ShippingRule::findOrFail($id);
        return view('admin.shipping-rule.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'name' => ['required', 'max:200'],
            'type' => ['required'],
            'min_cost' => ['nullable', 'integer'],
            'cost' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);
        $shipping = ShippingRule::findOrFail($id);
        $shipping->name = $request->name;
        $shipping->type = $request->type;
        $shipping->min_cost = $request->min_cost;
        $shipping->cost = $request->cost;
        $shipping->status = $request->status;
        $shipping->save();

        toastr('Update Shipping rule successfully', 'success', 'Success');
        return redirect()->route('admin.shipping-rule.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $shipping = ShippingRule::findOrFail($id);
        $shipping->delete();
        toastr('Update Shipping rule successfully', 'success', 'Success');

        return response([
            'status' => 'success',
            'message' => 'deleted Shipping rule successfully'
        ]);
    }
}
