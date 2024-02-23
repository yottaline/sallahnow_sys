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
        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('trans_id')->autoIncrement();
            $table->tinyInteger('trans_method');
            $table->decimal('trans_amount', 9,2);
            $table->tinyInteger('trans_process');
            $table->string('trans_ref', 32)->unique();
            $table->integer('trans_create_by');
            $table->integer('trans_tech');

            $table->foreign('trans_tech')->references('tech_id')->on('technicians');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};