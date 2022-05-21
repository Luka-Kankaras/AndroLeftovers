<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomepageRequest;
use App\Models\Homepage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class HomepageController extends Controller {

    public function index() : JsonResponse {
        $data = Homepage::query()->first();

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(HomepageRequest $request, Homepage $homepage) : JsonResponse {
        $homepage->update($request->validated());

        return response()->json($homepage, Response::HTTP_OK);
    }

}
