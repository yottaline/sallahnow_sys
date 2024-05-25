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
        Schema::create('market_product_photos', function (Blueprint $table) {
            $table->bigInteger('photo_id', true, true);
            $table->string('photo_file', 64);
            $table->bigInteger('photo_product', false, true);
            $table->dateTime('photo_cerated');

            $table->foreign('photo_product')->references('product_id')->on('market_products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_product_photos');
    }
};