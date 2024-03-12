<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPreserviceAndYearsOfExperienceToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->unsignedTinyInteger("years_of_experience")->default(0);
            $table->boolean("is_preservice")->default(false);

            $table->index("is_preservice");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("years_of_experience");
            $table->dropColumn("is_preservice");
            $table->dropIndex("users_is_preservice_index");
        });
    }
}
