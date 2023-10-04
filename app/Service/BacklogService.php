<?php

namespace App\Service;

use App\Models\Entity\Response\SprintServiceResponse;
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
}
