@extends('admin.layout.master')
@section('title')
{{$settings->site_name}} || Admin Brand
@endsection
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Brand</h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Brand</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Preview</label>
                                    <img src="{{ asset($brand->logo) }}" alt="" width="100px">
                                </div>
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" class="form-control" name="logo">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $brand->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputState">Is Featured</label>
                                    <select id="inputState" class="form-control" name="is_featured">
                                        <option>Select</option>
                                        <option {{ $brand->is_featured === 1 ? 'selected' : '' }} value="1">Yes
                                        </option>
                                        <option {{ $brand->is_featured === 0 ? 'selected' : '' }} value="0">No</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option {{ $brand->is_featured === 1 ? 'selected' : '' }} selected=""
                                            value="1">Active</option>
                                        <option {{ $brand->is_featured === 0 ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
