@extends('frontend.layouts.master')
@section('title')
    {{ $settings->site_name }} || Reset Password
@endsection
@section('content')
    <!--============================
                                    BREADCRUMB START
                                ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>change password</h4>
                        <ul>
                            <li><a href="#">login</a></li>
                            <li><a href="#">change password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                    BREADCRUMB END
                                ==============================-->


    <!--============================
                                    CHANGE PASSWORD START
                                ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-md-10 col-lg-7 m-auto">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="wsus__change_password">
                            <h4>reset password</h4>
                            <div class="wsus__single_pass">
                                <label>current password</label>
                                <input id="email" type="email" name="email"
                                    value="{{ old('email', $request->email) }}">
                            </div>
                            <div class="wsus__single_pass">
                                <label>new password</label>
                                <input id="password" type="password" name="password" placeholder="New Password">
                            </div>
                            <div class="wsus__single_pass">
                                <label>confirm password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    placeholder="Confirm Password">
                            </div>
                            <button class="common_btn" type="submit">submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                    CHANGE PASSWORD END
                                ==============================-->
@endsection
