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
        Schema::create('nilai_alternatifs', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('id_alternatif')->constrained('alternatifs', 'id_alternatif')->onDelete('cascade');
            $table->foreignId('id_kriteria')->constrained('kriterias', 'id_kriteria')->onDelete('cascade');
            $table->string('nilai_subkriteria', 100);
            $table->integer('bobot_subkriteria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_alternatifs');
    }
};
