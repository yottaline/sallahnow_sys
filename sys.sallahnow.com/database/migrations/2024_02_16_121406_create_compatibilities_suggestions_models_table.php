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
            $table->bigIncrements('id');
            $table->foreignId('models_id')->constrained('models')->cascadeOnDelete();
            $table->foreignId('comp_sug_id')->constrained('compatibilities_suggestions')->cascadeOnDelete();
            $table->timestamps();
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