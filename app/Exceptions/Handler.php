<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        //$this->reportable(function (Throwable $e) {
            //
        //});

        $this->renderable(function (NotFoundHttpException $e, $request) {
            $cekmobile = strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
            $cekwv = strpos($_SERVER['HTTP_USER_AGENT'],'wv');
            if ($cekmobile !== false && $cekwv !== false)
            {
                return response()->view('errors.'.'404_mobile', [], 404);
            }
            else
            {
                return response()->view('errors.'.'404', [], 404);
            }
        });
    }

    /**
     *` Render an exception into an HTTP response.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Exception  $exception
    * @return \Illuminate\Http\Response
    */
    // public function render($request, Exception $exception)
    // {
    //     if ($this->isHttpException($exception)) {
    //         if ($exception->getStatusCode() == 404) {
    //             $cekmobile = strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
    //             $cekwv = strpos($_SERVER['HTTP_USER_AGENT'],'wv');
    //             if ($cekmobile !== false && $cekwv !== false)
    //             {
    //                 return response()->view('errors.'.'404_mobile', [], 404);
    //             }
    //             else
    //             {
    //                 return response()->view('errors.'.'404', [], 404);
    //             }
    //         }
    //     }

    //     return parent::render($request, $exception);
    // }`
}
