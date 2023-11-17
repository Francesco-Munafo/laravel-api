@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h1>Welcome {{ Auth::user()->name }}!</h1>
        <div class="row row-cols-3">
            <div class="col">
                <div class="card p-3">
                    <h3>Projects: </h3>
                    <h3>{{ $total_projects }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card p-3">
                    <h3>Registrated users: </h3>
                    <h3>{{ $total_users }}</h3>
                </div>
            </div>
            <div class="col">
                <div class="card p-3">
                    <h3>Technologies: </h3>
                    <h3>{{ $total_projects }}</h3>
                </div>
            </div>

        </div>

        <div class="row mt-5">
            @foreach ($last_projects as $last_project)
                <div class="col">
                    <div class="card h-100">
                        @if (str_contains($last_project->image, 'http'))
                            <img class="project_preview" src="{{ asset($last_project->image) }}" alt="Project preview">
                        @else
                            <img class="project_preview" src="{{ asset('storage/' . $last_project->image) }}"
                                alt="Project preview">
                        @endif
                        <div class="card-body">
                            <small class="text-secondary">Title:</small>
                            <h4>{{ $last_project->title }}</h4>
                        </div>
                        <div class="card-footer text-center">
                            <a class="btn btn-success" href="{{ route('admin.projects.show', $last_project) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                </svg>
                                View project
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
