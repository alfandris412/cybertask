<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Comment; // Jangan lupa ini
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'users'])->orderBy('due_date', 'asc')->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create(Project $project = null)
    {
        $projects = Project::all();
        $users = User::where('role', 'karyawan')->get();
        
        // Jika dari project detail, set project_id
        if ($project) {
            return view('admin.tasks.create', compact('projects', 'users', 'project'));
        }
        
        return view('admin.tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'project_id'  => 'required|exists:projects,id',
            'user_ids'    => 'required|array',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'required|date',
            'description' => 'required|string',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'project_id'  => $request->project_id,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        $task->users()->syncWithoutDetaching($request->user_ids);
        return redirect()->route('projects.show', $task->project)->with('success', 'Tugas berhasil dibagikan!');
    }

    public function show(Task $task)
    {
        $task->load(['project', 'users', 'usersWithProjectRole', 'comments.user']);

        // Karyawan pakai tampilan khusus sendiri
        if (auth()->check() && auth()->user()->role === 'karyawan') {
            return view('karyawan.tasks.show', compact('task'));
        }

        // Admin (atau role lain) tetap pakai tampilan admin
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::where('role', 'karyawan')->get();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->except('user_ids'));
        if ($request->has('user_ids')) {
            $task->users()->sync($request->user_ids);
        }
        return redirect()->route('projects.show', $task->project)->with('success', 'Tugas diperbarui!');
    }

    public function destroy(Task $task)
    {
        $projectId = $task->project_id;
        $task->delete();
        return redirect()->route('projects.show', $projectId)->with('success', 'Tugas dihapus!');
    }

    // KHUSUS KARYAWAN: Update Status & Link GitHub & Laporan
    public function updateStatus(Request $request, Task $task)
    {
        try {
            $request->validate([
                'report_title' => 'required|string|max:255',
                'report_desc'  => 'required|string',
                'status'       => 'required|in:pending,in_progress,completed',
                'github_link'  => 'nullable|url', // Validasi URL
            ]);

            // Debug: Log request data
            \Log::info('Update Status Request:', [
                'task_id' => $task->id,
                'report_title' => $request->report_title,
                'report_desc' => $request->report_desc,
                'status' => $request->status,
                'github_link' => $request->github_link,
            ]);

            // Simpan Link GitHub & Status
            $task->update([
                'status' => $request->status,
                'github_link' => $request->github_link ?? $task->github_link,
            ]);

            $statusText = match($request->status) {
                'pending' => 'Pending',
                'in_progress' => 'On Progress',
                'completed' => 'Selesai',
            };

            // Simpan Laporan ke Komentar
            Comment::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'title'   => $request->report_title,
                'content' => $request->report_desc . "\n\nStatus: $statusText",
            ]);

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Laporan berhasil dikirim!'
                ]);
            }

            return back()->with('success', 'Laporan berhasil dikirim!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', $e->errors());
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('General Error:', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // API Get Members (Untuk Form Create)
    public function myTasks()
    {
        $user = auth()->user();
        $tasks = Task::whereHas('users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        })->orderBy('due_date', 'asc')->get();

        return view('karyawan.tasks.index', compact('tasks'));
    }

    // Halaman khusus riwayat progres untuk satu task (karyawan)
    public function progress(Task $task)
    {
        $task->load(['project', 'users', 'usersWithProjectRole', 'comments.user']);
        return view('karyawan.tasks.progress', compact('task'));
    }
}