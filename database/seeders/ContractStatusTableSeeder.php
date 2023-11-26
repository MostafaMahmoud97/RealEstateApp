<?php

namespace Database\Seeders;

use App\Models\ContractStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractStatusTableSeeder extends Seeder
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
                "title_ar" => "في انتظار التسجيل",
                "title_en" => "pending register"
            ],
            [
                "title_ar" => "يعالج",
                "title_en" => "processing"
            ],
            [
                "title_ar" => "تم تحميلها على الأطراف",
                "title_en" => "uploaded to parties"
            ],
            [
                "title_ar" => "الغاء التوثيق",
                "title_en" => "cancel contract"
            ]
        ];

        ContractStatus::truncate();
        foreach ($Statuses as $status){
            ContractStatus::create($status);
        }

    }
}
