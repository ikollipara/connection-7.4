<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("followers", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignUuid("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete();
            $table
                ->foreignUuid("follower_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(["user_id", "follower_id"]);
        });

        Schema::table("users", function (Blueprint $table) {
            $table->integer("followers_count")->default(0);
            $table->integer("following_count")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("followers");
        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("followers_count");
            $table->dropColumn("following_count");
        });
    }
}
