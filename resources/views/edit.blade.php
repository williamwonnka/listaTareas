@extends('layouts.app')

@section('title', 'Edit Task')

@section('styles')
  <style>
    .error-message {
      color: red;
      font-size: 0.8rem;
      margin-top: 0.25rem;
    }

    .form {
      max-width: 400px;
      margin: 0 auto;
    }

    .row {
      display: flex;
      margin-bottom: 1rem;
    }

    .col-4,
    .col-8 {
      padding: 0.25rem;
    }

    .col-4 {
      flex: 1;
      font-weight: bold;
    }

    .col-8 {
      flex: 3;
    }

    .input-field,
    .textarea-field {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
    }

    .textarea-field {
      resize: vertical;
    }

    .button {
      background-color: #007bff;
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      cursor: pointer;
    }

    .button:hover {
      background-color: #0056b3;
    }
  </style>
@endsection

@section('content')
  <form class="form" method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-4">
        <label class="label" for="title">Title</label>
      </div>
      <div class="col-8">
        <input class="input-field" type="text" name="title" id="title" value="{{ $task->title }}" />
        @error('title')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="row">
      <div class="col-4">
        <label class="label" for="description">Description</label>
      </div>
      <div class="col-8">
        <textarea class="input-field textarea-field" name="description" id="description" rows="5">{{ $task->description }}</textarea>
        @error('description')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="row">
      <div class="col-4">
        <label class="label" for="longDescription">Long Description</label>
      </div>
      <div class="col-8">
        <textarea class="input-field textarea-field" name="longDescription" id="longDescription" rows="10">{{ $task->longDescription }}</textarea>
        @error('longDescription')
          <p class="error-message">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="row">
      <div class="col-4"></div>
      <div class="col-8">
        <button class="button btn-primary" type="submit">Edit Task</button>
      </div>
    </div>
  </form>
@endsection
