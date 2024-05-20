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
        Schema::create('market_product_views', function (Blueprint $table) {
            $table->bigInteger('view_id', true, true);
            $table->integer('view_customer', false, true);
            $table->bigInteger('view_product', false, true);
            $table->dateTime('view_cerated');
            // $table->timestamps();

            $table->foreign('view_customer')->references('customer_id')->on('customers')->cascadeOnDelete();
            $table->foreign('view_product')->references('product_id')->on('market_products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_product_views');
    }
};