<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'nullable|string|max:1000',
            // NAIKKAN BATAS JADI 10MB (10240 KB)
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240', 
        ]);

        // Cek: Jangan biarkan kirim kosong total
        if (!$request->content && !$request->hasFile('attachment')) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Pesan atau gambar tidak boleh kosong.'], 422);
            }
            return back()->withErrors(['content' => 'Pesan kosong.']);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('chat-images', 'public');
        }

        // TRIK ANTI-GAGAL DATABASE:
        // Jika konten kosong tapi ada gambar, jangan isi dengan teks placeholder — biarkan null.
        $finalContent = $request->content;
        if (empty($finalContent) && $attachmentPath) {
            $finalContent = null;
        }

        $comment = Comment::create([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'content' => $finalContent, // Pakai konten yang sudah diamankan
            'attachment' => $attachmentPath,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terkirim',
                'data' => $comment
            ]);
        }

        return back()->with('success', 'Komentar terkirim!');
    }
}