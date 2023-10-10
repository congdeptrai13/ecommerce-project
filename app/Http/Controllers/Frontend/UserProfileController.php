<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        return view("frontend.dashboard.profile");
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'email' => ['required', 'unique:users,email,' . Auth::user()->id],
            'image' => ["file", 'max:2048']
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

    public function updateProfilePassword(Request $request)
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
