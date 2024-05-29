<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $tasks = Task::where('project_id', $project->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('task.index', ['project' => $project, 'tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('task.create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'deadline' => 'date|nullable',
            'project_id' => 'required|exists:projects,id',
        ]);
        $data['status'] = 'pending';

        $task = Task::create($data);
        return to_route('project.task.index', $project)->with('message', "Task '" . $task->title . "' created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        return view('task.show', ['project' => $project, 'task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Task $task)
    {
        return view('task.edit', ['project' => $project, 'task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'deadline' => 'date|nullable',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|string|in:pending,in_progress,completed',
        ]);

        $task->update($data);
        return to_route('project.task.show', ['project'=>$project, 'task'=>$task])->with('message', "Task '" . $task->title . "' updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $task->delete();
        return to_route('project.task.index', $project)->with('message', 'Task deleted successfully!');
    }
}
