<?php

namespace Database\Seeders;

use App\Models\PurposeProperty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurposePropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $PurposeProperties = [
            [
                "title_ar" => "ايجار",
                "title_en" => "Rent"
            ],
            [
                "title_ar" => "بيع",
                "title_en" => "Sale"
            ]
        ];

        PurposeProperty::truncate();
        foreach ($PurposeProperties as $purposeProperty){
            PurposeProperty::create($purposeProperty);
        }
    }
}
