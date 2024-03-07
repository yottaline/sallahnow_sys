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
        Schema::create('compatibility_models', function (Blueprint $table) {
            $table->integer('compatible_id', true ,true);
            $table->integer('compatible_src')->unsigned();
            $table->integer('compatible_model')->unsigned();

            $table->foreign('compatible_src')->references('compat_id')->on('compatibilities');
            $table->foreign('compatible_model')->references('model_id')->on('models');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibility__models');
    }
};