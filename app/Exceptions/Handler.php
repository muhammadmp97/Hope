<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $authenticationException) {
            return $authenticationException->redirectTo() ?
                redirect($authenticationException->redirectTo()) :
                response()->json([
                    'errors' => null,
                    'meta' => [
                        'message' => 'Authentication failed',
                        'error_id' => null,
                    ],
                ])->setStatusCode(401);
        });

        $this->renderable(function (NotFoundHttpException $notFoundHttpException) {
            return response()->json([
                'errors' => [],
                'meta' => [
                    'message' => 'The resource was not found',
                    'error_id' => null,
                ],
            ])->setStatusCode(404);
        });

        $this->renderable(function (ValidationException $validationException) {
            return response()->json([
                'errors' => $validationException->errors(),
                'meta' => [
                    'message' => 'Request is not valid',
                    'error_id' => null,
                ],
            ])->setStatusCode(422);
        });
    }
}
