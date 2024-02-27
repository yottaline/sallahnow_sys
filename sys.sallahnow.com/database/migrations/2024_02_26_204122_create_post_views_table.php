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
        Schema::create('post_views', function (Blueprint $table) {
            $table->integer('view_id')->autoIncrement();
            $table->string('view_device', 200)->nullable();
            $table->integer('view_tech');
            $table->integer('view_post');
            // $table->timestamps();

            $table->foreign('view_tech')->references('tech_id')->on('technicians');
            $table->foreign('view_post')->references('post_id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};