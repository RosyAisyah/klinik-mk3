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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_pembayaran'); // Primary key dengan nama id_pembayaran
            $table->unsignedBigInteger('id_konsultasi');
            $table->unsignedBigInteger('pasien_id');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('metode_bayar');
            $table->string('status_pembayaran');
            $table->timestamps();

            // Foreign key pasien_id ke tabel 'pasiens' kolom 'id'
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');

            // Foreign key id_konsultasi ke tabel 'konsultasis' kolom 'id_konsultasi'
            // Pastikan kolom dan tabel ini memang ada
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('konsultasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};