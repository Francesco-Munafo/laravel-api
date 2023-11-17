@extends('layouts.admin')

@section('content')
    <div class="container py-5">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-muted pt-4">&#128898; Edit Type</h1>

        <form action="{{ route('admin.types.update', $type) }}" method="POST">
            @csrf

            @method('PUT')

            <h1>Editing "{{ $type->name }}"</h1>

            <div class="mb-3">
                <label for="name" class="form-label">Type name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    aria-describedby="helpName" placeholder="Insert a type name" value="{{ old('name', $type->name) }}">
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror



            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
@endsection
