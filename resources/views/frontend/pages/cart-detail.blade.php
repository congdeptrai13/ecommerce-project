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
                                            <a href="#" class="common_btn">clear cart</a>
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
                                                <p>{{ $settings->currency_icon . $item->price }}</p>
                                            </td>
                                            <td class="wsus__pro_tk">
                                                <p>{{ $settings->currency_icon . $item->price + $item->options->variants_total }}
                                                </p>
                                            </td>

                                            <td class="wsus__pro_select">
                                                <div class="cart-detail-group-button">
                                                    <button class="cart-detail-button-decrement button-decrement">-</button>
                                                    <input class="input-qty-cart" data-rowid="{{ $item->rowId }}"
                                                        type="text" min="1" max="100" value="{{$item->qty}}" />
                                                    <button class="cart-detail-button-increment button-increment">+</button>

                                                </div>
                                            </td>



                                            <td class="wsus__pro_icon">
                                                <a href="#"><i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>total cart</h6>
                        <p>subtotal: <span>$124.00</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span>$10.00</span></p>
                        <p class="total"><span>total:</span> <span>$134.00</span></p>

                        <form>
                            <input type="text" placeholder="Coupon Code">
                            <button type="submit" class="common_btn">apply</button>
                        </form>
                        <a class="common_btn mt-4 w-100 text-center" href="check_out.html">checkout</a>
                        <a class="common_btn mt-1 w-100 text-center" href="product_grid_view.html"><i
                                class="fab fa-shopify"></i> go shop</a>
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
            $(".button-increment").click(function() {
                let input = $(this).siblings(".input-qty-cart");
                let rowId = input.data("rowid");
                let quantity = parseInt(input.val()) + 1;
                input.val(quantity);
                // $.ajax({
                //     url: "{{ route('update-product-quantity') }}",
                //     method: "POST",
                //     data: [
                //         "rowId": rowId,
                //         "quantity": quantity
                //     ],
                //     success: function(data) {

                //     },
                //     error: function(data) {

                //     }
                // })
                $.ajax({
                    url: "{{ route('update-product-quantity') }}",
                    method: "POST",
                    data: {
                        rowId: rowId,
                        quantity: quantity
                    },
                    success: function(data) {
                        // Xử lý khi request thành công
                        toastr.success(data.message);

                    },
                    error: function(xhr, status, error) {
                        // Xử lý khi có lỗi
                    }
                });
            })
        })
    </script>
@endpush
