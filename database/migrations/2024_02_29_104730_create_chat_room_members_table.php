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
        Schema::create('chat_room_members', function (Blueprint $table) {
            $table->integer('member_id', true, true);
            $table->integer('member_room')->unsigned();
            $table->integer('member_tech')->unsigned();
            $table->boolean('member_admin')->default('0');
            $table->dateTime('member_add');
            // $table->timestamps();

            $table->foreign('member_room')->references('room_id')->on('chat_rooms');
            $table->foreign('member_tech')->references('tech_id')->on('technicians');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_room_members');
    }
};