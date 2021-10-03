<?php

namespace App\Exceptions;

use App\Traits\ResponseHelper;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseHelper;

    const FOREIGN_KEY_VIOLATION_CODE = 1451;
    const DB_CONNECTION_FAILED = 2002;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }
        if ($e instanceof ModelNotFoundException) {
            $className = class_basename($e->getModel());
            return $this->errorResponse(
                "$className does not exist with the specified key",
                404
            );
        }
        if ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }
        if ($e instanceof AuthorizationException) {
            return $this->errorResponse(
                $e->getMessage(),
                403
            );
        }
        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse(
                "The Specified URL cannot be found",
                404
            );
        }
        if ($e instanceof MethodNotAllowedException) {
            return $this->errorResponse(
                "The Specified Method for the request is invalid",
                405
            );
        }
        if ($e instanceof HttpException) {
            return $this->errorResponse(
                $e->getMessage(),
                $e->getStatusCode()
            );
        }
        if ($e instanceof QueryException) {
            $sqlErrorCode = $e->errorInfo[1];
            if ($sqlErrorCode == self::FOREIGN_KEY_VIOLATION_CODE) {
                return $this->errorResponse(
                    "Cannot remove this resource permanently, as it is referred by some other resource",
                    409
                );
            }
            if ($sqlErrorCode == self::DB_CONNECTION_FAILED) {
                return $this->errorResponse(
                    "Our Database Server is down, Please try after some time",
                    500
                );
            }
            return $this->errorResponse(
                $e->getMessage(),
                403
            );
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }
        return $this->errorResponse(
            "Unexpected Server Error",
            500
        );

    }


    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($this->isFrontEnd($request)) {
            if ($request->ajax()) {
                return $this->reportMultipleErrors($e->errors(), 422);
            }
            return redirect()->back()->withInput($request->input())->withErrors($e->errors());
        }
        return $this->reportMultipleErrors($e->errors(), 422);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFrontEnd($request)) {
            return redirect()->guest('login');
        }
        return $this->errorResponse("Unauthenticated", 401);
    }

    private function isFrontEnd(Request $request) : bool
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
