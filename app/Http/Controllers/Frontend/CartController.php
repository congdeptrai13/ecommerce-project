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
        if ($product->qty === 0) {
            return response()->json([
                "status" => "stock_out",
                "message" => "product stock out"
            ]);
        } elseif ($product->qty < $request->qty) {
            return response()->json([
                "status" => "stock_out",
                "message" => "quantity not available in stock"
            ]);
        }
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
        if (count($cartItems) === 0) {
            toastr("cart empty add some product to view", "warning");
            return redirect()->route("home");
        }
        // dd($cartItems);
        return view('frontend.pages.cart-detail', compact("cartItems"));
    }

    public function updateProductQuantity(Request $request)
    {
        $productId = Cart::get($request->rowId)->id;
        $product = Product::find($productId);
        if ($product->qty === 0) {
            return response()->json([
                "status" => "stock_out",
                "message" => "product stock out"
            ]);
        } elseif ($product->qty < $request->quantity) {
            return response()->json([
                "status" => "stock_out",
                "message" => "quantity not available in stock"
            ]);
        }
        Cart::update($request->rowId, $request->quantity);
        $productTotal = $this->productDetail($request->rowId);
        return response()->json([
            "status" => "success",
            "message" => "update quantity product successfully",
            "product_total" => $productTotal
        ]);
    }

    public function productDetail($rowId)
    {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_total) * $product->qty;
        return $total;
    }

    public function miniCartAmount()
    {
        $total = 0;
        foreach (Cart::content() as $product) {
            $total += $this->productDetail($product->rowId);
        }
        return $total;
    }

    public function cartClear()
    {
        Cart::destroy();
        return response()->json([
            "status" => "success",
            "message" => "destroy cart successfully"
        ]);
    }

    public function cartDeleteProduct($rowId)
    {
        // dd($rowId);
        Cart::remove($rowId);
        toastr("delete successfully", "success");
        return redirect()->back();
    }

    public function updateCartCount()
    {
        return Cart::content()->count();
    }

    public function getCartContent()
    {
        return Cart::content();
    }

    public function miniCartRemove(Request $request)
    {
        Cart::remove($request->rowId);
        return response()->json([
            "status" => "success",
            "message" => "remove product from mini cart successfully"
        ]);
    }
}
