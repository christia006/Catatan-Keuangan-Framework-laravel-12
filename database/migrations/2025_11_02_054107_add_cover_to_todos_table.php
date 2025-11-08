<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: menambahkan kolom 'cover' pada tabel 'todos'
     */
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            // Tambah kolom 'cover' opsional untuk menyimpan path gambar
            if (!Schema::hasColumn('todos', 'cover')) {
                $table->string('cover')->nullable()->after('description');
            }
        });
    }

    /**
     * Batalkan migrasi (hapus kolom cover jika di-rollback)
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            if (Schema::hasColumn('todos', 'cover')) {
                $table->dropColumn('cover');
            }
        });
    }
};
