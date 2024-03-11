<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        // dd($request->all());
        $product = Product::find($request->product_id);
        $variants = [];
        $variantsTotalAmount = 0;
        if ($request->has("variants_Items")) {
            foreach ($request->variants_Items as $item_id) {
                $variantItem = VariantItem::find($item_id);
                $variants[$variantItem->variant->name]['name'] = $variantItem->name;
                $variants[$variantItem->variant->name]['price'] = $variantItem->price;
                $variantsTotalAmount += $variantItem->price;
            }
        }
        $productPrice = 0;
        if (checkDiscount($product)) {
            $productPrice += $product->offer_price;
        } else {
            $productPrice += $product->price;
        }
        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantsTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        // dd($cartData);
        Cart::add($cartData);
        return response([
            "status" => "success",
            "message" => "Add to cart successfully!"
        ]);
    }

    public function cartViewDetail()
    {
        $cartItems = Cart::content();
        // dd($cartItems);
        return view('frontend.pages.cart-detail', compact("cartItems"));
    }

    public function updateProductQuantity(Request $request)
    {
        Cart::update($request->rowId, $request->quantity);
        return response()->json([
            "status" => "success",
            "message" => "update quantity product successfully"
        ]);
    }
}
