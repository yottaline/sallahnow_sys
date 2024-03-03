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
            $table->integer('tech_id')->autoIncrement();
            $table->integer('tech_center')->nullable();
            $table->string('tech_code', 12)->unique();
            $table->string('tech_name', 100);
            $table->string('tech_email', 120)->nullable();
            $table->string('tech_email_verefied')->nullable();
            $table->string('tech_mobile', 24);
            $table->string('tech_mobile_verefied')->nullable();
            $table->string('tech_tel', 24)->nullable();
            $table->string('tech_password', 255);
            $table->string('tech_identification', 24)->nullable();
            $table->date('tech_birth')->nullable();
            $table->integer('tech_country');
            $table->integer('tech_state');
            $table->integer('tech_city');
            $table->integer('tech_area');
            $table->string('tech_address')->nullable();
            $table->longText('tech_bio')->nullable();
            $table->decimal('tech_rate', 9 ,2)->default('0');
            $table->tinyInteger('tech_pkg')->nullable();
            $table->string('tech_notes', 1024)->nullable();
            $table->integer('tech_points')->default(0);
            $table->decimal('tech_credit', 9 ,2)->default('0');
            $table->date('tech_modify')->nullable();
            $table->boolean('tech_modify_by')->nullable();
            $table->string('devise_token')->unique();
            $table->boolean('tech_blocked')->default(0);
            $table->dateTime('tech_login')->nullable();
            $table->integer('tech_register_by')->nullable();
            $table->dateTime('tech_register');
            // $table->timestamps();


            // $table->foreign('tech_register_by')->references('id')->on('users');
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