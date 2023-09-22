<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * source
     * https://developer.mozilla.org/es/docs/Web/HTTP/Status
     */

    /**
     * Everything is ok
     */
    protected $infoContinue = 100;

    /**
     * The server accepts the protocol change
     */
    protected $infoSwitchingProtocol = 101;

    /**
     * The server has received the request and is still processing
     */
    protected $infoProcessing = 102;

    /**
     * Eyerything is working
     */
    protected $success = 200;

    /**
     * New resource has been created
     */
    protected $successCreated = 201;

    /**
     * The request has been received, but has not yet been acted
     */
    protected $successAccepted = 202;

    /**
     * The request has been successfully completed, but its content
     * has not been obtained from the source originally requested
     */
    protected $successNonAuthoritative = 203;

    /**
     * The resource was successfully deleted
     */
    protected $successDeleted = 204;

    /**
     * The request was invalid or cannot be served.
     * The exact error should be explained in the error payload. E.g. "The JSON is not valid"
     */
    protected $errorBadRequest = 400;

    /**
     * The request requires an user authentication
     */
    protected $errorUnauthorized = 401;

    /**
     * The server understood the request, but is refusing it or the access is not allowed.
     */
    protected $errorForbidden = 403;

    /**
     * There is no resource behind the URI.
     */
    protected $errorNotFound = 404;

    /**
     * Should be used if the server cannot process the enitity, E.g. if an image cannot be formatted or mandatory fields are missing in the payload.
     */
    protected $errorUnprocessableEntity = 422;

    /**
     * There is not status detected on the request.
     */
    protected $errorUnknownStatus = 419;

    /**
     * If an error occurs in the global catch blog, the stracktrace should be logged and not returned as response.
     */
    protected $fatalInternalServerError = 500;

    /**
     * Return a plain JSON response.
     *
     * @param  mixed $data
     * @param int|null $statusCode
     * @return JsonResponse
     */
    public function return($data, int $statusCode = null): JsonResponse
    {
		return response()->json($data, $statusCode ?: $this->success);
	}

    /**
     * Return a standar JSON response.
     *
     * @param  mixed  $data
     * @param string|null $message
     * @param int|null $statusCode
     * @return JsonResponse
     */
    public function response($data, string $message = null, int $statusCode = null): JsonResponse
    {
        $statusCode = $statusCode ?: $this->success;

        $response   = [
			'status'  => $this->getStatusName($statusCode),
			'message' => $message,
            'data'    => []
		];

        if($data instanceof LengthAwarePaginator){

            $meta = $data->toArray();
            $data = $meta['data'];
            unset($meta['data']);

            $response['metadata'] = (object)$meta;
        }
        $response['data'] = empty($data) ? [] : (!is_array($data) ? [$data] : $data);

		return response()->json($response, $statusCode ?: $this->success);
	}

    /**
     * Return a error JSON response.
     *
     * @param mixed|array $errors
     * @param int|null $statusCode
     * @return JsonResponse
     * @throws Exception When a field is missing throws a JsonApiStandardFail exception
     */
	public function error($errors = null, int $statusCode = null): JsonResponse
    {
        $statusCode = $statusCode ?: $this->success;

        $errorsArray     = is_null($errors) || empty($errors) ? [] : (!is_array($errors) ? [$errors] : $errors);
        $isSingleArray = true;
        foreach ($errorsArray as $error)
        {
            if(gettype($error) != 'string' )
            {
                $isSingleArray = false;
            }
        }
        if($isSingleArray)
        {
            if(!array_key_exists('errorType', $errorsArray))
            {
                throw new Exception('JsonApiStandardFail::errorType');
            }

            if(!array_key_exists('detail', $errorsArray))
            {
                throw new Exception('JsonApiStandardFail::detail');
            }
        }
        else
        {
            foreach($errorsArray as $error)
            {
                if(!array_key_exists('errorType', $error))
                {
                    throw new Exception('JsonApiStandardFail::errorType');
                }

                if(!array_key_exists('detail', $error))
                {
                    throw new Exception('JsonApiStandardFail::detail');
                }
            }
        }

		return response()->json([
			'status'  => $this->getStatusName($statusCode),
			'errors'  => $errorsArray
		], $statusCode);
	}

    /**
     * Return a JSON response with success status code.
     *
     * @param  mixed  $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function success($data = [], string $message = null): JsonResponse
    {
		return $this->response($data, $message, 200);
	}

    /**
     * Return a JSON response with created status code.
     *
     * @param  mixed  $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function created($data, string $message = null): JsonResponse
    {
		return $this->response($data, $message, $this->successCreated);
	}

    /**
     * Return a JSON response with bad request status code.
     *
     * @param null $errors
     * @return JsonResponse
     * @throws Exception
     */
    public function badRequest($errors = null): JsonResponse
    {
		return $this->error($errors, $this->errorBadRequest);
	}

    /**
     * Return a JSON response with unauthorized status code.
     *
     * @param null|mixed $errors
     * @return JsonResponse
     * @throws Exception
     */
    public function unauthorized($errors = null): JsonResponse
    {
		return $this->error($errors, $this->errorUnauthorized);
	}

    /**
     * Return a JSON response with forbidden status code.
     *
     * @param null $errors
     * @return JsonResponse
     * @throws Exception
     */
    public function forbidden($errors = null): JsonResponse
    {
		return $this->error($errors, $this->errorForbidden);
	}

    /**
     * Return a JSON response with not found status code.
     *
     * @param null $errors
     * @return JsonResponse
     * @throws Exception
     */
    public function notFound($errors = null): JsonResponse
    {
		return $this->error($errors, $this->errorNotFound);
	}

    /**
     * Return a JSON response with fatal internal server error status code.
     *
     * @param null $errors
     * @return JsonResponse
     * @throws Exception
     */
    public function fatalError($errors = null): JsonResponse
    {
		return $this->error($errors, $this->fatalInternalServerError);
	}

    /**
     * @param $code int
     * @return string name of the status
     */
    private function getStatusName(int $code): string
    {
        if ($code >= 100 && $code <= 299)
            return "success";

        if ($code >= 300 && $code <= 499)
            return "fail";

        if ($code >= 500 && $code <= 599)
            return "error";

        return "unknown";
    }
}
