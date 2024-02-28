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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('user_name',120);
            $table->string('user_email',120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_mobile',24);
            $table->string('user_password', 255);
            $table->integer('user_group');
            $table->boolean('user_active')->default(1);
            // $table->date('user_login');
            $table->date('user_create');
            $table->rememberToken();;
            // $table->timestamps();

            $table->foreign('user_group')->references('ugroup_id')->on('user_groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};