<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCollectionViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("post_collection_views", function (Blueprint $table) {
            $table
                ->foreignUuid("user_id")
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignUuid("post_collection_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->primary(["user_id", "post_collection_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("post_collection_views");
    }
}
