<?php

namespace Database\Seeders;

use App\Models\BuildingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $BuildingTypes = [
            [
                "title_ar" => "أرض",
                "title_en" => "Land"
            ],
            [
                "title_ar" => "محل تجاري",
                "title_en" => "Market"
            ],
            [
                "title_ar" => "عمارة",
                "title_en" => "Architecture"
            ],
            [
                "title_ar" => "شقة",
                "title_en" => "Flat"
            ],
            [
                "title_ar" => "فيلا",
                "title_en" => "Villa"
            ],
            [
                "title_ar" => "معرض",
                "title_en" => "Exhibition"
            ],
            [
                "title_ar" => "مستودع",
                "title_en" => "Storehouse"
            ],
            [
                "title_ar" => "محطة",
                "title_en" => "Station"
            ],
            [
                "title_ar" => "مجمع",
                "title_en" => "Complex"
            ],

        ];

        BuildingType::truncate();
        foreach ($BuildingTypes as $buildingType){
            BuildingType::create($buildingType);
        };
    }
}
