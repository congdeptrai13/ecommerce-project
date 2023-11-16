@extends('admin.layout.master')

@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>All Product Variant</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="mb-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">back</a>
                        </div>
                        <div class="card-header">
                            <h4>Product Variant: {{ $product->name }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.product-variant.create', ['product' => $product->id]) }}"
                                    class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
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
                        url: "{{ route('admin.product-variant.change-status') }}",
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
