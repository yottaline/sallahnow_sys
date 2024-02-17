<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('center')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('tech_email_verefied')->nullable();
            $table->string('mobile');
            $table->string('tech_mobile_verefied')->nullable();
            $table->string('tel')->nullable();
            $table->string('password');
            $table->string('identification')->nullable();
            $table->date('birth')->nullable();
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->integer('area_id');
            $table->string('address')->nullable();
            $table->longText('bio')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('pkg')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('points')->default(0);
            $table->boolean('tech_modify')->nullable();
            $table->boolean('tech_modify_by')->nullable();
            $table->string('devise_token')->unique();
            $table->boolean('blocked')->default(0);
            $table->date('login');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technicians');
        // DB::statement('ALTER Table technicians add code INTEGER NOT NULL UNIQUE AUTO_INCREMENT');
    }
};