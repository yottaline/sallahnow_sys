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
        Schema::create('technician_ads', function (Blueprint $table) {
            $table->tinyInteger('ads_id')->autoIncrement();
            $table->string('ads_title', 255);
            $table->string('ads_photo', 64);
            $table->string('ads_body', 4096);
            $table->string('ads_url', 255);
            $table->dateTime('ads_start');
            $table->dateTime('ads_end');
            $table->integer('ads_create_user');
            $table->dateTime('ads_create_time');

            $table->foreign('ads_create_user')->references('id')->on('users');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_ads');
    }
};