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
            $table->id();
            $table->string('name',120);
            $table->string('email',120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile',24);
            $table->string('password', 255);
            $table->boolean('active')->default(1);
            $table->foreignId('user_group_id')->constrained('user_groups');
            // $table->date('user_login');
            $table->rememberToken();;
            $table->timestamps();
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