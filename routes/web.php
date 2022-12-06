<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\MahasiswaController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Str;

$router->get(
    '/',
    function () use ($router) {
        return $router->app->version();
    }
);

$router->get(
    '/key',
    function () {
        return Str::random(32);
    }
);

$router->group(
    ['prefix' => 'auth'],
    function () use ($router) {
        $router->post(
            '/register',
            [
                'uses' => 'AuthController@register'
            ]
        );

        $router->post(
            '/login',
            ['uses' => 'AuthController@login']
        );
    }
);

$router->group(
    ['prefix' => 'mahasiswa'],
    function () use ($router) {
        $router->get(
            '/',
            [
                'uses' => 'MahasiswaController@getMahasiswas'
            ]
        );

        $router->get(
            '/profile',
            [
                'middleware' => 'jwt.auth',
                'uses' => 'MahasiswaController@getMahasiswaByToken'
            ]
        );

        $router->get(
            '/{nim}',
            [
                'uses' => 'MahasiswaController@getMahasiswaById'
            ]
        );

        $router->delete(
            "/{nim}",
            [
                'uses' => 'MahasiswaController@deleteMahasiswa'
            ]
        );
    }
);
