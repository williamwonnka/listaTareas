<?php

namespace App\Components;

class RequestHandler
{
    /**
    * Subtract all the data from constant to use in API in an ordered way
    * @param $constant array the constant received like $_POST, $_REQUEST or $_GET
    * @param $fieldsToSubtract array the fields to use inside the endpoint
    * @return array the data ordered and standardized to use in endpoint
    */
    public static function subtractDataFromConstant(array $constant, array $fieldsToSubtract): array
    {
        $dataSubtracted = [];

        foreach ($fieldsToSubtract as $field => $value)
        {
            if(isset($constant[$field]))
                $dataSubtracted[$field] =  $constant[$field];
        }

        return $dataSubtracted;
    }
}
