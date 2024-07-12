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
        Schema::create('transaksi_pinjaman', function (Blueprint $table) {
            $table->id('id_transaksiPinjaman');

            //FK
            $table->unsignedBigInteger('id_tanggungan');
            $table->foreign('id_tanggungan')->references('id_tanggungan')->on('tanggungan')->onDelete('cascade');
            //FK

            $table->time('jatuh_tempo');
            $table->time('tanggal_pembayaran');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pinjamen');
    }
};
