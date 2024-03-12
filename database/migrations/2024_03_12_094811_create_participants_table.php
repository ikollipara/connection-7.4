<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("participants", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignUuid("study_id")
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignUuid("user_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(["user_id", "study_id"]);
            $table->index("study_id");
            $table->index("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("participants");
    }
}
