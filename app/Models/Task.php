<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi ke Project (Milik Satu Project)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 2. Relasi ke User/Tim (Dikerjakan Banyak Orang - Pivot)
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    // 4. Relasi ke User dengan role dari project
    public function usersWithProjectRole()
    {
        return $this->belongsToMany(User::class, 'task_user')
            ->join('project_user', function($join) {
                $join->on('project_user.user_id', '=', 'users.id')
                     ->where('project_user.project_id', '=', $this->project_id);
            })
            ->select('users.*', 'project_user.role as project_role');
    }

    // 3. Relasi ke Komentar (Punya Banyak Komentar) -- INI YANG KURANG TADI
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }
}