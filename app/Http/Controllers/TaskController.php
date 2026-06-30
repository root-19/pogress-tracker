<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('tasks.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,in_progress,completed',
            'module_id' => 'required|exists:modules,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tasks', 'public');
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $request->status,
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('modules.index')->with('success', 'Task created successfully!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validator = validator($request->all(), [
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $task->update([
            'status' => $request->status,
        ]);

        return response()->json(['success' => true]);
    }
}
