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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('pesanan');
            $table->date('tanggal');
            $table->unsignedBigInteger('pembayaran_id')->nullable();
            $table->string('status')->default(0);
            $table->integer('bayar')->nullable();
            $table->integer('total');
            $table->integer('diskon')->nullable();
            $table->timestamps();

            $table->foreign('pembayaran_id')->references('id')->on('pembayarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
