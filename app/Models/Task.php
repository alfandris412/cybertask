<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Task milik satu Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Task dikerjakan satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}