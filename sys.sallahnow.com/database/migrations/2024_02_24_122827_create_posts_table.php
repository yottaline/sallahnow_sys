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
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('post_id')->autoIncrement();
            $table->string('post_code', 12)->unique();
            $table->string('post_title', '255');
            $table->string('post_body', 2048);
            $table->string('post_file', 24)->nullable();
            $table->string('post_photo', 24)->nullable();
            $table->tinyInteger('post_type')->default('1');
            $table->integer('post_cost')->default('0');
            $table->boolean('post_allow_comments')->default('1');
            $table->boolean('post_archived')->default('0');
            $table->integer('post_archive_user')->nullable();
            $table->dateTime('post_archive_time')->nullable();
            $table->integer('post_views')->default('0');
            $table->integer('post_likes')->default('0');
            $table->tinyInteger('post_deleted')->default('0');
            $table->integer('post_delete_user')->nullable();
            $table->dateTime('post_delete_time')->nullable();
            $table->integer('post_create_user')->nullable();
            $table->integer('post_create_tech')->nullable();
            $table->dateTime('post_create_time');
            $table->integer('post_modify_user')->nullable();
            $table->dateTime('post_modify_time')->nullable();




            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
