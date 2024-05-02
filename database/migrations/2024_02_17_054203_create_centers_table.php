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
        Schema::create('centers', function (Blueprint $table) {
            $table->integer('center_id', true, true);
            $table->integer('center_owner')->unsigned();
            $table->string('center_name', 255);
            $table->string('center_logo')->nullable();
            $table->string('center_cr', 24)->nullable();
            $table->string('center_email', 120)->nullable();
            $table->string('center_mobile', 24)->nullable();
            $table->string('center_tel', 24)->nullable();
            $table->string('center_whatsapp', 24)->nullable();
            $table->string('center_tax', 24)->nullable();
            $table->foreignId('center_country')->unsigned();
            $table->integer('center_state')->unsigned();
            $table->integer('center_city')->unsigned();
            $table->integer('center_area')->unsigned();
            $table->string('center_address', 1024);
            $table->tinyInteger('center_rate')->nullable()->unsigned();
            $table->integer('center_create_by')->nullable()->unsigned();
            $table->dateTime('center_modify')->nullable();
            $table->integer('center_modify_by')->nullable()->unsigned();
            $table->dateTime('center_create');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};