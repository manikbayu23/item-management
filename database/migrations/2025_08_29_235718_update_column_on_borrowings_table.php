<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // ubah last_reminder jadi timestamp
            $table->timestamp('last_reminder')->nullable()->change();

            // ubah reminder_to jadi integer
            $table->integer('reminder_to')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // rollback: balik lagi kayak migration sebelumnya
            $table->integer('last_reminder')->nullable()->change();
            $table->timestamp('reminder_to')->nullable()->change();
        });
    }
};
