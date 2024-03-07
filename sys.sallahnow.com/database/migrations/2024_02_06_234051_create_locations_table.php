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
        Schema::create('locations', function (Blueprint $table) {
            $table->integer('location_id')->autoIncrement();
            $table->string('location_name', 100);
            // $table->timestamps();
            $table->tinyInteger('location_type')->unsigned();
            $table->integer('location_parent')->unsigned();
            $table->tinyInteger('location_visible')->unsigned()->default('1');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};