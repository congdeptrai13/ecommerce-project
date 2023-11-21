<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        $setting = GeneralSetting::first();
        return view('admin.settings.index', compact('setting'));
    }

    public function Update(Request $request)
    {

        $request->validate([
            'site_name' => ['required', 'max:200'],
            'layout' => ['required'],
            'contact_email' => ['required', 'max:200', 'email'],
            'currency_name' => ['required', 'max:200'],
            'currency_icon' => ['required'],
            'timezone' => ['required'],
        ]);

        GeneralSetting::updateOrCreate(
            ['id' => "1"],
            [
                'site_name' => $request->site_name,
                'layout' =>  $request->layout,
                'contact_email' =>  $request->contact_email,
                'currency_name' =>  $request->currency_name,
                'currency_icon' =>  $request->currency_icon,
                'timezone' =>  $request->timezone,
            ]
        );
        Toastr('Created Successfully', 'success');
        return redirect()->back();
    }
}
