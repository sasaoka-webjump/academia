<?php

use App\Router;

Router::csrfVerifier(new \App\Middlewares\CsrfVerifier());

Router::post('/customers/store', 'CustomerController@store');

Router::group(['prefix' => '/api/', 'middleware' => \App\Middlewares\ApiVerification::class], function () {
    Router::get('/', 'HealthController@hello');

    Router::get('/customers', 'CustomerController@index');
    Router::get('/customers/{id}', 'CustomerController@show');
});
