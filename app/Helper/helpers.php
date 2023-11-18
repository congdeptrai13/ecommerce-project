<?php

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
