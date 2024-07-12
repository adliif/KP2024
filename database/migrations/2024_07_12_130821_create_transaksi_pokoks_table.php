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
        Schema::create('transaksi_pokoks', function (Blueprint $table) {
            $table->id('id_transaksiPokok');

            //FK
            $table->unsignedBigInteger('id_simpanan_pokok');
            $table->foreign('id_simpanan_pokok')->references('id_simpanan_pokok')->on('simpanan_pokoks')->onDelete('cascade');
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
        Schema::dropIfExists('transaksi_pokoks');
    }
};