<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {

        $total_projects = Project::all()->count();
        $total_users = User::all()->count();
        $total_technologies = Technology::all()->count();
        $last_projects = Project::orderByDesc('id')->limit(3)->get();

        return view('admin.dashboard', compact('total_projects', 'total_users', 'last_projects'));
    }
}
