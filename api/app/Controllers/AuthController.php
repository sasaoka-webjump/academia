<?php

namespace App\Controllers;

use App\Repositories\CustomerRepository;
use App\Exceptions\PasswordNotMatchException;
use App\Logger;

class AuthController
{

    /**
     * @var \App\Repositories\CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var \App\Logger
     */
    protected $logger;

    /**
     * @param \App\Repositories\CustomerRepository $customerRepository
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository, Logger $logger)
    {
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    /**
     * Verifies the customer credentials to allow access or to block it.
     * @throws \App\Exceptions\PasswordNotMatchException;
     */
    public function login()
    {
        $requestData = input()->all([
            'accountNumber',
            'password'
        ]);
        $accountNumber = $requestData['accountNumber'];
        $password = $requestData['password'];

        $customer = $this->customerRepository->findByAccountNumberOrFail($accountNumber);

        $passwordMatched = $customer && ($customer->password === md5($password));

        if ($passwordMatched) {
            $this->logger->warn('Successfully logged in', [$customer]);

            response()->httpCode(200)->json([
                'token' => base64_encode($accountNumber . ':' . $password),
                'customerId' => $customer->id
                ]);
        } else {
            $this->logger->warn('Login failed: password did not match', [$customer]);

            throw new PasswordNotMatchException();
        }
    }
}
