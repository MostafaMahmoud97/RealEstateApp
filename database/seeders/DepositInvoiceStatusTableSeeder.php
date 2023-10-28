<?php

namespace Database\Seeders;

use App\Models\DepositInvoiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepositInvoiceStatusTableSeeder extends Seeder
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
                "title_ar" => "غير مدفوعة",
                "title_en" => "Not Paid"
            ],
            [
                "title_ar" => "مدفوع",
                "title_en" => "Paid"
            ],
            [
                "title_ar" => "ألغيت",
                "title_en" => "Canceled"
            ],
        ];

        DepositInvoiceStatus::truncate();
        foreach ($Statuses as $status){
            DepositInvoiceStatus::create($status);
        }
    }
}
