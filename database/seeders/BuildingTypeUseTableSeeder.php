<?php

namespace Database\Seeders;

use App\Models\BuildingTypeUse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingTypeUseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $BuildingTypeUses = [
            [
                "title_ar" => "تجارى",
                "title_en" => "Commercial"
            ],
            [
                "title_ar" => "سكنى",
                "title_en" => "Residential"
            ]
        ];

        BuildingTypeUse::truncate();
        foreach ($BuildingTypeUses as $buildingTypeUse){
            BuildingTypeUse::create($buildingTypeUse);
        }
    }
}
