<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\Access\AuthorizationException::class,
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->expectsJson()){
            if($exception instanceof \Illuminate\Auth\Access\AuthorizationException){
                return response()->json([
                    'message' => 'Your credential is not valid'
                ], 401);
            }
            if($exception instanceof Symfony\Component\HttpKernel\Exception){
                return response()->json([
                    'message' => 'Page is not found'
                ], 404);
            }
            if($exception instanceof Illuminate\Database\Eloquent\ModelNotFoundException){
                $modelClass = explode('\\', $exception->getModel());

                return response()->json([
                    'message' => end($modelClass) . ' Not Found',
                ], 404);
            }
        }
        return parent::render($request, $exception);
    }
}
