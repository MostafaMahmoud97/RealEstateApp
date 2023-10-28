<?php

namespace Database\Seeders;

use App\Models\RentPaymentCycle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RentPaymentCycleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Cycles = [
            [
                "title_ar" => "شهرى",
                "title_en" => "Monthly"
            ],
            [
                "title_ar" => "ربع سنوى",
                "title_en" => "Quarterly"
            ],
            [
                "title_ar" => "نصف سنوى",
                "title_en" => "Semi-annually"
            ],
            [
                "title_ar" => "سنوى",
                "title_en" => "Annually"
            ],
        ];

        RentPaymentCycle::truncate();
        foreach ($Cycles as $cycle){
            RentPaymentCycle::create($cycle);
        }
    }
}
