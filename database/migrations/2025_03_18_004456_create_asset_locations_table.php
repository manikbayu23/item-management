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
        /**
         * Creating table 'locations' for 'LOKASI ASET'
         */
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            $table->string('code', length: 50);
            $table->string('province', length: 100);
            $table->string('regency', length: 100);
            $table->string('district', length: 100);
            $table->string('status', length: 5);
            $table->string('area', length: 100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
