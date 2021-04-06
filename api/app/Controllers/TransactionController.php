<?php

namespace App\Controllers;

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
     * @var \App\Logger
     */
    protected $logger;

    /**
     * @param \App\Repositories\CustomerRepository $customerRepository
     * @param \App\Repositories\TransactionRepository $transactionRepository
     * @return void
     */
    public function __construct(
        \App\Repositories\CustomerRepository $customerRepository,
        \App\Repositories\TransactionRepository $transactionRepository,
        \App\Logger $logger
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    /**
     * Withdraw an amount from the authenticated customer
     */
    public function withdraw()
    {
        $value = input()->post('value')->getValue();
        $customer = request()->authCustomer;

        $this->transactionRepository->withdraw($customer, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Withdraw', [$customer, $value]);

        return response()->httpCode(200)->json([
            'message' => 'Withdraw completed with success',
            'newBalance' => $balance
        ]);
    }

    /**
     * Return the authenticated customer's balance
     */
    public function balance()
    {
        $customer = request()->authCustomer;
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Balance check', [$customer]);

        return response()->httpCode(200)->json([
            'balance' => $balance
        ]);
    }

    /**
     * Deposit an amount to the authenticated customer's founds
     */
    public function deposit()
    {
        $customer = request()->authCustomer;
        $value = input()->post('value')->getValue();

        $this->transactionRepository->deposit($customer, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Deposit', [$customer, $value]);

        return response()->httpCode(200)->json([
            'newBalance' => $balance
        ]);
    }

    /**
     * transfer an amount from the authenticated customer's founds to another customer
     * 
     * @param int $destinationCustomerId
     */
    public function transfer(int $destinationCustomerId)
    {
        $customer = request()->authCustomer;
        $value = input()->post('value')->getValue();

        $this->transactionRepository->transfer($customer, $destinationCustomerId, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Transfer [$customer, $destinationCustomerId, $value]', [$customer, $destinationCustomerId, $value]);


        return response()->httpCode(200)->json([
            'newBalance' => $balance
        ]);
    }
}
