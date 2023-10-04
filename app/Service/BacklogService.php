<?php

namespace App\Service;

use App\Models\Entity\Response\SprintServiceResponse;
use App\Models\Sprint;
use App\Repository\BacklogRepository;

class BacklogService
{
    private BacklogRepository $backlogRepository;

    public function __construct(BacklogRepository $backlogRepository)
    {
        $this->backlogRepository = $backlogRepository;
    }

    public function createSprint(mixed $name, mixed $start_date, mixed $end_date, mixed $project_id)
    {
        $response = new SprintServiceResponse();

        $result = $this->backlogRepository->createSprint($name, $start_date, $end_date, $project_id);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Sprint created successfully';
            $response->data = $result->toArray();
        }
        else
        {
            $response->message = 'Failed to create sprint';
            $response->errorType = 'internal';
            $response->errorMessage = 'Failed to create sprint';
        }

        return $response;
    }

    public function getSprintListWithTasks(mixed $projectId)
    {
        $response = new SprintServiceResponse();

        $sprints = $this->backlogRepository->getSprintListWithTasks($projectId);

        $sprintsArray['Sprints'] = [];

        // adding tasks with sprint

        for($i = 0; $i < count($sprints); $i++)
        {
            $tasks = $sprints->get($i)->tasks()->get();

            $sprintsArray['Sprints'][$i] = $sprints->get($i)->toArray();

            $sprintsArray['Sprints'][$i]['tasks'] = $tasks->toArray();
        }

        // adding tasks without sprint

        $sprintsArray['TasksWithoutSprint'] = $this->backlogRepository->getTasksWithoutSprint();

        if ($sprintsArray)
        {
            $response->status = true;
            $response->message = 'Sprint list with tickets retrieved successfully';
            $response->data = $sprintsArray;
        }
        else
        {
            $response->message = 'Failed to retrieve sprint list with tickets';
            $response->errorType = 'internal';
            $response->errorMessage = 'Failed to retrieve sprint list with tickets';
        }

        return $response;
    }

    public function updateSprint(mixed $sprintId, mixed $name, mixed $startDate, mixed $endDate)
    {
        $response = new SprintServiceResponse();

        $result = $this->backlogRepository->updateSprint($sprintId, $name, $startDate, $endDate);

        $sprint = $this->backlogRepository->getSprintById($sprintId);

        if ($sprint)
        {
            $response->status = true;
            $response->message = 'Sprint updated successfully';
            $response->data = $sprint->toArray();
        }
        else
        {
            $response->message = 'Failed to update sprint';
            $response->errorType = 'internal';
            $response->errorMessage = 'Failed to update sprint';
        }

        return $response;
    }

    public function deleteSprint(mixed $sprintId)
    {
        $response = new SprintServiceResponse();

        $result = $this->backlogRepository->deleteSprint($sprintId);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Sprint deleted successfully';
        }
        else
        {
            $response->status = false;
            $response->message = 'Failed to delete sprint';
            $response->errorType = 'internal';
            $response->errorMessage = 'Failed to delete sprint';
        }

        return $response;
    }
}
