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
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
            $table->enum('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_jadwal_dokters');
    }
};
