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
                    <h1>Payment success!</h1>
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
