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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->integer('ticket_id')->autoIncrement();
            $table->string('ticket_code', 12);
            $table->integer('ticket_brand');
            $table->integer('ticket_model');
            $table->integer('ticket_category');
            $table->integer('ticket_cost')->default('0');
            $table->string('ticket_context', 4096);
            $table->tinyInteger('ticket_status')->default('1');
            $table->integer('ticket_tech');
            $table->dateTime('ticket_create');
            // $table->timestamps();

            $table->foreign('ticket_brand')->references('brand_id')->on('brands')->cascadeOnDelete();
            $table->foreign('ticket_model')->references('model_id')->on('models')->cascadeOnDelete();
            $table->foreign('ticket_category')->references('category_id')->on('support_categories')->cascadeOnDelete();
            $table->foreign('ticket_tech')->references('tech_id')->on('technicians')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
