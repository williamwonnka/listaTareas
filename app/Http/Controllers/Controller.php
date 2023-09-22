<?php

namespace App\Http\Controllers;

use App\Components\RequestHandler;
use App\Models\Entity\Response\BaseControllerResponse;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponse;

    protected function validateParameters($rules, $dataReceived): BaseControllerResponse
    {
        $return = new BaseControllerResponse();

        $validator = Validator::make($dataReceived, $rules);

        if ($validator->fails())
        {
            $errorsArray = [];

            foreach ($validator->errors()->messages() as $error)
            {
                $errorsArray[] = array(
                    'detail' => $error[0],
                    'errorType' => 'missingParameter'
                );
            }

            $return->status = false;
            $return->data = $errorsArray;

            return $return;
        }

        //variable ta handle all the data from API avoiding using $_POST, $_REQUEST or $_GET
        $apiDataReceived = RequestHandler::subtractDataFromConstant($dataReceived, $rules);

        $return->data = $apiDataReceived;

        return $return;
    }
}
