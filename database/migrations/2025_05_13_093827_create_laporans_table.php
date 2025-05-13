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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('id_laporan');
            
            // Relasi ke Payment (karena 1 payment bisa punya banyak laporan)
            $table->unsignedBigInteger('id_pembayaran');
            $table->foreign('id_pembayaran')->references('id_pembayaran')->on('payments')->onDelete('cascade');

            $table->string('periode'); // misal: "Jan 2025"
            $table->integer('jumlah_pasien');
            $table->decimal('total_pendapatan', 15, 2); // Format uang, 15 digit total, 2 digit desimal

            $table->timestamps(); // menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
