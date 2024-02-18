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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('kategori_id');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->text('resep')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('harga');
            $table->string('status')->default(0);
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
