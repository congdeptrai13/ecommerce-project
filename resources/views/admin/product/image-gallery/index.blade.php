@extends('admin.layout.master')
@section('title')
{{$settings->site_name}} || Admin Product Image gallery
@endsection
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product Image Gallery</h1>
        </div>

        <div class="section-body">
            <div class="mb-3">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">back</a>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product: : {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.product-images-gallery.store') }}" method="POST"
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
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Product Image Category</h4>
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
    @endpush
@endsection
