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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->integer('comment_id')->autoIncrement();
            $table->integer('comment_post');
            $table->string('comment_context', 2048);
            $table->boolean('comment_visible')->nullable();
            $table->integer('comment_review')->nullable();
            $table->integer('comment_parent')->nullable();
            $table->integer('comment_user')->nullable();
            $table->integer('comment_tech')->nullable();
            $table->dateTime('comment_create');
            // $table->timestamps();

            $table->foreign('comment_post')->references('post_id')->on('posts');
            $table->foreign('comment_user')->references('id')->on('users');
            $table->foreign('comment_tech')->references('tech_id')->on('technicians');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};