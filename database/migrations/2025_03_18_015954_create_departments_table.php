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
         * Creating table 'departments' for 'BIDANG PENGGUNA'
         */
        Schema::create('departments', function (Blueprint $table) {
            $table->id();

            $table->string('code', length: 10);
            $table->string('name', length: 200);

            $table->timestamps();
        });

        /**
         * Creating table 'divisions' for 'DIVISI/DEPARTEMEN PENGGUNA'
         */
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id');

            $table->string('code', length: 10);
            $table->string('name', length: 200);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
        Schema::dropIfExists('departments');
    }
};
