<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('tasks.notes')->latest()->get();
        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        return view('modules.create');
    }

    public function store(Request $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'unique:modules,slug',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'slug.unique' => 'A module with a similar name already exists.'
        ]);

        Module::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'color' => $request->color,
        ]);

        return redirect()->route('modules.index')->with('success', 'Module created successfully!');
    }

    public function show(Module $module)
    {
        $module->load('tasks');
        return view('modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $request->merge(['slug' => Str::slug($request->name)]);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'unique:modules,slug,' . $module->id,
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'slug.unique' => 'A module with a similar name already exists.'
        ]);

        $module->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'color' => $request->color,
        ]);

        return redirect()->route('modules.index')->with('success', 'Module updated successfully!');
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('modules.index')->with('success', 'Module deleted successfully!');
    }
}
