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
        Schema::table('assets', function (Blueprint $table) {
            $table->string('name', length: 300)->after('location_code');
            $table->foreignId('sub_category_id')->after('acquisition');
            $table->renameColumn('program_id', 'department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropForeign('sub_category_id');
            $table->dropColumn('sub_category_id');
            $table->renameColumn('department_id', 'program_id');
        });
    }
};
