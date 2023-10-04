<?php

namespace App\Repository;

use App\Models\Sprint;
use App\Models\Task;

class BacklogRepository
{

    public function createSprint(mixed $name, mixed $start_date, mixed $end_date, mixed $project_id): Sprint
    {
        $sprint = new Sprint();

        $sprint->name = $name;
        $sprint->start_date = $start_date;
        $sprint->end_date = $end_date;
        $sprint->project_id = $project_id;

        $sprint->save();

        return $sprint->refresh();
    }

    public function getSprintListWithTasks(mixed $projectId)
    {
        $sprintList = Sprint::whereProjectId($projectId)
            ->orderBy('id', 'asc')
            ->get();

        return $sprintList;
    }

    public function getTasksWithoutSprint()
    {
        return Task::whereSprintId(null)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
    }
}
