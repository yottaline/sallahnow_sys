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
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('customer_id')->autoIncrement();
            $table->string('customer_code', 24);
            $table->string('customer_name', 100);
            $table->string('customer_email', 100);
            $table->string('customer_mobile', 24);
            $table->string('customer_password', 255);
            $table->integer('customer_country');
            $table->integer('customer_state');
            $table->integer('customer_city');
            $table->integer('customer_area');
            $table->string('customer_address', 1024);
            $table->string('customer_notes', 1024);
            $table->tinyInteger('customer_rate')->nullable();
            $table->tinyInteger('customer_active')->default('1');
            $table->dateTime('customer_login')->nullable();
            $table->dateTime('customer_register');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};