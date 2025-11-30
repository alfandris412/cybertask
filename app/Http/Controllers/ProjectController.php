<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 1. TAMPILKAN DAFTAR PROJECT (READ)
    public function index()
    {
        $projects = Project::with('members')->orderBy('created_at', 'desc')->get();
        return view('admin.projects.index', compact('projects'));
    }

    // 2. TAMPILKAN FORM TAMBAH (CREATE)
    public function create()
    {
        $karyawan = User::where('role', 'karyawan')->get();
        return view('admin.projects.create', compact('karyawan'));
    }

    // 3. SIMPAN DATA BARU (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repository_link' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'members' => 'array',
            'roles' => 'array',
        ]);

        $project = Project::create($request->except(['members', 'roles']));

        if ($request->has('members')) {
            $syncData = [];
            foreach ($request->members as $userId) {
                $userRole = $request->roles[$userId] ?? 'Member';
                $syncData[$userId] = ['role' => $userRole];
            }
            $project->members()->attach($syncData);
        }

        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan!');
    }

    // 4. DETAIL PROJECT (SHOW)
    public function show(Project $project)
    {
        $project->load(['tasks' => function ($q) {
            $q->with('users')->orderBy('created_at', 'desc');
        }]);
        return view('projects.show', compact('project'));
    }

    // 5. TAMPILKAN FORM EDIT (EDIT)
    public function edit(Project $project)
    {
        $karyawan = User::where('role', 'karyawan')->get();
        $selectedMembers = $project->members->pluck('id')->toArray();

        return view('admin.projects.edit', compact('project', 'karyawan', 'selectedMembers'));
    }

    // 6. UPDATE DATA (UPDATE)
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'repository_link' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'members' => 'array',
            'roles' => 'array',
        ]);

        $project->update($request->except(['members', 'roles']));

        if ($request->has('members')) {
            $syncData = [];
            foreach ($request->members as $userId) {
                $userRole = $request->roles[$userId] ?? 'Member';
                $syncData[$userId] = ['role' => $userRole];
            }
            $project->members()->sync($syncData);
        } else {
            $project->members()->detach();
        }

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui!');
    }

    // 7. HAPUS DATA (DESTROY)
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus!');
    }

    // ==========================================
    // 8. API GET MEMBERS (INI YANG TADI HILANG!)
    // ==========================================
    public function getMembers(Project $project)
    {
        // Ambil user beserta data pivot (role di project)
        $members = $project->members()->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                // Ambil role spesifik di project ini
                'project_role' => $user->pivot->role ?? 'Member', 
                'initial' => substr($user->name, 0, 2)
            ];
        });

        return response()->json($members);
    }

    // 9. LIST PROJECT SAYA (UNTUK KARYAWAN)
    public function myProjects()
    {
        $user = Auth::user();

        $projects = Project::whereHas('members', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->with('members')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('karyawan.projects.index', compact('projects'));
    }
}