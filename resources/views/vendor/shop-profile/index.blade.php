@extends('vendor.layouts.master')
@section('title')
{{$settings->site_name}} || Vendor Shop Profile
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
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> Shop profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{ route('vendor.shop-profile.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Preview</label>
                                        <br>
                                        <img width="200px" src="{{ asset($vendor->banner) }}" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label>Banner</label>
                                        <input type="file" class="form-control" name="banner">
                                    </div>
                                    <div class="form-group">
                                        <label>Shop Name</label>
                                        <input type="text" class="form-control" name="shop_name"
                                            value="{{ $vendor->shop_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $vendor->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ $vendor->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ $vendor->address }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="summernote" name="description">{{ $vendor->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>FB link</label>
                                        <input type="text" class="form-control" name="fb_link"
                                            value="{{ $vendor->fb_link }}">
                                    </div>
                                    <div class="form-group">
                                        <label>INSTA link</label>
                                        <input type="text" class="form-control" name="insta_link"
                                            value="{{ $vendor->insta_link }}">
                                    </div>
                                    <div class="form-group">
                                        <label>TW link</label>
                                        <input type="text" class="form-control" name="tw_link"
                                            value="{{ $vendor->tw_link }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
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
    <!--=============================
                                                                                                                                        DASHBOARD START
                                                                                                                                      ==============================-->
@endsection
