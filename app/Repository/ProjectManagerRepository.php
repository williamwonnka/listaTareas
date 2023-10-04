<?php

namespace App\Repository;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Support\Collection;

class ProjectManagerRepository
{
    public function createProject(string $name, string $description)
    {
        $project = new Project();

        $project->name = $name;
        $project->description = $description;

        $project->save();

        return $project->refresh();
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
