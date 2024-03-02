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
        Schema::create('support_replies', function (Blueprint $table) {
            $table->integer('reply_id')->autoIncrement();
            $table->integer('reply_ticket');
            $table->string('reply_context', 1024);
            $table->integer('reply_user')->nullable();
            $table->integer('reply_tech')->nullable();
            $table->dateTime('reply_create');

            $table->foreign('reply_ticket')->references('ticket_id')->on('support_tickets')->cascadeOnDelete();
            $table->foreign('reply_user')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('reply_tech')->references('tech_id')->on('technicians')->cascadeOnDelete();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_replies');
    }
};