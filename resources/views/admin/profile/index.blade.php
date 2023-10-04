@extends('admin.layout.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" action="{{ route('admin.profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div>
                                        <img width="100px" src="{{ asset(Auth::user()->image) }}" alt="">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="file" class="form-control" name='image'>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name='name'
                                            value="{{ Auth::user()->name }}">

                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name='email'
                                            value="{{ Auth::user()->email }}">

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card">
                        <form method="post" class="needs-validation" action="{{ route('admin.password.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Update Password</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Current Password</label>
                                        <input type="password" class="form-control" required="" name='password_current'>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" required="" name='new_password'>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" required=""
                                            name='new_password_confirmation'>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
