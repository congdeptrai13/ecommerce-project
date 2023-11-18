<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendProductController extends Controller
{
    //

    public function index(string $slug)
    {
        $product = Product::with([
            'vendor',
            'category',
            'productImageGallery',
            'brand', 'variant'
        ])->where("slug", $slug)->where('status', 1)->first();
        $flashSale = FlashSale::first();

        return view('frontend.pages.product-detail', compact('product', 'flashSale'));
    }
}
