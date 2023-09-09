<?php

namespace Database\Seeders;

use App\Models\TypeIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeIdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $TypeIds = [
            [
                "en_title" => "National Identity",
                "ar_title" => "الهوية الوطنية"
            ],
            [
                "en_title" => "Residence",
                "ar_title" => "الإقامة"
            ],
            [
                "en_title" => "Civil Registry",
                "ar_title" => "السجل المدني"
            ],
        ];

        TypeIdentity::truncate();
        foreach ($TypeIds as $typeId){
            TypeIdentity::create($typeId);
        }
    }
}
