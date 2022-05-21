<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class BadActionException extends Exception
{
    protected $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->validator->errors()->first(),
        ], Response::HTTP_BAD_REQUEST);
    }
}
