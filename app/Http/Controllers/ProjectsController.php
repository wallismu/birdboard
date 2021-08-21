<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index() {
        $projects = Project::all();

        return view('projects.index', compact(['projects']));
    }

    public function show(Project $project) {
        // $project = Project::findOrFail(request('project'));

        return view('projects.show', compact(['project']));
    }

    public function store() {
        // What do?

        // validate
        $attributes = request()->validate([
            'title' => 'required', 
            'description' => 'required',
        ]);

        auth()->user()->projects()->create($attributes);

        // persist
        // Project::create($attributes);

        // redirect
        return redirect('/projects');
    }
}
