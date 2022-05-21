<?php


namespace App\Exceptions;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class ServerErrorException extends Exception
{
    protected $e;

    public function __construct(Exception $e)
    {
        $this->e = $e;
    }


    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->e->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
