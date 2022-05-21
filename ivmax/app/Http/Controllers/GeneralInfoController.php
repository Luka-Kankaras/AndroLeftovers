<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralInfoRequest;
use App\Models\GeneralInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GeneralInfoController extends Controller {


    public function index(Request $request): JsonResponse {

        return response()->json(GeneralInfo::query()->getAll($request), ResponseAlias::HTTP_OK);

    }

    public function store(GeneralInfoRequest $request): JsonResponse {

        $info = GeneralInfo::query()->create($request->validated());

        return response()->json($info, ResponseAlias::HTTP_OK);

    }

    public function update(GeneralInfoRequest $request, GeneralInfo $generalInfo): JsonResponse {

        $generalInfo->update($request->validated());

        return response()->json($generalInfo, ResponseAlias::HTTP_OK);

    }

    public function destroy(GeneralInfo $generalInfo) : Response {

        $generalInfo->delete();

        return \response()->noContent();

    }
}
