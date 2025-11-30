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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // UBAH JADI NULLABLE (Biar bisa kirim gambar doang)
            $table->text('content')->nullable(); 
            
            // TAMBAHAN LANGSUNG DISINI
            $table->string('attachment')->nullable(); 
            
            $table->string('title')->nullable(); // (Opsional: Jika kamu pakai fitur Laporan Progres)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
