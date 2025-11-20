<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. DAFTAR TUGAS (INDEX)
    public function index()
    {
        $tasks = Task::with(['project', 'user'])
                     ->orderBy('due_date', 'asc')
                     ->get();
                     
        return view('admin.tasks.index', compact('tasks'));
    }

    // 2. FORM TAMBAH TUGAS (CREATE)
    public function create()
    {
        $projects = Project::all();
        $users = User::where('role', 'karyawan')->get();

        return view('admin.tasks.create', compact('projects', 'users'));
    }

    // 3. SIMPAN TUGAS (STORE)
    public function store(Request $request)
    {
        // Validasi: Deskripsi WAJIB diisi (required)
        $request->validate([
            'title'       => 'required|string|max:255',
            'project_id'  => 'required|exists:projects,id',
            'user_id'     => 'required|exists:users,id',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'required|date',
            'description' => 'required|string', // <--- SUDAH DIUBAH JADI WAJIB
        ]);

        Task::create([
            'title'       => $request->title,
            'project_id'  => $request->project_id,
            'user_id'     => $request->user_id,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
            'description' => $request->description, // Tidak perlu fallback '-' lagi
            'status'      => 'pending',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diberikan!');
    }

    // 4. DETAIL TUGAS (SHOW)
    public function show(Task $task)
    {
        $task->load(['project', 'user']);
        return view('admin.tasks.show', compact('task'));
    }

    // 5. FORM EDIT TUGAS (EDIT)
    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::where('role', 'karyawan')->get();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    // 6. UPDATE TUGAS (UPDATE)
    public function update(Request $request, Task $task)
    {
        // Validasi Update: Deskripsi juga WAJIB
        $request->validate([
            'title'       => 'required|string|max:255',
            'project_id'  => 'required|exists:projects,id',
            'user_id'     => 'required|exists:users,id',
            'priority'    => 'required|in:low,medium,high',
            'status'      => 'required|in:pending,in_progress,completed',
            'due_date'    => 'required|date',
            'description' => 'required|string', // <--- WAJIB
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Detail tugas diperbarui!');
    }

    // 7. HAPUS TUGAS (DESTROY)
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas dihapus!');
    }
}