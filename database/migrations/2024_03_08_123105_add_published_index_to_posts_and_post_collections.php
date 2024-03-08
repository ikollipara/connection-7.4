<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishedIndexToPostsAndPostCollections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("posts", function (Blueprint $table) {
            $table->index("published");
        });
        Schema::table("post_collections", function (Blueprint $table) {
            $table->index("published");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("posts", function (Blueprint $table) {
            $table->dropIndex("posts_published_index");
        });

        Schema::table("post_collections", function (Blueprint $table) {
            $table->dropIndex("post_collections_published_index");
        });
    }
}
