<?php

namespace App\Controllers;

use App\Repositories\CustomerRepository;

class CustomerController
{
    /**
     * @var \App\Repositories\CustomerRepository
     */
    protected $customerRepository;

    /**
     * @param \App\Repositories\CustomerRepository $customerRepository
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return string|null
     */
    public function index()
    {
        $customers = $this->customerRepository->all();

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

        return response()->json([
            'data' => $newCustomer
        ]);
    }
}
