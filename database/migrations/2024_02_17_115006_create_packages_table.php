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
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('pkg_id', true ,true);
            $table->tinyInteger('pkg_type')->unsigned();
            $table->integer('pkg_period')->unsigned();
            $table->decimal('pkg_cost',9,2);
            $table->integer('pkg_points')->unsigned();
            $table->string('pkg_priv');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};