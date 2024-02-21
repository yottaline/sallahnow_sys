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
        Schema::create('point_tranactions', function (Blueprint $table) {
            $table->id();
            $table->integer('points_count');
            $table->tinyInteger('points_src');
            $table->integer('points_target');
            $table->tinyInteger('points_process');
            $table->foreignId('technician_id')->constrained('technicians')->cascadeOnDelete();
            $table->timestamps();
            // $table->date('points_register');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_tranactions');
    }
};