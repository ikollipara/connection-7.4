<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFullTextIndexToPostCollectionTitles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("post_collections", function (Blueprint $table) {
            $table->fullText("title");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("post_collections", function (Blueprint $table) {
            $table->dropFullText("title");
        });
    }
}
