<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/tasks', function (){
    return view('index', [
       'tasks' => \App\Models\Task::latest()->paginate(5)
    ]);
})->name('tasks.index');

Route::view('tasks/create', 'create')->name('tasks.create');

Route::get('/tasks/{id}/edit', function ($id) {
    return view('edit', [
        'task' => Task::findOrFail($id)
    ]);
})->name('tasks.edit');


Route::get('/tasks/{id}', function($id){
    return view('show', ['task' => \App\Models\Task::findOrFail($id)]);
})->name('tasks.show');

Route::get('/', function() {
    return redirect()->route('tasks.index');
});

Route::post('/tasks', function(TaskRequest $request) {
    $task = Task::create($request->validated());

    

    return redirect()->route('tasks.show', ['id'=> $task->id]) -> with('success', 'Task created successfully');
})->name('tasks.store');


Route::fallback(function (){
    return('Woopsi!');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::put('/tasks/{id}', function ($id, TaskRequest $request) {
    $data = $request->validated();

    $task = Task::findOrFail($id);
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->longDescription = $data['longDescription'];
    $task->save();

    return redirect()->route('tasks.show', ['id' => $task->id])
        ->with('success', 'Task updated successfully!');
})->name('tasks.update');


Route::delete('/tasks/{id}' , function ($id) {
   try{
    $deletedRows = \App\Models\Task::destroy($id);

    if($deletedRows === 0) {
        return redirect()->route('tasks.index') -> with('message', 'Task not found');
    }
    else{
        return redirect()->route('tasks.index') -> with('success', 'Task deleted successfully');
    }
   } catch (\Exception $e) {
    return response()->route('tasks.index') -> with('error', 'Error al eliminar el registro');
   }

    
})->name('tasks.destroy');

Route::put('tasks/{id}/toggle-complete', function($id) {
    

    $task = Task::findOrFail($id);
    $task -> toggleComplete();

    return redirect()->back()->with('success', 'Tarea actualizada');

    
})->name('tasks.toggle-complete');