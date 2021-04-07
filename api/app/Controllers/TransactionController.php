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
        $requestData = input()->all([
            'value'
        ]);
        $value = $requestData['value'];

        $customer = request()->authCustomer;

        $this->transactionRepository->withdraw($customer, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Withdraw', [$customer, $value]);

        return response()->json([
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

        return response()->json([
            'balance' => $balance
        ]);
    }

    /**
     * Deposit an amount to the authenticated customer's founds
     */
    public function deposit()
    {
        $requestData = input()->all([
            'value'
        ]);
        $value = $requestData['value'];

        $customer = request()->authCustomer;

        $this->transactionRepository->deposit($customer, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Deposit', [$customer, $value]);

        return response()->json([
            'newBalance' => $balance
        ]);
    }

    /**
     * transfer an amount from the authenticated customer's founds to another customer
     * 
     * @param string $destinationAccountNumber
     */
    public function transfer(string $destinationAccountNumber)
    {
        $requestData = input()->all([
            'value'
        ]);
        $value = $requestData['value'];
        
        $customer = request()->authCustomer;

        $this->transactionRepository->transfer($customer, $destinationAccountNumber, $value);
        $balance = $this->transactionRepository->getBalance($customer);

        $this->logger->warn('Transfer [$customer, $destinationAccountNumber, $value]', [$customer, $destinationAccountNumber, $value]);


        return response()->json([
            'newBalance' => $balance
        ]);
    }
}
