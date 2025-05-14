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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['borrow', 'return', 'transfer']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('actual_return_date')->nullable();
            $table->text('notes')->nullable();
            $table->char('created_by', 50);
            $table->char('updated_by', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
