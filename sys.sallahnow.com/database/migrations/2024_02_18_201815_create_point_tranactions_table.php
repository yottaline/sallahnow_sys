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
            $table->integer('points_id')->autoIncrement();
            $table->integer('points_count');
            $table->tinyInteger('points_src');
            $table->integer('points_target');
            $table->tinyInteger('points_process');
            $table->integer('points_tech');
            // $table->foreignId('technician_id')->constrained('technicians')->cascadeOnDelete();
            // $table->timestamps();
            $table->date('points_register');

            $table->foreign('points_tech')->references('tech_id')->on('technicians');
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