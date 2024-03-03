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
        Schema::create('support_attachments', function (Blueprint $table) {
            $table->integer('attach_id')->autoIncrement();
            $table->string('attach_file', 24);
            $table->integer('attach_ticket')->nullable();
            $table->integer('attach_reply')->nullable();
            $table->dateTime('attach_time');

            $table->foreign('attach_ticket')->references('ticket_id')->on('support_tickets')->cascadeOnDelete();
            $table->foreign('attach_reply')->references('reply_id')->on('support_replies')->cascadeOnDelete();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_attachments');
    }
};
