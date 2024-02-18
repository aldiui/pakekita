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
        Schema::create('pesan_mejas', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('nama');
            $table->unsignedBigInteger('meja_id');
            $table->string('status')->default(0);
            $table->timestamps();

            $table->foreign('meja_id')->references('id')->on('mejas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_mejas');
    }
};
