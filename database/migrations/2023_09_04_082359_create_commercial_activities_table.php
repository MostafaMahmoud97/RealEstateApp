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
        Schema::create('commercial_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("company_name");
            $table->string("organization_type");
            $table->string("cr_number");
            $table->timestamp("cr_date");
            $table->string("unified_number");
            $table->string("issued_by")->default("")->nullable();
            $table->string("licence_number")->default(0)->nullable();
            $table->string("licence_issue_place")->default("")->nullable();
            $table->boolean("modify_business")->comment("0->no , 1->yes")->default(0)->nullable();

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
        Schema::dropIfExists('commercial_activities');
    }
};
