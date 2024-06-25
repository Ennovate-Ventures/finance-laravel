<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::with('user')->get();
        return response()->json($projects, 200);
    }

    public function store(Request $request){
        Project::create([
            'name' => $request->title,
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'Project is made', 201
        ]);
    }


    public function update(Request $request, $id){
        $project = Project::find($id);

        $project->update([
            'name' => $request->name
        ]);

        return response()->json([
            'Project is updated', 200
        ]);
    }
}
