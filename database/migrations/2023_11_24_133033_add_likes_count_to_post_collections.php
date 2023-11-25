<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesCountToPostCollections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_collections', function (Blueprint $table) {
            $table->unsignedBigInteger('likes_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_collections', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });
    }
}
