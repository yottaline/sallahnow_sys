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
        Schema::create('chat_room_messages', function (Blueprint $table) {
            $table->bigIncrements('msg_id');
            $table->integer('msg_room')->unsigned();
            $table->integer('msg_from')->unsigned();
            $table->string('msg_context', 1024);
            $table->dateTime('msg_create');
            // $table->timestamps();

            $table->foreign('msg_room')->references('room_id')->on('chat_rooms');
            $table->foreign('msg_from')->references('tech_id')->on('technicians');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_room_messages');
    }
};