<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use MichaelAChrisco\ReadOnly\ReadOnlyException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        //\Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,

    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
        $msg = '';

        // if($exception instanceof \ErrorException ){
        //     $msg= explode('(',$exception->getMessage())[0];
        //     return back()
        //         ->with('alert.status', 'danger')
        //         ->with('alert.message', 'Error: '."".$msg);
        // }

        // if($exception instanceof \Illuminate\Database\QueryException )
        // {

        //     if (\App::environment('development', 'local'))
        //     {
        //         $msg = $exception->getMessage();
        //     }

        //     if(isset($exception->errorInfo[0]) && isset($exception->errorInfo[1]) && count($exception->errorInfo)==3)
        //     {
        //         if(isset($exception->errorInfo[0]) && isset($exception->errorInfo[1]) && isset($exception->errorInfo[2]) && $exception->errorInfo[0]=="42000" && $exception->errorInfo[1]=="1142")
        //         {
        //             $msg = explode("@",$exception->errorInfo[2])[0];
        //         }

        //         if ($exception->getCode() == "42000")
        //         {
        //             return back()
        //                 ->with('alert.status', 'danger')
        //                 ->with('alert.message', 'You are not allowed at this moment'.". ".$msg);
        //         }

        //     }
        // }


        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {


        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }


}