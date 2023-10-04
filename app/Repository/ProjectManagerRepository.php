<?php

namespace App\Repository;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Collection;

class ProjectManagerRepository
{
    public function getTaskById(int $taskId): ?Task
    {
        return Task::find($taskId);
    }

    public function getCommentsByTaskId(int $taskId): Collection
    {
        return Task::find($taskId)->comments;
    }

    public function updateTaskStatus(int $taskId, int $statusId): bool
    {
        $task = Task::find($taskId);

        if ($task)
        {
            $task->status_id = $statusId;

            return $task->save();
        }

        return false;
    }

    public function validateTaskStatus(int $statusId)
    {
        return TaskStatus::find($statusId);
    }

    public function createProject(string $name, string $description)
    {
        $project = new Project();

        $project->name = $name;
        $project->description = $description;

        $project->save();

        return $project->refresh();
    }

    public function updateTask($taskId, ?string $title, ?string $details, ?int $userId, ?int $statusId, ?int $sprintId): int
    {
        $builder = Task::where('id', $taskId);

        $updatesArray = [];

        if ($title)
        {
            $updatesArray['title'] = $title;
        }

        if ($details)
        {
            $updatesArray['details'] = $details;
        }

        if ($userId)
        {
            $updatesArray['user_id'] = $userId;
        }

        if ($statusId)
        {
            $updatesArray['status_id'] = $statusId;
        }

        if ($sprintId)
        {
            $updatesArray['sprint_id'] = $sprintId;
        }

        return $builder->update($updatesArray);
    }

    public function deleteTask(int $taskId)
    {
        $task = Task::find($taskId);

        if ($task)
        {
            return $task->delete();
        }

        return false;
    }

    public function getProjectList(int $page, int $perPage)
    {
        return Project::latest()->paginate($perPage, page: $page);
    }

    public function updateProject(mixed $project_id, mixed $name, mixed $description)
    {
        $builder = Project::where('id', $project_id);

        $updatesArray = [];

        if ($name)
        {
            $updatesArray['name'] = $name;
        }

        if ($description)
        {
            $updatesArray['description'] = $description;
        }

        return $builder->update($updatesArray);
    }

    public function getProjectById(mixed $project_id)
    {
        return Project::find($project_id);
    }

    public function deleteProject(mixed $projectId)
    {
        $project = Project::find($projectId);

        if ($project)
        {
            return $project->delete();
        }

        return false;
    }
}
