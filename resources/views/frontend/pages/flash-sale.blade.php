@extends('frontend.layouts.master')
@section('title')
    {{ $settings->site_name }} || Flash Sale
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
                        <h4>Flash Sale</h4>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="javascript:;">offer details</a></li>
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
                                                                                                            DAILY DEALS DETAILS START
                                                                                                        ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="wsus__offer_details_area">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{ asset('frontend/images/offer_banner_2.png') }}" alt="offrt img"
                                class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>apple watch</p>
                                <span>up 50% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="wsus__offer_details_banner">
                            <img src="{{ asset('frontend/images/offer_banner_3.png') }}" alt="offrt img"
                                class="img-fluid w-100">
                            <div class="wsus__offer_details_banner_text">
                                <p>xiaomi power bank</p>
                                <span>up 37% 0ff</span>
                                <p>for all poduct</p>
                                <p><b>today only</b></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header rounded-0">
                            <h3>flash sale</h3>
                            <div class="wsus__offer_countdown">
                                <span class="end_text">ends time :</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($flashSaleItem as $item)
                        <?php
                        $product = App\Models\Product::find($item->product_id);
                        ?>
                        <div class="col-xl-3 col-sm-6 col-lg-4">
                            <div class="wsus__product_item">
                                <span class="wsus__new">{{ productType($product->product_type) }}</span>
                                @if (checkDiscount($product))
                                    <span
                                        class="wsus__minus">-{{ calculateDiscountPercent($product->price, $product->offer_price) }}%
                                    </span>
                                @endif
                                <a class="wsus__pro_link" href="{{ route('product-detail', $product->slug) }}">
                                    <img src="{{ asset($product->thumb_image) }}" alt="product"
                                        class="img-fluid w-100 img_1" />
                                    @if (isset($product->productImageGallery[0]->image))
                                        <img src="{{ asset($product->productImageGallery[0]->image) }}" alt="product"
                                            class="img-fluid w-100 img_2" />
                                    @else
                                        <img src="{{ asset($product->thumb_image) }}" alt="product"
                                            class="img-fluid w-100 img_2" />
                                    @endif

                                </a>
                                <ul class="wsus__single_pro_icon">
                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                class="far fa-eye"></i></a></li>
                                    <li><a href="#"><i class="far fa-heart"></i></a></li>
                                    <li><a href="#"><i class="far fa-random"></i></a>
                                </ul>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">{{ $product->category->name }} </a>
                                    <p class="wsus__pro_rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>(133 review)</span>
                                    </p>
                                    <a class="wsus__pro_name"
                                        href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                                    @if (checkDiscount($product))
                                        <p class="wsus__price">{{ $settings->currency_icon }}{{ $product->offer_price }}
                                            <del>${{ $product->price }}</del>
                                        </p>
                                    @else
                                        <p class="wsus__price">{{ $settings->currency_icon }}{{ $product->price }}</p>
                                    @endif
                                    <form class="shopping-cart-form">
                                        <div class="wsus__selectbox d-none">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="row">
                                                @foreach ($product->variant as $variant)
                                                    <div class="col-xl-6 col-sm-6">
                                                        <h5 class="mb-2">{{ $variant->name }}</h5>
                                                        <select class="select_2" name="variants_Items[]">
                                                            @foreach ($variant->variantItem as $item)
                                                                <option {{ $item->is_default === 1 ? 'selected' : '' }}
                                                                    value="{{ $item->id }}">
                                                                    {{ $item->name }} (${{ $item->price }})</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="wsus__quentity d-none">
                                            <h5>quantity :</h5>
                                            <div class="select_number">
                                                <input class="number_area" type="text" min="1" max="100"
                                                    value="1" name="qty" />
                                            </div>
                                        </div>
                                        <input class="number_area" hidden type="text" min="1" max="100"
                                            value="1" name="qty" />
                                        <button type="submit" class="add_cart" href="#">add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($flashSaleItem->hasPages())
                    <div class="mt-5">
                        {{ $flashSaleItem->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!--============================
                                                                                                            DAILY DEALS DETAILS END
                                                                                                        ==============================-->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            simplyCountdown('.simply-countdown-one', {
                year: {{ date('Y', strtotime($flashSale->end_date)) }},
                month: {{ date('m', strtotime($flashSale->end_date)) }},
                day: {{ date('d', strtotime($flashSale->end_date)) }},
                enableUtc: true
            });
        })
    </script>
@endpush
