@extends('vendor.layouts.master')
@section('title')
    {{ $settings->site_name }} || Vendor Product Variant
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
                        <h3><i class="far fa-user"></i> Product Variant</h3>

                        <div class="wsus__dashboard_profile">

                            <div class="create_button">
                                <div>
                                    <a href="{{ route('vendor.products.index') }}" class="btn btn-primary">back</a>
                                </div>
                                <a href="{{ route('vendor.product-variant.create', ['product' => $product->id]) }}"
                                    class="btn btn-primary">Create
                                    Variant</a>
                            </div>
                            <h5>Product: {{ $product->name }}</h5>

                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script>
            $(document).ready(function() {
                $('body').on('click', '.change-status', function() {
                    let isChecked = $(this).is(':checked');
                    let id = $(this).data('id');

                    $.ajax({
                        url: "{{ route('vendor.product-variant.change-status') }}",
                        method: 'PUT',
                        data: {
                            status: isChecked,
                            id: id
                        },
                        success: function(data) {
                            toastr.success(data.message);
                        },
                        error: function(xhr, status, error) {
                            console.log(error)
                        }
                    })
                })
            })
        </script>
    @endpush
@endsection
