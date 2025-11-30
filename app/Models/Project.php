<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    // Izin mengisi semua kolom
    protected $guarded = ['id'];

    // Relasi: Satu Project punya BANYAK Anggota (User)
    public function members()
    {
       return $this->belongsToMany(User::class, 'project_user')->withPivot('role'); // ambil dengan pivot rolenya
    }

    // Relasi: Satu Project punya BANYAK Tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}