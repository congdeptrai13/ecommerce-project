@extends('frontend.layouts.master')
@section('title')
    {{ $settings->site_name }} || Payment
@endsection
@section('content')
    <!--============================
                                                                                                                        BREADCRUMB START
                                                                                                                    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>payment</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">peoduct</a></li>
                            <li><a href="#">payment</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                        BREADCRUMB END
                                                                                                                    ==============================-->


    <!--============================
                                                                                                                        PAYMENT PAGE START
                                                                                                                    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                {{-- <button class="nav-link common_btn active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-paypal" type="button" role="tab"
                                    aria-controls="v-pills-Paypal" aria-selected="true">Paypal</button> --}}
                                <button class="nav-link common_btn active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-paypal" type="button" role="tab"
                                    aria-controls="v-pills-Paypal" aria-selected="true">Paypal</button>
                                <button class="nav-link common_btn" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-stripe" type="button" role="tab"
                                    aria-controls="v-pills-stripe" aria-selected="false">Stripe</button>
                                {{-- <button class="nav-link common_btn" id="v-pills-razorpay-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-razorpay" type="button" role="tab"
                                    aria-controls="v-pills-razorpay" aria-selected="false">RazorPay</button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent" id="sticky_sidebar">
                            @include('frontend.pages.payment-gateway.paypal')
                            @include('frontend.pages.payment-gateway.stripe')
                            {{-- @include('frontend.pages.payment-gateway.razorpay') --}}

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Order Summary</h5>
                            <p>subtotal: <span>{{ $settings->currency_icon . miniCartAmount() }}</span></p>
                            <p>shipping fee(+): <span>{{ $settings->currency_icon . getShippingFee() }}</span></p>
                            <p>coupon(-): <span>{{ $settings->currency_icon . getDiscount() }}</span></p>
                            <h6>total <span>{{ $settings->currency_icon . getFinalTotalAmount() }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                        PAYMENT PAGE END
                                                                                                                    ==============================-->
@endsection


@push('scripts')
@endpush
