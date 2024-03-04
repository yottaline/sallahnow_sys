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
        Schema::create('courses', function (Blueprint $table) {
            $table->integer('course_id')->autoIncrement();
            $table->string('course_code', 12);
            $table->string('course_title', 255);
            $table->string('course_body', 2048);
            $table->string('course_file', 24)->nullable();
            $table->string('course_photo', 24)->nullable();
            $table->tinyInteger('course_type')->default('1');
            $table->decimal('course_cost', 12,2)->default('0');
            $table->boolean('course_archived')->default('0');
            $table->integer('course_archive_user')->nullable();
            $table->dateTime('course_archive_time')->nullable();
            $table->boolean('course_deleted')->default('0');
            $table->integer('course_delete_user')->nullable();
            $table->dateTime('course_delete_time')->nullable();
            $table->integer('course_views')->default('0');
            $table->integer('course_requests')->default('0');
            $table->integer('course_create_user');
            $table->dateTime('course_create_time');
            $table->integer('course_modify_user')->nullable();
            $table->dateTime('course_modify_time')->nullable();

            // $table->timestamps();
            $table->foreign('course_create_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};