@extends('layouts.app')

@section('title', 'Editar Tarea')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Tarea</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $task->title }}" />
                            @error('title')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" name="description" id="description" rows="5">{{ $task->description }}</textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="longDescription" class="form-label">Descripción Larga</label>
                            <textarea class="form-control" name="longDescription" id="longDescription" rows="10">{{ $task->longDescription }}</textarea>
                            @error('longDescription')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-info">Editar Tarea</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
