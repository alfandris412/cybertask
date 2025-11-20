<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_projects' => Project::count(),
            'total_staff' => User::where('role', 'karyawan')->count(),
            'pending_tasks' => Task::where('status', '!=', 'completed')->count(),
            'my_tasks' => Task::where('user_id', $user->id)->where('status', '!=', 'completed')->count(),
            'completed_tasks' => Task::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        if ($user->role === 'admin') {
            return view('admin.dashboard', compact('stats')); 
        } else {
            return view('karyawan.dashboard', compact('stats')); 
        }
    }
}