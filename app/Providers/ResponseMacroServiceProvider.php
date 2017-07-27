<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('success', function ($data = null, $status = 200) {
            return Response::json([
                'data' => $data,
            ], $status);
        });

        Response::macro('error', function ($error, $status = 400) {
            return Response::json([
                'error' => $error,
            ], $status);
        });

        Response::macro('not_found', function () {
            return Response::json([
                'error' => 'Resource not found.',
            ], 404);
        });
    }
}
