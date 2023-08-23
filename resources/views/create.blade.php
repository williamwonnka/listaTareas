@extends('layouts.app')

@section('title','Anadir tarea')

@section('content')
@section('styles')
<style>
    .error-message{
        color:red;
        font-size: 0.8rem;

    }
</style>
@endsection

                    <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div>
                        <label for="title">Titulo</label>
                        <input text="text" name="title" id="title" value="{{ old('title') }}"/>
                        @error('title')
                        <p class="error-message">{{$message}}</p>
                        @enderror
                    </div>

                    <div>
                    <label for="description">Descripcion</label>
                        <textarea name="description" id="description" rows="5">{{old('description')}}</textarea>
                        @error('description')
                        <p class="error-message">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="longDescription">Descripcion larga</label>
                        <textarea name="longDescription" id="longDescription" rows="10">{{ old('longDescription') }}</textarea>
                        @error('longDescription')
                        <p class="error-message">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit">Add task</button>
                    </div>
</form>
       
@endsection