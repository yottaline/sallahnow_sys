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
        Schema::create('centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owner');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('center_cr')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('tel')->nullable();
            $table->string('center_whatsapp')->nullable();
            $table->string('center_tax')->nullable();
            $table->foreignId('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->integer('area_id');
            $table->string('address');
            $table->tinyInteger('rate')->nullable();
            $table->integer('create_by')->nullable();
            $table->date('modify')->nullable();
            $table->integer('modify_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};