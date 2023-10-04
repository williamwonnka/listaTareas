<?php

namespace App\Service;

use App\Models\Entity\Response\ProjectManagerServiceResponse;
use App\Models\Entity\Response\TaskManagerServiceResponse;
use App\Repository\ProjectManagerRepository;
use App\Repository\TaskManagerRepository;

class ProjectManagerService
{
    protected ProjectManagerRepository $projectManagerRepository;

    public function __construct(ProjectManagerRepository $projectManagerRepository = null)
    {
        $this->projectManagerRepository = $projectManagerRepository ?? new ProjectManagerRepository();
    }

    public function createProject(string $name, string $description)
    {
        $response = new ProjectManagerServiceResponse();

        $result = $this->projectManagerRepository->createProject($name, $description);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Project created';
            $response->data = $result->toArray();

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Project not created';

            return $response;
        }
    }

    public function getProjectList(int $page, int $perPage)
    {
        return $this->projectManagerRepository->getProjectList($page, $perPage);
    }

    public function updateProject(mixed $project_id, mixed $name, mixed $description)
    {
        $response = new ProjectManagerServiceResponse();

        $result = $this->projectManagerRepository->updateProject($project_id, $name, $description);

        $projectUpdated = $this->projectManagerRepository->getProjectById($project_id);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Project updated';
            $response->data = $projectUpdated->toArray();

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Project not updated';

            return $response;
        }
    }

    public function deleteProject(mixed $projectId)
    {
        $response = new ProjectManagerServiceResponse();

        $result = $this->projectManagerRepository->deleteProject($projectId);

        if ($result)
        {
            $response->status = true;
            $response->message = 'Project deleted';

            return $response;
        }
        else
        {
            $response->status = false;
            $response->errorType = 'internal_error';
            $response->errorMessage = 'Project not deleted';

            return $response;
        }
    }


}
