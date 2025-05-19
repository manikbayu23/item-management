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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 13)->after('name');
            $table->foreignId(column: 'position_id')->after('division_id');
            $table->string(column: 'created_by')->after('created_at');
            $table->string(column: 'updated_by')->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_number');
            $table->dropColumn('position_id');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
};
