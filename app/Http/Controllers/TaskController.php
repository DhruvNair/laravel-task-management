<?php

namespace App\Http\Controllers;

use App\Jobs\SendTaskAssignedNotification;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\TaskUpdated;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $tasks = Cache::remember("project_".$project->id."_tasks", 3600, function() use ($project){
            return Task::where('project_id', $project->id)->orderBy('created_at', 'desc')->paginate(10);
        });
        return view('task.index', ['project' => $project, 'tasks' => $tasks]);
    }

    public function getTasksAPI(Project $project)
    {
        $tasks = Cache::remember("project_".$project->id."_tasks", 3600, function() use ($project){
            return Task::where('project_id', $project->id)->orderBy('created_at', 'desc')->paginate(10);
        });
        return response()->json([
            'projects' => $tasks
        ]);
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
        Cache::forget("project_".$project->id."_tasks");
        return to_route('project.task.index', $project)->with('message', "Task '" . $task->title . "' created successfully!");
    }

    public function createTaskAPI(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string|nullable',
            'deadline' => 'date|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong!',
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();
        $data['status'] = 'pending';
        $data['project_id'] = $project->id;

        $task = Task::create($data);
        Cache::forget("project_".$project->id."_tasks");
        return response()->json([
            'message' => "Task '" . $task->title . "' created successfully",
            'task' => $task
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, Task $task)
    {
        return view('task.show', ['project' => $project, 'task' => $task]);
    }

    public function getTaskAPI(Project $project, Task $task)
    {
        return response()->json([
            'task' => $task
        ]);
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
        Cache::forget("project_".$project->id."_tasks");
        return to_route('project.task.show', ['project'=>$project, 'task'=>$task])->with('message', "Task '" . $task->title . "' updated successfully!");
    }

    public function updateTaskAPI(Request $request, Project $project, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255|nullable',
            'description' => 'string|nullable',
            'deadline' => 'date|nullable',
            'assigned_to' => 'exists:users,id|nullable',
            'status' => 'string|in:pending,in_progress,completed|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong!',
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();

        $task->update($data);

        if(isset($data['assigned_to'])){
            dispatch(new SendTaskAssignedNotification($task));
        }
        event(new TaskUpdated($task));
        Cache::forget("project_".$project->id."_tasks");
        return response()->json([
            'message' => "Task '" . $task->title . "' updated successfully",
            'project' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Task $task)
    {
        $task->delete();
        Cache::forget("project_".$project->id."_tasks");
        return to_route('project.task.index', $project)->with('message', 'Task deleted successfully!');
    }

    public function destroyTaskAPI(Project $project, Task $task)
    {
        $task->delete();
        Cache::forget("project_".$project->id."_tasks");
        return response()->json([
            'message' => "Task '" . $task->title . "' deleted successfully"
        ]);
    }
}
