<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    //
    public function index(Request $request)
    {
        $flashSale = FlashSale::first();
        $flashSaleItem = FlashSaleItem::where('status', 1)->paginate(20);
        return view('frontend.pages.flash-sale', compact('flashSale', 'flashSaleItem'));
    }
}
