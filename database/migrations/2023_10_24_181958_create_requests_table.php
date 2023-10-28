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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("unit_id");
            $table->unsignedBigInteger("rent_payment_cycle_id");
            $table->unsignedBigInteger("request_states_id");
            $table->timestamp("contract_sealing_date")->nullable();
            $table->integer("number_years");
            $table->timestamp("tenancy_end_date")->nullable();
            $table->double("annual_rent");
            $table->double("regular_rent_payment");
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
        Schema::dropIfExists('requests');
    }
};
