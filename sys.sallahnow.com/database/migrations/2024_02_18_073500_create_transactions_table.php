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
            $table->id();
            $table->tinyInteger('trans_method');
            $table->decimal('trans_amount', 9,2);
            $table->tinyInteger('trans_process');
            $table->string('reference', 32)->unique();
            $table->integer('trans_create_by');
            $table->foreignId('technician_id')->constrained('technicians')->cascadeOnDelete();
            $table->timestamps();
            // $table->date('trans_created_at');
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