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

    public function getSprintById(mixed $sprintId)
    {
        return Sprint::whereId($sprintId)
            ->first();
    }

    public function updateSprint(mixed $sprintId, mixed $name, mixed $startDate, mixed $endDate)
    {
        $builder = Sprint::whereId($sprintId);

        $updatesArray = [];

        if ($name != '' && $name != null)
        {
            $updatesArray['name'] = $name;
        }

        if ($startDate)
        {
            $updatesArray['start_date'] = $startDate;
        }

        if ($endDate)
        {
            $updatesArray['end_date'] = $endDate;
        }

        return $builder->update($updatesArray);
    }

    public function deleteSprint(mixed $sprintId)
    {
        $sprint = Sprint::find($sprintId);

        if ($sprint)
        {
            return $sprint->delete();
        }

        return false;
    }
}
