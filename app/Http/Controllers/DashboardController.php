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
            $projects = Project::with('tasks')->orderBy('created_at', 'desc')->paginate(10);
            
            // Get overdue projects (projects dengan overdue tasks)
            $overdueProjects = Project::whereHas('tasks', function ($q) {
                $q->where('status', '!=', 'completed')
                  ->whereDate('due_date', '<', Carbon::today());
            })->with(['tasks' => function ($q) {
                $q->where('status', '!=', 'completed')
                  ->whereDate('due_date', '<', Carbon::today());
            }])->get();
            
            $stats = [
                'total_projects' => Project::count(),
                'total_staff' => User::where('role', 'karyawan')->count(),
                'total_tasks' => Task::count(),
                'completed_tasks' => Task::where('status', 'completed')->count(),
                'pending_tasks' => Task::where('status', '!=', 'completed')->count(),
                'overdue_tasks' => Task::where('status', '!=', 'completed')
                                    ->whereDate('due_date', '<', Carbon::today())
                                    ->count(),
                'due_soon_tasks' => Task::where('status', '!=', 'completed')
                                    ->whereDate('due_date', '>=', Carbon::today())
                                    ->whereDate('due_date', '<=', Carbon::today()->addDays(3))
                                    ->count(),
                'overdue_projects' => $overdueProjects->count(),
            ];

            return view('admin.dashboard', compact('projects', 'stats', 'overdueProjects'));
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
        }])->orderBy('created_at', 'desc')->paginate(10);
        
        // Get user tasks untuk sidebar
        $userTasks = Task::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })->with('project')->orderBy('due_date', 'asc')->take(10)->get();
        
        // Notifikasi: Tugas overdue
        $overdueTasks = Task::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })
            ->where('status', '!=', 'completed')
            ->whereDate('due_date', '<', $today)
            ->with('project')
            ->orderBy('due_date', 'asc')
            ->get();

        // Notifikasi: Tugas yang akan deadline dalam 3 hari
        $dueSoonTasks = Task::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        })
            ->where('status', '!=', 'completed')
            ->whereDate('due_date', '>=', $today)
            ->whereDate('due_date', '<=', $today->copy()->addDays(3))
            ->with('project')
            ->orderBy('due_date', 'asc')
            ->get();

        $stats = [
            'my_projects' => $projects->total(),
            'my_tasks' => Task::whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })->count(),
            'completed_tasks' => Task::whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })->where('status', 'completed')->count(),
            'overdue_count' => $overdueTasks->count(),
            'due_soon_count' => $dueSoonTasks->count(),
        ];

        return view('karyawan.dashboard', compact('projects', 'stats', 'overdueTasks', 'dueSoonTasks', 'userTasks'));
    }
}