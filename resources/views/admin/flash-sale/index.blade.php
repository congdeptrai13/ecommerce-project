@extends('admin.layout.master')
@section('title')
{{$settings->site_name}} || Admin Flash Sale
@endsection
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4> Flash Sales End Date</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.flash-sale.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="inputState">Sale End Date</label>
                                    <input type="text" class="form-control datepicker" name="end_date"
                                        value="{{ $flashSale->end_date }}">
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Flash Sales Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.flash-sale.add-product') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Add Product</label>
                                    <select class="form-control select2" name="product">
                                        <option value="">select</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Show at home?</label>
                                            <select class="form-control" name="show_at_home">
                                                <option value="">select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="">select</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>All Flash Sales Product</h4>
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
                        url: "{{ route('admin.flash-sale.change-status') }}",
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

        {{-- change show-at-home --}}
        <script>
            $(document).ready(function() {
                $('body').on('click', '.change-show-at-home', function() {
                    let isChecked = $(this).is(':checked');
                    let id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('admin.flash-sale.change-show-at-home') }}",
                        method: 'PUT',
                        data: {
                            show_at_home: isChecked,
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
