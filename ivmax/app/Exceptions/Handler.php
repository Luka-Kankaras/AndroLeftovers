<?php

namespace App\Exceptions;

use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return redirect()->guest('login');
    }

    public function render($request, Throwable $e)
    {
        if (($e instanceof ModelNotFoundException ||
            $e instanceof RouteNotFoundException ||
            $e instanceof NotFoundHttpException ||
            $e instanceof UnauthorizedException) &&
            $request->wantsJson()
        ) {
            return \response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof MethodNotAllowedException && $request->wantsJson()) {
            return \response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($e instanceof AuthorizationException && $request->wantsJson()) {
            return \response()->json([
                'message' => 'You do not have required permissions to access this resource.',
            ], Response::HTTP_FORBIDDEN);
        }

        return parent::render($request, $e);
    }
}
