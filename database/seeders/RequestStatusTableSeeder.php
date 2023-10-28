<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Statuses = [
            [
                "title_ar" => "قيد الانتظار",
                "title_en" => "Pending"
            ],
            [
                "title_ar" => "موافقة",
                "title_en" => "Approved"
            ],
            [
                "title_ar" => "غير متاح",
                "title_en" => "Not Available"
            ],
            [
                "title_ar" => "تحتجز",
                "title_en" => "Holding"
            ],
        ];

        RequestStatus::truncate();
        foreach ($Statuses as $status){
            RequestStatus::create($status);
        }
    }
}
