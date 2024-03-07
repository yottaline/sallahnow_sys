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
        Schema::create('support_categories', function (Blueprint $table) {
            $table->integer('category_id', true, true);
            $table->string('category_name', 2048);
            $table->integer('category_cost')->default('1')->unsigned();
            $table->tinyInteger('category_visible')->default('1')->unsigned();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_categories');
    }
};