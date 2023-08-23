@extends('layouts.app')

@section('title')
<h1>Lista de tareas</h1>
@endsection

@section('content')
<nav class="mb-4">
    <a href="{{ route('tasks.create') }}">Agregar tarea</a>
</nav>

<div>
    <!-- @if(count($tasks)) -->
        @forelse($tasks as $task)
        <div class="row pt-3">
            <div class="col-8">
                <a href="{{ route('tasks.show', ['id' => $task->id]) }}">{{ $task->title}}</a>
            </div>
            
            <div class="col">
                <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>

                </form>
                    <!-- Inside the <div class="btn-group"> element -->
            </div>
            <div class="col">
                <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-primary">Edit</a>

            </div>
            
        </div>
        @empty
        <div>There are no tasks!</div>
        @endforelse
    <!-- @else -->
    
    <!-- @endif -->

    @if ($tasks-> count())
    <nav>
        {{ $tasks->links() }}
    </nav>
    @endif
</div>
@endsection