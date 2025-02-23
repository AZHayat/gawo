<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_wo')->unique();
            $table->string('nama_pemohon');
            $table->string('departemen');
            $table->date('tanggal_pembuatan');
            $table->date('target_selesai');
            $table->json('jenis_pekerjaan');
            $table->text('deskripsi');
            $table->enum('status', ['Open', 'Proses', 'Pending', 'Close'])->default('Open');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('work_orders');
    }
};
