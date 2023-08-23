@extends('layouts.app')


@section('content')
<div class="container">
        <h1 style="text-align: center" class="mt-2">Detalles de tareas</h1>
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">{{ $task->title }}</h3>
                </div>

                <div class="card-body">
                    <p><strong>Descripción:</strong> {{ $task->description }}</p>

                    @if($task->longDescription)
                    <p><strong>Descripción Larga:</strong> {{ $task->longDescription }}</p>
                    @endif

                    <p><strong>Fecha de Creación:</strong> {{ $task->created_at->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Fecha de Actualización:</strong> {{ $task->updated_at->format('d/m/Y H:i:s') }}</p>
                    
                    <p><strong>Estado:</strong> @if($task->completed) Completada @else Sin Completar @endif</p>

                    <div class="text-center">
                        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-info">Editar</a>
                    </div>

                    <div class="text-center mt-2">
                        <form action="{{ route('tasks.destroy', ['id' => $task->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>

                    <div class="text-center mt-2">
                        <form method="POST" action="{{ route('tasks.toggle-complete', ['id' => $task->id]) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">
                                Marcar como {{ $task->completed ? 'Sin Completar' : 'Completada' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
