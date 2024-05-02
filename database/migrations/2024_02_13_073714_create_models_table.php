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
        Schema::create('models', function (Blueprint $table) {
            $table->integer('model_id', true, true);
            $table->string('model_name', 24);
            $table->string('model_photo', 120);
            $table->string('model_url', 120);
            $table->integer('model_brand')->unsigned();
            $table->boolean('model_visible')->default(1)->unsigned();
            // $table->timestamps();

            $table->foreign('model_brand')->references('brand_id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};