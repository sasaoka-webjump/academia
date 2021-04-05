<?php

namespace App\Controllers;

use App\Repositories\TransactionRepository;
use App\Repositories\CustomerRepository;

class TransactionController
{
    /**
     * @var \App\Repositories\TransactionRepository
     */
    protected $transactionRepository;

    /**
     * @var \App\Repositories\CustomerRepository
     */
    protected $customerRepository;

    /**
     * @param \App\Repositories\CustomerRepository $customerRepository
     * @param \App\Repositories\TransactionRepository $transactionRepository
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository, TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Withdraw an amount from the authenticated user
     */
    public function withdraw()
    {
        $value = input()->post('value')->getValue();
        $customer = request()->authCustomer;

        $this->transactionRepository->withdraw($customer, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        return response()->httpCode(200)->json([
            'message' => 'Withdraw completed with success',
            'newBalance' => $balance
        ]);
    }

    /**
     * Return the authenticated user's balance
     */
    public function balance()
    {
        $customer = request()->authCustomer;
        $balance = $this->transactionRepository->getBalance($customer);

        return response()->httpCode(200)->json([
            'balance' => $balance
        ]);
    }

    /**
     * Deposit an amount to the authenticated user's founds
     */
    public function deposit()
    {
        $customer = request()->authCustomer;
        $value = input()->post('value')->getValue();

        $this->transactionRepository->deposit($customer, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        return response()->httpCode(200)->json([
            'newBalance' => $balance
        ]);
    }

    /**
     * transfer an amount from the authenticated user's founds to another customer
     * 
     * @param int $destinationCustomerId
     */
    public function transfer(int $destinationCustomerId)
    {
        $customer = request()->authCustomer;
        $value = input()->post('value')->getValue();

        $this->transactionRepository->transfer($customer, $destinationCustomerId, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        return response()->httpCode(200)->json([
            'newBalance' => $balance
        ]);
    }
}
