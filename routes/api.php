<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\TaskManagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'authentication'], function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('register', [AuthenticationController::class, 'register']);
});

Route::middleware('customAuth')->prefix('tasksManagement')->group(function () {
    Route::get('getTaskList', [TaskManagerController::class, 'getTasksList']);

    Route::get('getTasksDetails', [TaskManagerController::class, 'getTasksDetails']);

    Route::patch('updateTaskStatus', [TaskManagerController::class, 'updateTaskStatus']);

    Route::post('createTask', [TaskManagerController::class, 'createTask']);

    Route::put('updateTask', [TaskManagerController::class, 'updateTask']);

    Route::delete('deleteTask', [TaskManagerController::class, 'deleteTask']);
});

Route::middleware('customAuth')->prefix('projectsManagement')->group(function () {
    Route::get('getProjectList', [ProjectManagerController::class, 'getProjectList']);


});
