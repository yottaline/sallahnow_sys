<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compatibilities_suggestions', function (Blueprint $table) {
            $table->integer('sugg_id', true , true);
            $table->tinyInteger('sugg_status')->default('0')->unsigned();
            $table->integer('sugg_points')->unsigned();
            $table->string('sugg_act_note');
            $table->integer('sugg_category')->unsigned();
            $table->integer('sugg_tech')->unsigned();
            $table->integer('sugg_act_by')->unsigned();
            // $table->timestamps();
            $table->dateTime('sugg_act_time');

            $table->foreign('sugg_category')->references('category_id')->on('compatibility_categories');
            $table->foreign('sugg_tech')->references('tech_id')->on('technicians');
            $table->foreign('sugg_act_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibilities_suggestions');
    }
};