<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    //

    public function index()
    {
        if (!Session::has("address") || !Session::has("shipping_method")) {
            return redirect()->route("user.check-out");
        }
        return view("frontend.pages.payment");
    }
}
