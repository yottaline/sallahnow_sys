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
        Schema::create('market_orders', function (Blueprint $table) {
            $table->integer('order_id', true, true);
            $table->string('order_code', 12);
            $table->integer('order_customer', false, true);
            $table->string('order_note', 1024);
            $table->tinyInteger('order_status', false, true)->comment('1:DRAFT, 2:CANCELED, 3:PLACED, 4:APPROVED, 5:DELIVERED');
            $table->decimal('order_subtotal', 12, 2);
            $table->decimal('order_disc', 6, 2);
            $table->decimal('order_totaldisc', 12, 2);
            $table->decimal('order_total', 12, 2);
            $table->dateTime('order_create');
            $table->dateTime('order_exec')->nullable();
            $table->dateTime('order_approved')->nullable();
            $table->dateTime('order_delivered')->nullable();
            // $table->timestamps();
            $table->foreign('order_customer')->references('customer_id')->on('customers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_orders');
    }
};