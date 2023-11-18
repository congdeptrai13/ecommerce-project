<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $sliders = Slider::where('status', 1)->orderby('serial', 'asc')->get();
        $flashSale = FlashSale::first();
        $flashSaleItem = FlashSaleItem::where('show_at_home', 1)->where('status', 1)->get();
        return view('frontend.home.home', compact(
            'sliders',
            'flashSale',
            'flashSaleItem'
        ));
    }
}
