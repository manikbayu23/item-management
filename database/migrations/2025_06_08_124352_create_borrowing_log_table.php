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
        Schema::create('borrowing_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancel', 'in_progress']);
            $table->foreignId('admin_id')->nullable()->constrained('users');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->text('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_log');
    }
};
