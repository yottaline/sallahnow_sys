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
            $table->id();
            $table->foreignId('compatibility_id')->constrained('compatibilities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('models_id')->constrained('models')->cascadeOnDelete()->cascadeOnUpdate();
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