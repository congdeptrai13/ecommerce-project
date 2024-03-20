@extends('frontend.layouts.master')
@section('title')
    {{ $settings->site_name }} || Checkout
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
                        <h4>check out</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">peoduct</a></li>
                            <li><a href="#">check out</a></li>
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
                                                                                                                                                                                                                                                                                                                                                                                                                        CHECK OUT PAGE START
                                                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="wsus__check_form">
                        <h5>Billing Details <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">add
                                new address</a></h5>
                        <div class="row">
                            @foreach ($address as $item)
                                <div class="col-xl-6">
                                    <div class="wsus__checkout_single_address">
                                        <div class="form-check">
                                            <input class="form-check-input shipping_address" data-id="{{ $item->id }}"
                                                type="radio" name="flexRadioDefault"
                                                id="flexRadioDefault1{{ $item->id }}">
                                            <label class="form-check-label" for="flexRadioDefault1{{ $item->id }}">
                                                Select Address
                                            </label>
                                        </div>
                                        <ul>
                                            <li><span>Name :</span> {{ $item->name }}</li>
                                            <li><span>Phone :</span> {{ $item->phone }}</li>
                                            <li><span>Email :</span> {{ $item->email }}</li>
                                            <li><span>Country :</span> {{ $item->country }}</li>
                                            <li><span>City :</span> {{ $item->city }}</li>
                                            <li><span>Zip Code :</span> {{ $item->zip_code }}</li>
                                            <li><span>Address :</span> {{ $item->address }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="wsus__order_details" id="sticky_sidebar">
                        <p class="wsus__product">shipping Methods</p>
                        @foreach ($shippingRule as $method)
                            @if ($method->type === 'min_cost' && getMainTotal() >= $method->min_cost)
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="exampleRadios"
                                        id="exampleRadios1{{ $method->id }}" value="{{ $method->id }}"
                                        data-id="{{ $method->cost }}">
                                    <label class="form-check-label " for="exampleRadios1{{ $method->id }}">
                                        {{ $method->name }}
                                        <span>cost: {{ $settings->currency_icon . $method->cost }}</span>
                                    </label>
                                </div>
                            @elseif($method->type === 'flat_cost')
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="exampleRadios"
                                        id="exampleRadios{{ $method->id }}" value="{{ $method->id }}"
                                        data-id="{{ $method->cost }}">
                                    <label class="form-check-label" for="exampleRadios{{ $method->id }}">
                                        {{ $method->name }}
                                        <span>cost: {{ $settings->currency_icon . $method->cost }}</span>
                                    </label>
                                </div>
                            @endif
                        @endforeach

                        <div class="wsus__order_details_summery">
                            <p>subtotal: <span>{{ $settings->currency_icon . miniCartAmount() }}</span></p>
                            <p>shipping fee: <span id="shipping_fee">{{ $settings->currency_icon . 0 }}</span></p>
                            <p>coupon(-): <span>{{ $settings->currency_icon . getDiscount() }}</span></p>
                            <p><b>total:</b> <span><b id="main_total_amount"
                                        data-id="{{ getMainTotal() }}">{{ $settings->currency_icon . getMainTotal() }}</b></span>
                            </p>
                        </div>
                        <div class="terms_area">
                            <div class="form-check">
                                <input class="form-check-input agreement-checkout" type="checkbox" value=""
                                    id="flexCheckChecked3">
                                <label class="form-check-label" for="flexCheckChecked3">
                                    I have read and agree to the website <a href="#">terms and conditions *</a>
                                </label>
                            </div>
                        </div>
                        <form action="" id="checkoutFormSubmit">
                            <input type="hidden" name="shipping_method_id" value="" id="shipping_method_id">
                            <input type="hidden" name="shipping_address_id" value="" id="shipping_address_id">
                        </form>
                        <a href="#" id="submitCheckoutForm" class="common_btn">Place Order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{ route('user.create-address') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Name *" name="name"
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Phone *" name="phone"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="email" placeholder="Email *" name="email"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <select class="select_2" name="country">
                                                <option value="AL">Country / Region *</option>
                                                @foreach (config('setting.country_list') as $item)
                                                    <option {{ old('state') === $item ? 'selected' : '' }}
                                                        value="{{ $item }}">{{ $item }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="State *" name="state"
                                                value="{{ old('state') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Town / City *" name="city"
                                                value="{{ old('city') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Zip *" name="zip_code"
                                                value="{{ old('zip_code') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Street Address *" name="address"
                                                value="{{ old('address') }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============================              CHECK PAGE END   ==============================-->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".input[type='radio']").prop("checked", false);
            $("#shipping_method_id").val("");
            $("#shipping_address_id").val("");
            $(".shipping_method").on("click", function() {
                $("#shipping_method_id").val($(this).val());
                let shippingFee = $(this).data("id");
                $("#shipping_fee").text(`{{ $settings->currency_icon }}${shippingFee}`)
                let totalAmount = $("#main_total_amount").data("id");
                let totalCalculate = totalAmount + shippingFee;
                $("#main_total_amount").text(`{{ $settings->currency_icon }}${totalCalculate}`)
            })
            $(".shipping_address").on("click", function() {
                $("#shipping_address_id").val($(this).data("id"));
            })
        })

        $("#submitCheckoutForm").on("click", function(e) {
            e.preventDefault();
            if ($("#shipping_method_id").val() === "") {
                toastr.error("method shipping is required");
            } else if ($("#shipping_address_id").val() === "") {
                toastr.error("method address is required");
            } else if (!$(".agreement-checkout").prop("checked")) {
                toastr.error("you have to agree website terms and conditions");
            } else {
                $.ajax({
                    url: "{{ route('user.checkout.form-submit') }}",
                    method: "POST",
                    data: $('#checkoutFormSubmit').serialize(),
                    beforeSend: function() {
                        $("#submitCheckoutForm").html("<i class='fas fa-spinner fa-spin fa-1x'></i>")
                    },
                    success: function(data) {
                        if (data.status === "success") {
                            $("#submitCheckoutForm").html("Place Order")
                            window.location.href = data.redirect_url
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(status);
                    }
                })
            }

        })
    </script>
@endpush
