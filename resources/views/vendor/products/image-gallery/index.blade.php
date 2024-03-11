@extends('vendor.layouts.master')
@section('title')
    {{ $settings->site_name }} || Vendor Product Image Gallery
@endsection
@section('content')
    <!--=============================
                                                                                                                                                                                                                                                    DASHBOARD START
                                                                                                                                                                                                                                                  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('vendor.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="mb-3">
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-primary">back</a>
                    </div>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> Product: {{ $product->name }}</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{ route('vendor.product-images-gallery.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Image <code>(Upload Multi Image)</code></label>
                                        {{-- <br> --}}
                                        <input type="file" name="image[]" class="form-control" multiple>
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create</button>

                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="dashboard_content mt-2 mt-md-0" style="margin-top: 40px !important;">
                        <h3><i class="far fa-user"></i> Products Image</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
                            </div>
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
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
@endsection
