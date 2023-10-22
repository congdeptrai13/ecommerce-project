<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::where('email', 'admin@gmail.com')->first();
        $vendor = new Vendor();
        $vendor->banner = 'uploads/123123.jpg';
        $vendor->phone = "123123123";
        $vendor->email = "admin@gmail.com";
        $vendor->address = "usa";
        $vendor->description = "shop description";
        $vendor->user_id = $user->id;
        $vendor->save();
    }
}
