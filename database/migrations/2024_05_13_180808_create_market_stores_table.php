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
        Schema::create('market_stores', function (Blueprint $table) {
            $table->integer('store_id', true, true);
            $table->string('store_name', 120);
            $table->string('store_code', 12);
            $table->string('store_official_name', 120);
            $table->string('store_cr', 20);
            $table->string('store_cr_photo', 64)->nullable();
            $table->string('store_tax', 24);
            $table->string('store_phone', 24);
            $table->string('store_mobile', 24);
            $table->integer('store_country', false, true);
            $table->integer('store_state', false, true);
            $table->integer('store_city', false, true);
            $table->integer('store_area', false, true);
            $table->string('store_address', 1024);
            $table->boolean('store_status')->default('1');
            $table->dateTime('store_cerated');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_stores');
    }
};
