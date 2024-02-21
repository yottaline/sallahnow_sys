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
            $table->date('sub_start');
            $table->date('sub_end');
            $table->boolean('sub_status')->default('1');
            $table->foreignId('technician_id')->constrained('technicians');
            $table->foreignId('package_id')->constrained('packages');
            $table->integer('sub_package_points');
            $table->decimal('sub_package_cost', 9, 2);
            $table->integer('sub_package_period');
            $table->string('package_priv')->nullable();
            $table->integer('sub_register_by')->nullable();
            // $table->date('sub_created_at');
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