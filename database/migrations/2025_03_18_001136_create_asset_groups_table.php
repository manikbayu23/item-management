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
         * Creating table 'groups' for 'GOLONGAN ASET'
         */
        Schema::create('groups', function (Blueprint $table) {
            $table->id();

            $table->string('code', length: 5)->comment('Example: 1.');
            $table->text('description');
            $table->year('period');

            $table->timestamps();
        });

        /**
         * Creating table 'scopes' for 'BIDANG ASET'
         */
        Schema::create('scopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id');

            $table->string('code', length: 50)->comment('Example: 1.01.');
            $table->text('description');
            $table->year('period');

            $table->timestamps();
        });

        /**
         * Creating table 'categories' for 'KELOMPOK ASET'
         */
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scope_id');

            $table->string('code', length: 50)->comment('Example: 1.01.01.');
            $table->text('description');
            $table->year('period');

            $table->timestamps();
        });

        /**
         * Creating table 'sub_categories' for 'SUB KELOMPOK ASET'
         */
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');

            $table->string('code', length: 50)->comment('Example: 1.01.01.01.');
            $table->text('description');
            $table->year('period');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('scopes');
        Schema::dropIfExists('groups');
    }
};
