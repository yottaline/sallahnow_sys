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
        Schema::create('market_order_items', function (Blueprint $table) {
            $table->bigInteger('orderItem_id', true, true);
            $table->integer('orderItem_order', false, true);
            $table->bigInteger('orderItem_product', false, true);
            $table->decimal('orderItem_productPrice', 12, 2);
            $table->decimal('orderItem_subtotal', 12, 2);
            $table->decimal('orderItem_disc', 6, 2);
            $table->decimal('orderItem_total', 12, 2);
            $table->integer('orderItem_qty', false, true);

            $table->foreign('orderItem_order')->references('order_id')->on('market_orders')->cascadeOnDelete();
            $table->foreign('orderItem_product')->references('product_id')->on('market_products')->cascadeOnDelete();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_order_items');
    }
};