<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_pembayaran');           // primary key
            $table->unsignedBigInteger('id_konsultasi'); // foreign key konsultasi
            $table->unsignedBigInteger('id_pasien');     // foreign key pasien
            $table->decimal('jumlah_bayar', 10, 2);      // jumlah bayar
            $table->string('metode_bayar');               // metode bayar: cash/transfer/ewallet
            $table->string('status_pembayaran');         // status: pending/berhasil/gagal
            $table->timestamps();

            // foreign key constraints
            $table->foreign('id_pasien')->references('id')->on('pasiens')->onDelete('cascade');
            $table->foreign('id_konsultasi')->references('id_konsultasi')->on('konsultasis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
