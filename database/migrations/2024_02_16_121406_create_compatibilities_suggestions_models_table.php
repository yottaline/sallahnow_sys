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
        Schema::create('compatibilities_suggestions_models', function (Blueprint $table) {
            $table->integer('csugg_id', true, true);
            $table->integer('sugg_src')->unsigned();
            $table->integer('sugg_model')->unsigned();
            // $table->timestamps();

            $table->foreign('sugg_src')->references('sugg_id')->on('compatibilities_suggestions');
            $table->foreign('sugg_model')->references('model_id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibilities_suggestions_models');
    }
};