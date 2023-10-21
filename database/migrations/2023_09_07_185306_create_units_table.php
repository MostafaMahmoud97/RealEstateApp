<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("real_estate_id");
            $table->unsignedBigInteger("beneficiary_id")->default(0)->nullable();
            $table->unsignedBigInteger("purpose_property_id");
            $table->unsignedBigInteger("unit_status_id")->default(1);
            $table->unsignedBigInteger("beneficiary_status_id")->default(0);
            $table->double("price");
            $table->double("security_deposit")->default(0)->nullable();
            $table->string("unit_type");
            $table->string("unit_number");
            $table->integer("floor_number")->default(0)->nullable();
            $table->double("unit_area");
            $table->string("furnished")->default("")->nullable();
            $table->boolean("composite_kitchen_cabinets")->default(0)->nullable();
            $table->string("ac_type")->default("")->nullable();
            $table->integer("num_ac_units")->default(0)->nullable();
            $table->integer("electricity_meter_number")->default(0)->nullable();
            $table->double("electricity_meter_reading")->default(0)->nullable();
            $table->integer("gas_meter_number")->default(0)->nullable();
            $table->double("gas_meter_reading")->default(0)->nullable();
            $table->integer("water_meter_number")->default(0)->nullable();
            $table->double("water_meter_reading")->default(0)->nullable();
            $table->text("description")->nullable();
            $table->boolean("is_publish")->default(0)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
