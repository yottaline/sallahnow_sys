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
            $table->id();
            $table->integer('tech_center')->nullable();
            $table->string('tech_name', 100);
            $table->string('tech_email', 100)->nullable();
            $table->string('tech_email_verefied')->nullable();
            $table->string('tech_mobile', 24);
            $table->string('tech_mobile_verefied')->nullable();
            $table->string('tech_tel', 24)->nullable();
            $table->string('tech_password', 255);
            $table->string('tech_identification')->nullable();
            $table->date('tech_birth')->nullable();
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->integer('area_id');
            $table->string('tech_address')->nullable();
            $table->longText('tech_bio')->nullable();
            $table->decimal('tech_rate', 9 ,2)->default('0');
            $table->tinyInteger('tech_pkg')->nullable();
            $table->string('tech_notes', 1024)->nullable();
            $table->integer('tech_points')->default(0);
            $table->decimal('tech_credit', 9 ,2)->default('0');
            $table->boolean('tech_modify')->nullable();
            $table->boolean('tech_modify_by')->nullable();
            $table->string('devise_token')->unique();
            $table->boolean('tech_blocked')->default(0);
            $table->date('tech_login');
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
