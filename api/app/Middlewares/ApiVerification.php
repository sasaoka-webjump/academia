<?php

namespace App\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use App\Models\Customers\Customer;

class ApiVerification implements IMiddleware
{
    public function handle(Request $request): void
    {
        $accountNumber = $request->getUser();
        $password = $request->getPassword();

        $customer = Customer::where('accountNumber', $accountNumber)->first();

        $passwordMatched = $customer && ($customer->password == md5($password));

        if ($passwordMatched) {
            // header('Access-Control-Allow-Origin: *');
            // header('Access-Control-Allow-Methods: GET, POST');
            // header("Access-Control-Allow-Headers: X-Requested-With");
            $request->authenticated = true;
            $request->authCustomer = $customer;
        } else {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            $request->authenticated = false;
            exit;
        }
    }
}
