@extends('frontend.dashboard.layouts.master')

@section('content')
    <!--=============================
                                                            DASHBOARD START
                                                          ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('frontend.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <h4>Update information</h4>
                                <form method="POST" action="{{ route('user.profile.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="col-xl-2 col-sm-6 col-md-6">
                                        <div class="wsus__dash_pro_img">
                                            <img src="{{ isset(Auth::user()->image) ? asset(Auth::user()->image) : asset('frontend/images/ts-2.jpg') }}"
                                                alt="img" class="img-fluid w-100">
                                            <input type="file" name="image" id="image">
                                        </div>
                                    </div>
                                    <div class="col-xl-12" style="margin-top: 20px;">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-user-tie"></i>
                                                    <input type="text" placeholder="Name" name="name"
                                                        value="{{ Auth::user()->name }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fal fa-envelope-open"></i>
                                                    <input type="email" placeholder="Email" name="email"
                                                        value="{{ Auth::user()->email }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <button class="common_btn mb-4 mt-2" type="submit">upload</button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('user.profile.update.password') }}">
                                    @csrf
                                    <div class="wsus__dash_pass_change mt-2">
                                        <h4>Update Password</h4>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-unlock-alt"></i>
                                                    <input type="password" placeholder="Current Password"
                                                        name="password_current">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-lock-alt"></i>
                                                    <input type="password" placeholder="New Password" name="new_password">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-lock-alt"></i>
                                                    <input type="password" placeholder="Confirm Password"
                                                        name="new_password_confirmation">
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <button class="common_btn" type="submit">upload</button>
                                            </div>
                                        </div>
                                    </div>
                                    <form>
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
