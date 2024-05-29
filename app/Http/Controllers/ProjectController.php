<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all projects
        $projects = Project::query()->orderBy('created_at', 'desc')->paginate(10);
        //get number of tasks for each project
        return view('project.index', compact('projects'));
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
        return to_route('project.task.index', ['project'=>$project])->with('message', "Project '" . $project->name . "' created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return to_route('project.task.index', $project);
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
        return to_route('project.task.index', ['project'=>$project])->with('message', "Project '" . $project->name . "' updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('project.index')->with('message', "Project '" . $project->name . "' deleted successfully!");
    }
}
