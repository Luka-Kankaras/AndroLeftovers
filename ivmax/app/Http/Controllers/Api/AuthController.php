<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Exceptions\ServerErrorException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @throws ServerErrorException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request->email)->first();
        if (! $user->hasRole('user')) {
            return response()->json([
                'message' => 'Access forbiden',
            ], Response::HTTP_FORBIDDEN);
        }

        $this->storeFirebaseTokenForUser($request->fcmToken);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ], Response::HTTP_OK);
    }

    private function storeFirebaseTokenForUser($fcmToken)
    {
        try {
            FirebaseToken::query()
                ->create([
                    'user_id' => auth('api')->id(),
                    'fcm_token' => $fcmToken,
                ]);
        } catch (Exception $e) {
            throw new ServerErrorException($e);
        }
    }
}
