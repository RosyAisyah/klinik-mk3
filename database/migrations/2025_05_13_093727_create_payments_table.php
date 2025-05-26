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
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_konsultasi');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->string('metode_bayar');
            $table->string('status_pembayaran');
            $table->timestamps();

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
