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
        Schema::create('post__likes', function (Blueprint $table) {
            $table->integer('like_id')->autoIncrement();
            $table->integer('like_tech');
            $table->integer('like_post');
            // $table->timestamps();

            $table->foreign('like_tech')->references('tech_id')->on('technicians')->cascadeOnDelete();
            $table->foreign('like_post')->references('post_id')->on('posts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post__likes');
    }
};