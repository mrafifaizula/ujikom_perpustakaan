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
        Schema::create('pembayaran_manuals', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggalPembayaran');
            $table->string('metodePembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('id_denda')->nullable();
            $table->foreign('id_denda')->references('id')->on('dendas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_manuals');
    }
};
