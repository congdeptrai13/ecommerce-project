<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function profile()
    {
        return view('admin.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'unique:users,email,' . Auth::user()->id],
            'image' => ["file"]
        ]);
        $user = Auth::user();
        if ($request->hasFile('image')) {
            if (!is_null($user->image)) {
                @unlink($user->image);
            }
            $image = $request->image;
            $nameImage = rand() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $nameImage);
            $path = 'uploads/' . $nameImage;
            $user->image = $path;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        toastr()->success("Profile Updated Successfully");
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_current' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:6', 'max:32']
        ]);

        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        toastr()->success("Profile Password Updated Successfully");

        return redirect()->back();
    }
}
