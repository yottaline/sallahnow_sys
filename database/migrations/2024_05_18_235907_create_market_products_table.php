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
        Schema::create('market_products', function (Blueprint $table) {
            $table->bigInteger('product_id', true, true);
            $table->string('product_code', 24);
            $table->string('product_name', 1024);
            $table->integer('product_store', false, true);
            $table->integer('product_category', false, true);
            $table->integer('product_subcategory', false, true);
            $table->bigInteger('product_photo', false, true);
            $table->text('product_desc');
            $table->decimal('product_price', 9, 2);
            $table->decimal('product_disc', 9,2);
            $table->integer('product_views', false, true);
            $table->boolean('product_show')->default('1');
            $table->boolean('product_delete')->default('0');
            $table->dateTime('product_cerated');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_products');
    }
};