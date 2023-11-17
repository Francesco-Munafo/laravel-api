@extends('layouts.admin')

@section('content')
    @if (session('message'))
        <div class="alert alert-success mt-4" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="text-muted pt-4">&#128898; Trashed Projects 🗑</h1>
    <div class="card my-5">

        <div class="card-body p-0">

            <div class="table-responsive-sm">
                <table class="table table-striped table-hover table-borderless table-dark align-middle text-center">
                    <thead class="table-light">
                        <caption>Trashed projects table</caption>
                        <tr>
                            <th>ID</th>
                            <th>TYPE</th>
                            <th>TITLE</th>
                            <th>DESCRIPTION</th>
                            <th>IMAGE</th>
                            <th>URLs</th>
                            <th>DATE</th>
                            <th>PROJECT TYPE</th>
                            <th>ACTIONS</th>

                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @forelse ($trashed as $trashed_project)
                            <tr class="table-secondary">
                                <td scope="row">{{ $trashed_project->id }}</td>
                                <td><span
                                        class="badge rounded-pill text-bg-primary w-100">{{ $trashed_project->type?->name }}</span>
                                </td>
                                <td>{{ $trashed_project->title }}</td>
                                <td class="w-50">{{ $trashed_project->description }}</td>
                                <td>
                                    @if (str_contains($trashed_project->image, 'http'))
                                        <img height="100" src="{{ asset($trashed_project->image) }}"
                                            alt="trashed_ preview">
                                    @else
                                        <img height="100" src="{{ asset('storage/' . $trashed_project->image) }}"
                                            alt="Project preview">
                                    @endif

                                </td>
                                <td>
                                    <a class="text-black" href="{{ $trashed_project->git_link }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                                        </svg></a>

                                    <a class="text-black" href="{{ $trashed_project->external_link }}"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                            <path
                                                d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                            <path
                                                d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                                        </svg></a>
                                </td>
                                <td>{{ $trashed_project->publication_date }}</td>

                                <td>{{ $trashed_project->project_type }}</td>



                                <td>
                                    <div class="col d-flex justify-content-evenly">

                                        <form action="{{ route('admin.restore', $trashed_project->slug) }}" method="post">

                                            @csrf

                                            @method('PUT')

                                            <button class="btn btn-warning" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-counterclockwise"
                                                    viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z" />
                                                    <path
                                                        d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                                </svg>
                                            </button>
                                        </form>

                                        <!-- Modal trigger button -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalId-{{ $trashed_project->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                            </svg>
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div class="modal fade" id="modalId-{{ $trashed_project->id }}" tabindex="-1"
                                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                            aria-labelledby="modalTitleId-{{ $trashed_project->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="modalTitleId-{{ $trashed_project->id }}">Deleting your
                                                            project "{{ $trashed_project->title }}"
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Warning! This is an irreversible operation! Doing this you'll delete
                                                        your
                                                        project <span
                                                            class="text-decoration-underline text-danger">permanently!</span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Dismiss</button>

                                                        <form
                                                            action="{{ route('admin.forceDelete', $trashed_project->slug) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger">Delete</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No trashed projects ♻</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $trashed->links('pagination::bootstrap-5') }}
@endsection
