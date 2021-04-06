<?php

namespace App\Controllers;

class CustomerController
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
    public function __construct(\App\Repositories\CustomerRepository $customerRepository, \App\Logger $logger)
    {
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
    }

    /**
     * @return string|null
     */
    public function index()
    {
        $customers = $this->customerRepository->all();

        $this->logger->warn('Listed all customers');

        return response()->json([
            'customers' => $customers
        ]);
    }

    /**
     * @return string|null
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findOrFail($id);

        $this->logger->warn('Showed a customer', [$customer]);

        return response()->json([
            'customer' => $customer
        ]);
    }

    /**
     * @return string|null
     */
    public function store()
    {
        $newCustomer = $this->customerRepository->create(input()->all());

        $this->logger->warn('Stored a customer', [$newCustomer]);

        return response()->json([
            'data' => $newCustomer
        ]);
    }
}
