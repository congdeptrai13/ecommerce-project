@extends('vendor.layouts.master')

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
                                <form action="{{ route('vendor.product-variant-item.update', $variantItem->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label>Variant Name</label>
                                        <input type="text" class="form-control" name="variant_name"
                                            value="{{ $variantItem->variant->name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Item Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $variantItem->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Price <code>(Set 0 for make it free)</code></label>
                                        <input type="text" class="form-control" name="price"
                                            value="{{ $variantItem->price }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputState">Is Default</label>
                                        <select id="inputState" class="form-control" name="is_default">
                                            <option {{ $variantItem->is_default === 1 ? 'selected' : '' }} selected=""
                                                value="1">Yes</option>
                                            <option {{ $variantItem->is_default === 0 ? 'selected' : '' }} value="0">No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputState">Status</label>
                                        <select id="inputState" class="form-control" name="status">
                                            <option {{ $variantItem->status === 1 ? 'selected' : '' }} selected=""
                                                value="1">Active</option>
                                            <option {{ $variantItem->status === 0 ? 'selected' : '' }} value="0">
                                                Inactive</option>
                                        </select>
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
@endsection
