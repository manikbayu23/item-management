<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ubah kolom role enum hanya ke 3 value baru
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'pic', 'staff') NOT NULL DEFAULT 'staff'");
    }

    public function down(): void
    {
        // rollback (sesuaikan dengan value enum lama kamu sebelumnya)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'pic','user') NOT NULL DEFAULT 'user'");
    }
};
