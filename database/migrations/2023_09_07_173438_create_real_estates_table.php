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
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("building_type_id");
            $table->unsignedBigInteger("building_type_use_id");
            $table->string("national_address");
            $table->double("lat");
            $table->double("lon");
            $table->integer("number_floors")->default(0)->nullable();
            $table->integer("number_units")->default(0)->nullable();
            $table->integer("number_parking_lots")->default(0)->nullable();

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
        Schema::dropIfExists('real_estates');
    }
};
