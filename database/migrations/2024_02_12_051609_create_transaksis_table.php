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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('meja_id')->nullable();
            $table->string('pembayaran');
            $table->text('json')->nullable();
            $table->string('status')->default(0);
            $table->integer('total');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('meja_id')->references('id')->on('mejas')->onDelete('cascade');
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