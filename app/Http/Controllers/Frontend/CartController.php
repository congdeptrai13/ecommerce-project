<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            Session::forget("coupon");
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

    public function applyCoupon(Request $request)
    {
        // dd($request->all());
        if ($request->coupon_code === null) {
            return response()->json([
                "status" => 'error',
                "message" => "field coupon code is required"
            ]);
        }

        $coupon = Coupon::where([
            "code" => $request->coupon_code,
            "status" => 1
        ])->first();
        if ($coupon === null) {
            return response()->json([
                "status" => 'error',
                "message" => "coupon isn't exists"
            ]);
        } elseif ($coupon->start_date > date("Y-m-d")) {
            return response()->json([
                "status" => 'error',
                "message" => "coupon isn't exists"
            ]);
        } elseif ($coupon->end_date < date("Y-m-d")) {
            return response()->json([
                "status" => 'error',
                "message" => "coupon is expired"
            ]);
        } elseif ($coupon->total_used >= $coupon->quantity) {
            return response()->json([
                "status" => 'error',
                "message" => "can't apply this coupon"
            ]);
        }

        if ($coupon->discount_type === "amount") {
            Session::put("coupon", [
                "coupon_name" => $coupon->name,
                "coupon_code" => $coupon->code,
                "discount_type" => $coupon->discount_type,
                "discount" => $coupon->discount
            ]);
        }

        if ($coupon->discount_type === "percent") {
            Session::put("coupon", [
                "coupon_name" => $coupon->name,
                "coupon_code" => $coupon->code,
                "discount_type" => $coupon->discount_type,
                "discount" => $coupon->discount
            ]);
        }


        return response()->json([
            "status" => 'success',
            "message" => "apply coupon successfully"
        ]);
    }

    public function couponCalculate()
    {
        $coupon = Session::get("coupon");
        $subTotal = miniCartAmount();
        if (Session::has('coupon')) {
            if ($coupon["discount_type"] === 'amount') {
                $total = $subTotal - $coupon["discount"];
                return response()->json(
                    [
                        "status" => "success",
                        "cart_total" => $total,
                        "discount" => $coupon["discount"]
                    ]
                );
            } elseif ($coupon["discount_type"] === "percent") {
                $discount = $subTotal - ($subTotal * $coupon["discount"] / 100);
                $total = $subTotal - $discount;
                return response()->json(
                    [
                        "status" => "success",
                        "cart_total" => $total,
                        "discount" => $discount
                    ]
                );
            }
        }
        return response()->json([
            "status" => "success",
            "cart_total" => $subTotal,
            "discount" => 0
        ]);
    }
}
