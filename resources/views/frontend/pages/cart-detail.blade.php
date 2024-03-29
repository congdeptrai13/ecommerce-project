@extends('frontend.layouts.master')
@section('title')
    {{ $settings->site_name }} || Cart Detail
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
                        <h4>cart View</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">peoduct</a></li>
                            <li><a href="#">cart view</a></li>
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
                                                                                                                                                                                                                                                                                                                                                                                    CART VIEW PAGE START
                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr class="d-flex">
                                        <th class="wsus__pro_img">
                                            product item
                                        </th>

                                        <th class="wsus__pro_name">
                                            product details
                                        </th>

                                        <th class="wsus__pro_status">
                                            unit price
                                        </th>

                                        <th class="wsus__pro_tk">
                                            total
                                        </th>

                                        <th class="wsus__pro_select">
                                            quantity
                                        </th>
                                        <th class="wsus__pro_icon">
                                            <a href="#" class="common_btn clear-cart">clear cart</a>
                                        </th>
                                    </tr>
                                    @foreach ($cartItems as $item)
                                        <tr class="d-flex">
                                            <td class="wsus__pro_img"><img src="{{ $item->options->image }}" alt="product"
                                                    class="img-fluid w-100">
                                            </td>

                                            <td class="wsus__pro_name">
                                                <p>{!! $item->name !!}</p>
                                                @foreach ($item->options->variants as $key => $variant)
                                                    <span>{{ $key }}: {{ $variant['name'] }}</span>
                                                @endforeach

                                            </td>

                                            <td class="wsus__pro_status">
                                                <h6>{{ $settings->currency_icon . $item->price }}</h6>
                                            </td>
                                            <td class="wsus__pro_tk">
                                                <h6 id="{{ $item->rowId }}">
                                                    {{ $settings->currency_icon . ($item->price + $item->options->variants_total) * $item->qty }}
                                                </h6>
                                            </td>

                                            <td class="wsus__pro_select">
                                                <div class="cart-detail-group-button">
                                                    <button class="cart-detail-button-decrement button-decrement">-</button>
                                                    <input class="input-qty-cart" data-rowid="{{ $item->rowId }}"
                                                        type="text" min="1" max="100"
                                                        value="{{ $item->qty }}" readonly />
                                                    <button class="cart-detail-button-increment button-increment">+</button>

                                                </div>
                                            </td>



                                            <td class="wsus__pro_icon">
                                                <a href="{{ route('cart-delete-product', $item->rowId) }}"><i
                                                        class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($cartItems) === 0)
                                        <td class="wsus__pro_status" style="width: 100%">
                                            <h6>cart is empty!</h6>
                                        </td>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="sub_total_cart">{{ $settings->currency_icon . miniCartAmount() }}</span></p>
                        <p>discount: <span class="cart-discount">{{ $settings->currency_icon . getDiscount() }}</span>
                        </p>
                        <p class="total"><span>total:</span> <span
                                class="cart-total">{{ $settings->currency_icon . getMainTotal() }}</span></p>

                        <form class="coupon_apply_discount">
                            <input type="text" placeholder="Coupon Code" name="coupon_code"
                                value="{{ session()->has('coupon') ? session()->get('coupon')['coupon_code'] : '' }}">
                            <button type="submit" class="common_btn">apply</button>
                        </form>
                        <a class="common_btn mt-4 w-100 text-center" href="{{ route('user.check-out') }}">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{ url('/') }}"><i
                                class="fab fa-shopify"></i> Keep Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_2.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="images/single_banner_3.jpg" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>Cosmetics</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                      CART VIEW PAGE END
                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
    </script>
@endpush
