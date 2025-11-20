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
    Schema::create('project_user', function (Blueprint $table) {
        $table->id();
        // Kunci ke Project
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        // Kunci ke User (Karyawan)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // pivot role
        $table->string('role')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};
