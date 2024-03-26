<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

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

    public function paymentSuccess()
    {
        return view("frontend.pages.payment-success");
    }
    public function paypalConfig()
    {
        $paypalSetting = PaypalSetting::first();
        $config = [
            'mode' => $paypalSetting->mode === 1 ? "live" : "sandbox", // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id' => $paypalSetting->client_id,
                'client_secret' => $paypalSetting->secret_key,
            ],
            'live' => [
                'client_id' => $paypalSetting->client_id,
                'client_secret' => $paypalSetting->secret_key,
            ],
            'payment_action' => "Sale", // Can only be 'Sale', 'Authorization' or 'Order'
            'currency' => $paypalSetting->currency_name,
            'notify_url' => "", // Change this accordingly for your application.
            'locale' => "en_US", // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl' => true, // Validate SSL when creating api client.
        ];

        return $config;
    }
    public function payWithPaypal()
    {
        $config = $this->paypalConfig();
        $paypalSetting = PaypalSetting::first();
        // dd($config);
        $provider = new PayPalClient($config);

        $provider->getAccessToken();


        $total = getFinalTotalAmount();
        $payableAmount = round($total * $paypalSetting->currency_rate, 2);

        //calculate payable amount depending

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route("user.paypal.success"),
                "cancel_url" => route("user.paypal.cancel")
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $config["currency"],
                        "value" => $payableAmount
                    ]
                ]
            ]
        ]);

        if (isset ($response["id"]) && $response["id"] !== null) {
            foreach ($response["links"] as $link) {
                if ($link["rel"] === "approve") {
                    return redirect()->away($link["href"]);
                }
            }
        } else {
            return redirect()->route("user.paypal.cancel");
        }
    }

    public function paypalSuccess(Request $request)
    {
        $config = $this->paypalConfig();
        $provider = new PayPalClient($config);

        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if (isset ($response["status"]) && $response["status"] == "COMPLETED") {
            return redirect()->route("user.payment.success");
        }
        return redirect()->route("user.paypal.cancel");
    }

    public function paypalCancel()
    {
        toastr("something went wrong try again later!", "error", "error");
        return redirect()->route("user.payment");
    }

}
