<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $note = Note::create([
            'task_id' => $request->task_id,
            'content' => $request->content,
            'color' => $request->color,
        ]);

        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['success' => true]);
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'content' => 'required|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $note->update([
            'content' => $request->content,
            'color' => $request->color,
        ]);

        return response()->json([
            'success' => true,
            'note' => $note
        ]);
    }
}
