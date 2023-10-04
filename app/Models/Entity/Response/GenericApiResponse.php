<?php

namespace App\Models\Entity\Response;

abstract class GenericApiResponse
{
    public bool $status = false;

    public string $message;

    public string $errorType;
    public string $errorMessage;

    public array $data;
}
