<?php

namespace App\Models\Entity\Response;

use App\Models\Task;
use stdClass;

class TaskManagerServiceResponse
{
    public bool $status = false;

    public string $message;

    public string $errorType;
    public string $errorMessage;

    public array $data;
}