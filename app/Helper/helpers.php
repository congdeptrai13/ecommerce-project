<?php

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

//active sidebar
function setActive(array $routes)
{
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return "active";
            }
        }
    }
}

function checkDiscount($product)
{
    $currentDate = date("Y-m-d");
    if ($product->offer_price && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
        return true;
    }
    return false;
}

function calculateDiscountPercent($price, $price_offer)
{
    return (($price - $price_offer) / $price) * 100;
}

function productType(string $type)
{
    switch ($type) {
        case "new_arrival":
            return "New";
        case "featured":
            return "Featured";

        case "top_product":
            return "Top";
        case "best_product":
            return "Best";
        default:
            return "None";
    }
}

function miniCartAmount()
{
    $total = 0;
    foreach (Cart::content() as $product) {
        $total += ($product->price + $product->options->variants_total) * $product->qty;

    }
    return $total;
}

function getMainTotal()
{
    $coupon = Session::get("coupon");
    $subTotal = miniCartAmount();
    if ($coupon && $coupon["discount_type"] === 'amount') {
        $total = $subTotal - $coupon["discount"];
        return $total;
    } elseif ($coupon && $coupon["discount_type"] === "percent") {
        $discount = $subTotal - ($subTotal * $coupon["discount"] / 100);
        $total = $subTotal - $discount;
        return $total;
    }
    return $subTotal;
}

function getDiscount()
{
    $coupon = Session::get("coupon");
    $subTotal = miniCartAmount();
    if ($coupon && $coupon["discount_type"] === 'amount') {
        return $coupon["discount"];
    } elseif ($coupon && $coupon["discount_type"] === "percent") {
        $discount = $subTotal - ($subTotal * $coupon["discount"] / 100);
        return $discount;
    }
    return 0;
}
