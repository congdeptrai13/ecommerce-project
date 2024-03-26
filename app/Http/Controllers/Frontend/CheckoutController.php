<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    //
    public function index()
    {
        $address = UserAddress::where("user_id", auth()->user()->id)->get();
        $shippingRule = ShippingRule::where("status", 1)->get();
        return view("frontend.pages.check-out", compact("address", 'shippingRule'));
    }

    public function createUserAdress(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'phone' => ['required', 'max:200'],
            'email' => ['required', 'email'],
            'country' => ['required', 'max:200'],
            'state' => ['required', 'max:200'],
            'city' => ["required", "max:200"],
            "zip_code" => ["required", "max:200"],
            "address" => ["required", "max:200"]
        ]);
        $address = new UserAddress();
        $address->user_id = Auth::id();
        $address->name = $request->name;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->address = $request->address;
        $address->save();

        toastr('Add new Address successfully', 'success', 'Success');
        return redirect()->back();
    }

    function checkoutFormSubmit(Request $request)
    {
        $request->validate([
            "shipping_method_id" => ["required", "integer"],
            "shipping_address_id" => ["required", "integer"]
        ]);

        $shipping_method = ShippingRule::find($request->shipping_method_id);
        if ($shipping_method) {
            Session::put("shipping_method", [
                "id" => $shipping_method->id,
                "name" => $shipping_method->name,
                "type" => $shipping_method->type,
                "cost" => $shipping_method->cost,
            ]);
        }

        $address = UserAddress::find($request->shipping_address_id)->toArray();
        if ($address) {
            Session::put("address", $address);
        }
        return response()->json([
            "status" => "success",
            "redirect_url" => route("user.payment")
        ]);
    }

}
