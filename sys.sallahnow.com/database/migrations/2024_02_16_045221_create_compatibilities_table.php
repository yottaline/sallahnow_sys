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
        Schema::create('compatibilities', function (Blueprint $table) {
            $table->integer('compat_id', true ,true);
            $table->string('compat_code', 9);
            $table->string('compat_part',120);
            $table->integer('compat_category')->unsigned();
            $table->integer('compat_board', false, true)->nullable();
            // $table->timestamps();

            $table->foreign('compat_category')->references('category_id')->on('compatibility_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibilities');
    }
};
