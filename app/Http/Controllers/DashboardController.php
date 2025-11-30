<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Dashboard ADMIN: Tampilkan semua projects
        if ($user->role === 'admin') {
            $projects = Project::with('tasks')->orderBy('created_at', 'desc')->get();
            
            $stats = [
                'total_projects' => $projects->count(),
                'total_staff' => User::where('role', 'karyawan')->count(),
                'pending_tasks' => Task::where('status', '!=', 'completed')->count(),
            ];

            return view('admin.dashboard', compact('projects', 'stats'));
        }

        // Dashboard KARYAWAN: Tampilkan projects yang user ikuti + notifikasi overdue
        $today = Carbon::today();
        
        // Get projects dari tasks yang di-assign ke user
        $projects = Project::whereHas('tasks', function ($q) use ($user) {
            $q->whereHas('users', function ($q2) use ($user) {
                $q2->where('users.id', $user->id);
            });
        })->with(['tasks' => function ($q) use ($user) {
            $q->whereHas('users', function ($q2) use ($user) {
                $q2->where('users.id', $user->id);
            });
        }])->orderBy('created_at', 'desc')->get();

        // Notifikasi: Tugas overdue
        $overdueTasks = Task::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })
            ->where('status', '!=', 'completed')
            ->whereDate('due_date', '<', $today)
            ->with('project')
            ->orderBy('due_date', 'asc')
            ->get();

        $stats = [
            'my_projects' => $projects->count(),
            'overdue_count' => $overdueTasks->count(),
        ];

        return view('karyawan.dashboard', compact('projects', 'stats', 'overdueTasks'));
    }
}