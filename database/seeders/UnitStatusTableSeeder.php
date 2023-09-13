<?php

namespace Database\Seeders;

use App\Models\UnitStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UnitStatuses = [
            [
                "title_ar" => "جديد",
                "title_en" => "New"
            ],
            [
                "title_ar" => "قيد الانتظار",
                "title_en" => "Pending"
            ],
            [
                "title_ar" => "تاجر",
                "title_en" => "Seller"
            ],
            [
                "title_ar" => "مشتر",
                "title_en" => "Buyer"
            ],
            [
                "title_ar" => "المؤجر",
                "title_en" => "Lessor"
            ],
            [
                "title_ar" => "مستأجر",
                "title_en" => "Lessee"
            ],
        ];

        UnitStatus::truncate();
        foreach ($UnitStatuses as $unitStatus){
            UnitStatus::create($unitStatus);
        }
    }
}
