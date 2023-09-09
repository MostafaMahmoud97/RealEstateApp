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
        Schema::create('commercial_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("unit_id");
            $table->double("unit_length")->default(0)->nullable();
            $table->string("unit_direction")->default("")->nullable();
            $table->integer("number_parking_lots")->default(0)->nullable();
            $table->double("sign_area")->default(0)->nullable();
            $table->string("sign_location")->default("")->nullable();
            $table->text("special_sign_specification")->default("")->nullable();
            $table->bigInteger("insurance_policy_number")->default(0)->nullable();
            $table->boolean("mezzanine")->default(0)->nullable();
            $table->boolean("unit_finishing")->default(0)->nullable();

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
        Schema::dropIfExists('commercial_infos');
    }
};
