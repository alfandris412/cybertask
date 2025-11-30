<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG CURRENT TASK CREATION PROJECT ===\n\n";

// Cek semua project yang ada
echo "All Projects:\n";
$projects = \App\Models\Project::all();
foreach ($projects as $project) {
    echo "- {$project->name} (ID: {$project->id})\n";
    
    echo "  Members:\n";
    $members = $project->members;
    foreach ($members as $member) {
        echo "    * {$member->name} - Role: '{$member->pivot->role}'\n";
    }
    echo "\n";
}
