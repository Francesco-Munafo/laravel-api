<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Type;
use GuzzleHttp\Promise\Create;
use App\Models\Technology;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->paginate(5);


        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $val_data = $request->validated();

        if ($request->has('image')) {
            $file_path = Storage::put('placeholders', $request->image);
            $val_data['image'] = $file_path;
        }

        // $project = new Project();
        // $project->title = $val_data['title'];
        // $project->slug = Str::slug($project->title, '-');
        // $project->description = $val_data['description'];
        // $project->type_id = $val_data['type_id'];
        // $project->image = $file_path;
        // $project->git_link = $val_data['git_link'];
        // $project->external_link = $val_data['external_link'];
        // $project->publication_date = $val_data['publication_date'];
        // $project->save();
        $val_data['slug'] =  Project::generateSlug($val_data['title'], '-');
        $project = Project::create($val_data);

        $project->technologies()->attach($request->technologies);



        return to_route('admin.projects.index')->with('message', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {


        return view('admin.projects.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $val_data = $request->validated();
        //dd($val_data);

        if ($request->has('image')) {
            $newImage = $request->image;
            $file_path = Storage::put('placeholders', $newImage);
            if (!is_null($project->image) && Storage::fileExists($project->image)) {
                Storage::delete($project->image);
            }

            $val_data['image'] = $file_path;
        }

        if (!Str::is($project->getOriginal('title'), $request->title)) {

            $val_data['slug'] = $project->generateSlug($request->title);
        }






        $project->technologies()->sync($request->technologies);
        $project->update($val_data);

        return to_route('admin.projects.show', $project)->with('message', 'Project updated successfully!');
    }


    public function trashed()
    {
        $trashed = Project::onlyTrashed()->paginate(5);

        return view('admin.projects.deleted', compact('trashed'));
    }

    public function restoreTrashed($slug)
    {

        $project = Project::withTrashed()->where('slug', '=', $slug)->first();

        $project->restore();

        return to_route('admin.trash')->with('message', 'Project restored successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {

        $project = Project::withTrashed()->where('slug', '=', $slug)->first();
        //dd($project);

        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Project added to the trash can!');
    }

    public function forceDelete($slug)
    {
        $project = Project::withTrashed()->where('slug', '=', $slug)->first();

        $project->technologies()->detach();

        $project->forceDelete();

        return to_route('admin.trash')->with('message', 'Project deleted successfully!');
    }
}
