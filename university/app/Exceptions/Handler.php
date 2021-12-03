<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\APIResponder;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use APIResponder;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->renderable(function (ModelNotFoundException $e, $request) {
            return $this->error([
                'title' => 'Error: Not Found',
                'detail' => 'Record for '.$e->getModel().' not found.',
                'type' => $e->getModel(),
            ], 404);
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return $this->error([
                'title' => 'Error: Not Found',
                'detail' => $e->getMessage(),
                'type' => 'notfound\error',
            ], 404);
        });
        $this->renderable(function (ValidationException $e, $request) {
            return $this->error([
                'title' => 'Error: Invalid data',
                'detail' => $e->errors(),
                'type' => 'validation\error',
            ], $e->status);
        });
        $this->renderable(function (AuthenticationException $e, $request) {
            return $this->error([
                'title' => 'Error: Unauthenticated',
                'detail' => implode(',', $e->guards()),
                'type' => 'auth\error',
            ], 401);
        });
    }
}
