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
        Schema::create('market_retailers', function (Blueprint $table) {
            $table->integer('retailer_id', true, true);
            $table->string('retailer_name', 100);
            $table->string('retailer_email', 120);
            $table->string('retailer_phone', 24);
            $table->string('retailer_password', 250);
            $table->integer('retailer_store', false, true);
            $table->boolean('retailer_admin')->default('0');
            $table->boolean('retailer_active')->default('1');
            $table->dateTime('retailer_approved')->nullable();
            $table->integer('retailer_approved_by', false, true)->nullable();
            $table->dateTime('retailer_register');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_retailers');
    }
};
