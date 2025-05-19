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
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id('id_konsultasi'); // Primary Key
            $table->unsignedBigInteger('id_pasien'); // Foreign Key ke tabel pasien
            $table->unsignedBigInteger('id_dokter'); // Foreign Key ke tabel dokter
            $table->dateTime('tanggal_konsul');
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('pending');
            $table->enum('metode', ['online', 'offline']);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_pasien')->references('id')->on('pasiens')->onDelete('cascade');
            $table->foreign('id_dokter')->references('id')->on('dokters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
