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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start');
            $table->date('end');
            $table->boolean('status')->default('1');
            $table->foreignId('technician_id')->constrained('technicians');
            $table->foreignId('package_id')->constrained('packages');
            $table->integer('package_points');
            $table->decimal('package_cost', 9, 2);
            $table->integer('package_period');
            $table->longText('package_priv');
            $table->integer('register_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};