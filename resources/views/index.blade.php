@extends('layouts.app')

@section('title', 'Lista de Tareas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center">Lista de Tareas</h1>
                </div>

                <div class="card-body">
                    <nav class="mb-4">
                        <a href="{{ route('tasks.create') }}" class="btn btn-success">Agregar Tarea</a>
                    </nav>

                    <div>
                        @forelse($tasks as $task)
                        <div class="row pt-3">
                            <div class="col-8">
                                <h4><a href="{{ route('tasks.show', ['id' => $task->id]) }}" style="text-decoration: none; color: #333;">{{ $task->title }}</a></h4>
                            </div>
                            <div class="col">
                                <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </div>
                            <div class="col">
                                <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-primary">Editar</a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">No hay tareas disponibles.</div>
                        @endforelse
                    </div>

                    @if ($tasks->count())
                    <nav>
                        {{ $tasks->links() }}
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
