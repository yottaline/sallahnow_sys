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
        Schema::create('market_subcategories', function (Blueprint $table) {
            $table->integer('subcategory_id', true, true);
            $table->string('subcategory_name', 1024);
            $table->integer('subcategory_cat', false, true);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_subcategories');
    }
};