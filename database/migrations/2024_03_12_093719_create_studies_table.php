<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("studies", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("title");
            $table
                ->foreignUuid("user_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->jsonb("consent_form");
            $table->boolean("irb_approved")->default(false);
            $table->date("start_date")->nullable();
            $table->date("end_date");
            $table->jsonb("user_filters");
            $table
                ->boolean("is_active")
                ->virtualAs(
                    "start_date <= now() and end_date >= now() and irb_approved",
                );
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
        Schema::dropIfExists("studies");
    }
}
