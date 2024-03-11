@extends('vendor.layouts.master')
@section('title')
{{$settings->site_name}} || Create Vendor Product Variant Item
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
                        <h3><i class="far fa-user"></i> Create Variant Item</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{ route('vendor.product-variant-item.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{ $product->id }}">
                                    <input type="hidden" name="variantId" value="{{ $variant->id }}">
                                    <div class="form-group">
                                        <label>Variant Name</label>
                                        <input type="text" class="form-control" name="variant_name"
                                            value="{{ $product->name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Item Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label>Price <code>(Set 0 for make it free)</code></label>
                                        <input type="text" class="form-control" name="price">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputState">Is Default</label>
                                        <select id="inputState" class="form-control" name="is_default">
                                            <option selected="" value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputState">Status</label>
                                        <select id="inputState" class="form-control" name="status">
                                            <option selected="" value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Create</button>
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
@endsection
