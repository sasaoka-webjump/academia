<?php

use App\Router;

Router::csrfVerifier(new \App\Middlewares\CsrfVerifier());

Router::post('/customers/store', 'CustomerController@store');
Router::post('/login', 'AuthController@login');

Router::group(['prefix' => '/api/', 'middleware' => \App\Middlewares\ApiVerification::class], function () {
    Router::get('/', 'HealthController@hello');

    Router::get('/customers', 'CustomerController@index');
    Router::get('/customers/{id}', 'CustomerController@show');

    Router::post('/customer/withdraw', 'TransactionController@withdraw');
    Router::get('/customer/balance', 'TransactionController@balance');
    Router::post('/customer/deposit', 'TransactionController@deposit');
    Router::post('/customer/transfer/{destinationCustomerId}', 'TransactionController@transfer');
});
