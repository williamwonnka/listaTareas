<?php

namespace App\Http\Controllers;

use App\Services\TaskmanagerService;
use Illuminate\Http\Request;

class TaskManagerController extends Controller
{
    protected $taskService;

    public function __construct(TaskmanagerService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getTasksByUser(int $userId)
    {
        $tasks = $this->taskService->getTasksByUser($userId);
        return response()->json($tasks);
    }

    public function getTaskById(int $taskId)
    {
        $task = $this->taskService->getTaskById($taskId);
        return response()->json($task);
    }

    public function getCommentsByTaskId(int $taskId)
    {
        $comments = $this->taskService->getCommentsByTaskId($taskId);
        return response()->json($comments);
    }

    public function updateTaskStatus(Request $request, int $taskId)
    {
        $statusId = $request->input('status_id');
        $success = $this->taskService->updateTaskStatus($taskId, $statusId);
        return response()->json(['success' => $success]);
    }
}
