<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_user', function (Blueprint $table) {
            // Add unique constraint to prevent duplicate task-user assignments
            $table->unique(['task_id', 'user_id'], 'unique_task_user');
        });
    }

    public function down(): void
    {
        Schema::table('task_user', function (Blueprint $table) {
            // Remove the unique constraint
            $table->dropUnique('unique_task_user');
        });
    }
};
