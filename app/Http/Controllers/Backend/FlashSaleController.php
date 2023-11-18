<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    //
    public function index(FlashSaleItemDataTable $dataTable)
    {
        $flashSale = FlashSale::first();
        $products = Product::where('is_approved', 1)->where('status', 1)->get();
        return $dataTable->render("admin.flash-sale.index", compact('flashSale', 'products'));
    }

    public function Update(Request $request)
    {
        $request->validate([
            "end_date" => ['required']
        ]);

        FlashSale::updateOrCreate(
            [
                'id' => 1
            ],
            ['end_date' => $request->end_date]
        );
        toastr('updated successfuly', 'success');
        return redirect()->back();
    }

    public function AddProduct(Request $request)
    {
        $request->validate(
            [
                "product" => ['required', 'unique:flash_sale_items,product_id'],
                'show_at_home' => ['required'],
                'status' => ['required']
            ],
            [
                'product.unique' => 'Product has already flash sale!'
            ]
        );

        $flashSale = FlashSale::first();
        $flashSaleItem = new FlashSaleItem();
        $flashSaleItem->product_id = $request->product;
        $flashSaleItem->flash_sale_id = $flashSale->id;
        $flashSaleItem->show_at_home = $request->show_at_home;
        $flashSaleItem->status = $request->status;
        $flashSaleItem->save();
        toastr('created successfuly', 'success');
        return redirect()->back();
    }

    public function ChangeShowAtHome(Request $request)
    {
        $product = FlashSaleItem::find($request->id);
        $product->show_at_home = $request->show_at_home === 'true' ? 1 : 0;
        $product->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $childCategory = FlashSaleItem::find($request->id);
        $childCategory->status = $request->status === 'true' ? 1 : 0;
        $childCategory->save();
        return response([
            'message' => 'Status has been updated'
        ]);
    }

    public function destroy(Request $request)
    {
        $flashSaleItem = FlashSaleItem::find($request->id);

        $flashSaleItem->delete();
        return response([
            'status' => "success",
            'message' => 'Deleted Successfully'
        ]);
    }
}
