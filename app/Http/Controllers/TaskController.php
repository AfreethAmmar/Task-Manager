<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Auto-apply TaskPolicy to resource methods (view, update, delete, etc.)
        $this->authorizeResource(Task::class, 'task');
    }

    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:pending,done'],
        ]);

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    // No need to call $this->authorize('view', $task); it's automatic now
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:pending,done'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
