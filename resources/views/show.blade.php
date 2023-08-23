@extends('layouts.app')


@section('title', $task -> title)


@section('content')

<p>Descripcion: {{$task -> description}}</p>

@if($task -> longDescription)
    <p>Descripcion larga: {{$task ->longDescription}}</p>
@endif

<p>Fecha de craecion: {{$task ->created_at}}</p>
<p>Fecha de actualizacion: {{$task ->updated_at}}</p>
<p>@if($task->completed) 
    Completada
    @else
    Sin completar
    @endif
</p>

<div>
    <button type="submit" href="{{ route('tasks.edit', ['id' => $task->id]) }}" >Edit</a>
</div>

<div>
    <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>

    </form>
</div>

<div>
    <form method="POST" action="{{ route('tasks.toggle-complete', ['id' => $task->id])}}">
        @csrf
        @method('PUT')
        <button type="submit">
            Marcar como {{ $task->completed ? 'sin completar' : 'completada' }}
        </button>
    </form>
</div>
@endsection