<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK TASK DUPLICATES ===\n\n";

// Cari task yang baru dibuat (task terbaru)
$latestTask = \App\Models\Task::latest()->first();

if (!$latestTask) {
    echo "No tasks found!\n";
    exit;
}

echo "Latest Task: {$latestTask->title} (ID: {$latestTask->id})\n";
echo "Project: {$latestTask->project->name}\n";

// Cek duplikat di task_user
$duplicates = \Illuminate\Support\Facades\DB::table('task_user')
    ->select('task_id', 'user_id', \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
    ->where('task_id', $latestTask->id)
    ->groupBy('task_id', 'user_id')
    ->having('count', '>', 1)
    ->get();

if ($duplicates->isNotEmpty()) {
    echo "\n❌ DUPLICATE ENTRIES FOUND:\n";
    foreach ($duplicates as $dup) {
        echo "- Task ID: {$dup->task_id}, User ID: {$dup->user_id}, Count: {$dup->count}\n";
    }
    
    // Hapus duplikat
    echo "\n🧹 CLEANING DUPLICATES...\n";
    $duplicateRows = \Illuminate\Support\Facades\DB::table('task_user')
        ->select('id')
        ->where('task_id', $latestTask->id)
        ->groupBy('task_id', 'user_id')
        ->havingRaw('COUNT(*) > 1')
        ->get();
    
    foreach ($duplicateRows as $row) {
        // Ambil semua duplikat untuk kombinasi ini, kecuali yang pertama
        $recordsToDelete = \Illuminate\Support\Facades\DB::table('task_user')
            ->where('task_id', $latestTask->id)
            ->where('user_id', $row->user_id)
            ->orderBy('id')
            ->skip(1)
            ->pluck('id');
        
        if ($recordsToDelete->isNotEmpty()) {
            \Illuminate\Support\Facades\DB::table('task_user')
                ->whereIn('id', $recordsToDelete)
                ->delete();
            echo "- Deleted " . $recordsToDelete->count() . " duplicates for user {$row->user_id}\n";
        }
    }
} else {
    echo "\n✅ No duplicates found\n";
}

// Tampilkan current users
echo "\n=== CURRENT USERS ===\n";
$users = $latestTask->users;
foreach ($users as $user) {
    echo "- {$user->name} (ID: {$user->id})\n";
}

echo "\nTotal users: " . $users->count() . "\n";
