<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twom\Responder\Facade\Responder;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Exception $exception
     *
     * @return JsonResponse|Response
     * @throws \Throwable
     */
    public function render($request, $exception)
    {
        // check exception type
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException)
            return $this->NotFoundExceptionMessage($request, $exception);

        if ($exception instanceof AuthorizationException)
            return Responder::respondUnAuthorizedError();

        if (!env("APP_DEBUG", true))
            return $request->expectsJson()
                ? Responder::respondInternalError()
                : parent::render($request, $exception);

        return parent::render($request, $exception);
    }


    /**
     * return not found response error
     *
     * @param           $request
     * @param Exception $exception
     *
     * @return ResponseFactory|Response
     * @throws \Throwable
     */
    public function NotFoundExceptionMessage($request, Exception $exception)
    {
        return $request->expectsJson() ? Responder::respondNotFound() : parent::render($request, $exception);
    }


    /**
     * @param Request $request
     * @param AuthenticationException  $exception
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson() ? Responder::respondUnauthorizedError() : redirect()->guest($exception->redirectTo() ?? route('login'));
    }


    /**
     * customize validation error message
     *
     * @param Request $request
     * @param ValidationException      $exception
     *
     * @return ResponseFactory|JsonResponse|RedirectResponse|Response
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return $request->expectsJson() ? Responder::respondValidationError($exception->errors()) : redirect()->guest($exception->redirectTo() ?? route('422'));
    }
}
