@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <nav class="d-flex align-items-center justify-content-between">
        <h1 class="py-4">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-success"><i class="fa-solid fa-folder-plus me-2"></i> Add
            new project</a>
    </nav>
    <div class="card py-5 px-3 mb-3">
        <table class="table table-borderless ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Technologies</th>
                    <th scope="col">URL</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" class="text-center">Featured</th>
                    <th scope="col" class="text-end"> Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->name }}</td>
                        <td>
                            @if ($project->type)
                                <span class="badge" style="background-color: {{ $project->type->color }}">
                                    {{ $project->type->label }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @forelse ($project->technologies as $technology)
                            <span class="rounded-pill" style="background-color: {{ $technology->color }}">
                                {{ $technology->label }}
                            </span>                                                 
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{ $project->github_url }}</td>
                        <td>{{ $project->created_at }}</td>
                        <td>{{ $project->updated_at }}</td>
                        <td class="text-center">
                            @if ($project->is_featured)
                                <i class="fa-solid fa-star" style="color: #fbff00;"></i>
                            @else
                                <i class="fa-regular fa-star" style="color: #fbff00;"></i>
                            @endif
                        </td>
                        <td class="d-flex align-items-center justify-content-end  gap-2">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    @empty
                        <h3 class="text-center">No Projects in here! Get to work!</h3>
                @endforelse
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card p-3">
        <h3 class="py-4">Projects by Technology</h3>
        <div class="row row-cols-3 ">
            @foreach ($types as $type)
                <div class="col d-flex">
                    <h4 class="mb-4">
                        {{$type->label}}
                    </h4>
                    <small class="mx-2">
                        {{count($type->projects)}}
                    </small>
                </div>
            @endforeach
        </div>
    </div>
    <div class="py-5">
        @if ($projects->hasPages())
            {{ $projects->links() }}
        @endif
    </div>
@endsection
@section('scripts')
    @vite('resources/js/delete-confirmation.js')
@endsection
