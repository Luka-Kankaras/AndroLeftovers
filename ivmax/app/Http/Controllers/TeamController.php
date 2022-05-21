<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TeamController extends Controller {


    public function index(Request $request): JsonResponse {

        return response()->json(Team::query()->getAll($request), Response::HTTP_OK);

    }


    public function store(TeamRequest $request): JsonResponse {

        $team = Team::query()->create($request->validated());

        return response()->json($team, ResponseAlias::HTTP_OK);

    }


    public function update(TeamRequest $request, Team $team) : JsonResponse {

        $team->update($request->validated());

        return response()->json($team, ResponseAlias::HTTP_OK);

    }


    public function destroy(Team $team) {

        try {
            $team->delete();
        }
        catch (\Exception $e){
            return response()->json('Team member can not be deleted while is bound to other fields.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return response()->noContent();
    }


    public function selectMembers() : JsonResponse {

        $data = Team::all();

        return response()->json(TeamResource::collection($data));

    }

}
