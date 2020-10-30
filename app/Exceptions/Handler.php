<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        BusinessException::class,
        AppException::class,
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
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        switch (true) {
            case $exception instanceof AppException:
            case $exception instanceof ModelNotFoundException:
                $response['message'] = $exception->getMessage();
                $response['status_code'] = $exception->getCode();

            break;

            case $exception instanceof UnauthorizedHttpException:
                $response['message'] = __('auth.unauthenticated');
                $response['status_code'] = Response::HTTP_UNAUTHORIZED;

            break;

            case $exception instanceof UnauthorizedException || $exception instanceof \Illuminate\Validation\UnauthorizedException:
                $response['message'] = __('auth.unauthorized');
                $response['status_code'] = Response::HTTP_FORBIDDEN;

            break;

            case $exception instanceof ValidationException:
                $response['message'] = __('messages.VALIDATION_EXCEPTION');
                $response['status_code'] = Response::HTTP_UNPROCESSABLE_ENTITY;
                $response['meta']['errors'] = $exception->errors();

            break;

            case $exception instanceof AuthorizationException:
                $response['message'] = $exception->getMessage();
                $response['status_code'] = $exception->getCode() ?: Response::HTTP_FORBIDDEN;

            break;

            case $this->isHttpException($exception):
                $response['message'] = $exception->getMessage();
                $response['status_code'] = $exception->getStatusCode();

            break;

            default:
                $response['message'] = config('app.debug') ? $exception->getMessage() : __('messages.GLOBAL_EXCEPTION');
                $response['status_code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if (config('app.debug')) {
            $response['debug'] = $this->formatDebugResponse($exception);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * Format a default response exceptions.
     *
     * @param Throwable $exception
     * @return array
     */
    protected function formatDebugResponse(Throwable $exception)
    {
        return [
            'line' => $exception->getLine(),
            'file' => $exception->getFile(),
            'class' => get_class($exception),
            'trace' => $exception->getTrace(),
        ];
    }
}
