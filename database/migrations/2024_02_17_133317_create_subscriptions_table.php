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
            $table->integer('sub_id',true, true);
            $table->date('sub_start');
            $table->date('sub_end');
            $table->boolean('sub_status')->default('1');
            $table->integer('sub_tech')->unsigned();
            $table->integer('sub_pkg')->unsigned();
            $table->integer('sub_points');
            $table->decimal('sub_cost', 9, 2);
            $table->integer('sub_period');
            $table->string('sub_priv',4096)->nullable();
            $table->integer('sub_register_by')->nullable()->unsigned();
            $table->dateTime('sub_register');
            // $table->timestamps();

            $table->foreign('sub_tech')->references('tech_id')->on('technicians');
            $table->foreign('sub_pkg')->references('pkg_id')->on('packages');

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