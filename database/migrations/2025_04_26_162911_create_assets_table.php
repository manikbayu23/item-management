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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->string('asset_code', length: 100)->comment('Example: 1.01.01.01. add with 5 digits NO URUT DAFTAR');
            $table->string('location_code', length: 100)->comment('Example: 51.03.05.2002. add with 1 digit KODE BIDANG and TAHUN PEROLEHAN');

            $table->year('procurement')->nullable()->comment('Tahun Pengadaan');
            $table->date('acquisition')->comment('Tanggal Perolehan');

            $table->foreignId('department_id');

            $table->string('type', length: 100)->comment('Jenis Barang');
            $table->text('asset_identity')->comment('Identitas Barang');
            $table->integer('qty');
            $table->string('unit', length: 50);
            $table->text('description');
            $table->string('file_name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
