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
        Schema::table('items', function (Blueprint $table) {
            $table->string(column: 'brand')->after('room_id');
            $table->string('unit', 50)->after('brand');
            $table->text('notes')->after('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('unit');
            $table->dropColumn(columns: 'notes');
            $table->dropColumn('brand');
        });
    }
};
