<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Admin = Admin::create([
            'name' => "zoka mahmoud",
            'phone' => '01110347546',
            'email' => 'zoka@gmail.com',
            'password' => Hash::make('123456789'),
            'job_title' => "admin",
            'is_active' => 1
        ]);
    }
}
