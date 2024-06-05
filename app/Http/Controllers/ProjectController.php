<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all projects
        $projects = Cache::remember('projects', 3600, function(){
            return Project::query()->orderBy('created_at', 'desc')->paginate(10);
        });
        //get number of tasks for each project
        return view('project.index', compact('projects'));
    }

    public function getProjectsAPI()
    {
        $projects = Cache::remember('projects', 3600, function(){
            return Project::query()->orderBy('created_at', 'desc')->paginate(10);
        });
        return response()->json([
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
        ]);
        $data['user_id'] = 1;

        $project = Project::create($data);
        Cache::forget('projects');
        return to_route('project.task.index', ['project'=>$project])->with('message', "Project '" . $project->name . "' created successfully!");
    }

    public function createProjectAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong!',
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();

        $project = Project::create($data);
        Cache::forget('projects');
        return response()->json([
            'message' => "Project '" . $project->name . "' created successfully",
            'project' => $project
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return to_route('project.task.index', $project);
    }

    public function getProjectAPI(Project $project)
    {
        return response()->json([
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('project.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|nullable',
        ]);

        $project->update($data);
        Cache::forget('projects');
        return to_route('project.task.index', ['project'=>$project])->with('message', "Project '" . $project->name . "' updated successfully!");
    }

    public function updateProjectAPI(Request $request, Project $project)
    {
        if($request->user()->cannot('update', $project)){
            return response()->json([
                'message' => 'You are not authorized to update this project'
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|nullable',
            'description' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Something went wrong!',
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();

        $project->update($data);
        Cache::forget('projects');
        return response()->json([
            'message' => "Project '" . $project->name . "' updated successfully",
            'project' => $project
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        Cache::forget('projects');
        return to_route('project.index')->with('message', "Project '" . $project->name . "' deleted successfully!");
    }

    public function destroyProjectAPI(Request $request, Project $project)
    {
        if($request->user()->cannot('delete', $project)){
            return response()->json([
                'message' => 'You are not authorized to delete this project'
            ], 403);
        }
        $project->delete();
        Cache::forget('projects');
        return response()->json([
            'message' => "Project '" . $project->name . "' deleted successfully"
        ]);
    }
}
