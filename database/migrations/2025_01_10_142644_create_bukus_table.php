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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string("judul");
            $table->integer("stok");
            $table->string("tahunTerbit");
            $table->string("code");
            $table->string('fotoBuku')->nullable();
            $table->text("deskripsi");
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_penulis');
            $table->unsignedBigInteger('id_penerbit');
            $table->foreign('id_kategori')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('id_penulis')->references('id')->on('penulis')->onDelete('cascade');
            $table->foreign('id_penerbit')->references('id')->on('penerbits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
