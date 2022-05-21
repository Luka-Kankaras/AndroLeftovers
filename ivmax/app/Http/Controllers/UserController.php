<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller {

    public function index(Request $request) : JsonResponse {

        return response()->json([
            'users' => User::query()->getAll($request),
            'current_user' => auth()->user()
        ], Response::HTTP_OK);

    }

    public function store(UserRequest $request) : JsonResponse {

        $user = User::query()->create($request->validated());

        return response()->json($user, Response::HTTP_OK);

    }

    public function update(UserRequest $request, User $user) : JsonResponse {

        $user->update($request->validated());

        return response()->json($user, Response::HTTP_OK);

    }

    public function destroy(User $user) {

        try {
            if ($user->id != auth()->id())
                $user->delete();
        }
        catch (\Exception $e){
            return response()->json('User can not be deleted while is bound to other fields.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return response()->noContent();

    }

}
