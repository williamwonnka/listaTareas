@extends('layouts.app')

@section('title', 'Añadir tarea')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2><i class="bi bi-plus"></i> Añadir Tarea</h2>

                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="longDescription">Descripción Larga</label>
                        <input type="hidden" name="longDescription" id="longDescription" rows="5">`{{ old('longDescription') }}</input>
                        @error('longDescription')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-info mt-3">Agregar Tarea</button>
                </form>
            </div>
        </div>
    </div>
@endsection
