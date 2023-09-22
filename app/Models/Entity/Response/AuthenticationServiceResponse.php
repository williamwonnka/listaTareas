<?php

namespace App\Models\Entity\Response;

use stdClass;

class AuthenticationServiceResponse
{
    public bool $status = false;

    public string $message;

    public string $errorType;
    public string $errorMessage;

    public int $userId;
}
