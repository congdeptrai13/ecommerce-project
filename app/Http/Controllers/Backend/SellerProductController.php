<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PendingSellerProductDataTable;
use App\DataTables\SellerProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    //

    public function index(SellerProductDataTable $dataTables)
    {
        return $dataTables->render("admin.product.seller-product.index");
    }
    public function PendingSellerProduct(PendingSellerProductDataTable $dataTables)
    {
        return $dataTables->render("admin.product.pending-seller-product.index");
    }

    public function ChangeApprove(Request $request)
    {
        $product = Product::find($request->id);
        $product->is_approved = $request->approve;
        $product->save();
        return response([
            'message' => 'Approve has been updated'
        ]);
    }
}
