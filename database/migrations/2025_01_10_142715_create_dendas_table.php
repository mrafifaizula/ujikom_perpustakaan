<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->string("totalDenda");
            $table->enum("statusPembayaran", ["belum", "sudah"]);
            $table->enum("jenisDenda", ["rusak", "hilang", "telat"]);
            $table->string("hariTelat")->nullable();
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_pengembalian')->nullable();
            $table->foreign('id_peminjaman')->references('id')->on('peminjaman_bukus')->onDelete('cascade');
            $table->foreign('id_pengembalian')->references('id')->on('pengembalian_bukus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
