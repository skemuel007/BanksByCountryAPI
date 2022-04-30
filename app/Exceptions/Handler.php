<?php

namespace App\Exceptions;

use App\Traits\ResponseAPI;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseAPI;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function(Exception $ex) {
            // This will replace 404 response from the MVC to a JSON response
            if($ex instanceof ModelNotFoundException)
            {
                return $this->error($ex->getMessage(), 404);
            }
            // https://stackoverflow.com/questions/53279247/laravel-how-to-show-json-when-api-route-is-wrong-or-not-found
            if($ex instanceof NotFoundHttpException ) {
                return $this->error($ex->getMessage(), 404);
            }

            if($ex instanceof NotFoundResourceException ) {
                return $this->error($ex->getMessage(), 404);
            }

            if($ex instanceof BindingResolutionException ) {
                return $this->error($ex->getMessage(), 500);
            }

            if($ex instanceof MethodNotAllowedException ) {
                return $this->error($ex->getMessage(), 500);
            }

            if($ex instanceof UnauthorizedHttpException ) {
                return $this->error($ex->getMessage(), 401);
            }

            if($ex instanceof UnauthorizedException ) {
                return $this->error($ex->getMessage(), 401);
            }

            if($ex instanceof InvalidArgumentException ) {
                return $this->error($ex->getMessage(), 400);
            }
        });
    }
}
