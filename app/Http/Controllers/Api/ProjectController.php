<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;

class ProjectController extends Controller
{
    public function projects()
    {

        return response()->json([
            'status' => 'success',
            'projects' => Project::with(['type', 'technologies'])->orderByDesc('id')->paginate(5)
        ]);
    }

    public function types()
    {

        return response()->json([
            'status' => 'success',
            'projects' => Type::with(['projects'])->paginate(5)
        ]);
    }

    public function technologies()
    {

        return response()->json([
            'status' => 'success',
            'projects' => Technology::with(['projects'])->paginate(5)
        ]);
    }

    public function show($slug)
    {
        $project = Project::with('type', 'technologies')->where('slug', $slug)->first();
        if ($project) {
            return response()->json([
                'success' => true,
                'result' => $project
            ]);
        } else {
            return response()->json([
                'success' => false,
                'result' => 'Project not found! ☹'
            ]);
        }
    }
}
