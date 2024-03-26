@extends('admin.layout.master')
@section('title')
    {{ $settings->site_name }} || Admin General Settings
@endsection
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>JavaScript Behavior</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active" id="list-home-list"
                                            data-toggle="list" href="#list-home" role="tab">Paypal</a>
                                        <a class="list-group-item list-group-item-action" id="list-stripe-list"
                                            data-toggle="list" href="#list-stripe" role="tab">Stripe</a>
                                        <a class="list-group-item list-group-item-action" id="list-razorpay-list"
                                            data-toggle="list" href="#list-razorpay" role="tab">RazorPay</a>
                                        <a class="list-group-item list-group-item-action" id="list-settings-list"
                                            data-toggle="list" href="#list-settings" role="tab">Settings</a>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content" id="nav-tabContent">
                                        @include('admin.payment-settings.sections.paypal-setting')
                                        @include('admin.payment-settings.sections.stripe-setting')
                                        @include('admin.payment-settings.sections.razorpay-setting')
                                        {{-- <div class="tab-pane fade" id="list-stripe" role="tabpanel"
                                            aria-labelledby="list-stripe-list">
                                            Deserunt cupidatat anim ullamco ut dolor anim sint nulla amet incididunt tempor
                                            ad ut pariatur officia culpa laboris occaecat. Dolor in nisi aliquip in non
                                            magna amet nisi sed commodo proident anim deserunt nulla veniam occaecat
                                            reprehenderit esse ut eu culpa fugiat nostrud pariatur adipisicing incididunt
                                            consequat nisi non amet.
                                        </div> --}}

                                        <div class="tab-pane fade" id="list-settings" role="tabpanel"
                                            aria-labelledby="list-settings-list">
                                            Lorem ipsum culpa in ad velit dolore anim labore incididunt do aliqua sit veniam
                                            commodo elit dolore do labore occaecat laborum sed quis proident fugiat sunt
                                            pariatur. Cupidatat ut fugiat anim ut dolore excepteur ut voluptate dolore
                                            excepteur mollit commodo.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
