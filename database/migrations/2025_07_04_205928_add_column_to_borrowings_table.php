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
            $table->bigInteger(column: 'sq_borrow_number')->after('admin_id');
            $table->integer(column: 'qty')->after('sq_borrow_number');
            $table->string(column: 'borrow_number', length: 20)->after('qty');
            $table->string(column: 'admin_notes')->nullable()->after('notes');
            $table->dateTime('actual_collection_date')->nullable()->after('end_date');
            $table->integer('last_reminder')->nullable()->after('admin_notes');
            $table->timestamp('reminder_to')->nullable()->after('last_reminder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('sq_borrow_number');
            $table->dropColumn('borrow_number');
            $table->dropColumn('qty');
            $table->dropColumn('admin_notes');
            $table->dropColumn('actual_collection_date');
            $table->dropColumn('last_reminder');
            $table->dropColumn('reminder_to');
        });
    }
};
