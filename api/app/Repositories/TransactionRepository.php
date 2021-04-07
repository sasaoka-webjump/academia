<?php

namespace App\Repositories;

use App\Models\Transactions\Transaction;
use App\Models\Customers\Customer;
use App\Exceptions\NotEnoughBalanceException;

class TransactionRepository
{

    const WITHDRAW = "withdraw";
    const TRANSFER = "transfer";
    const DEPOSIT = "deposit";

    /**
     * @var \App\Repositories\CustomerRepository $customerRepository
     */
    protected $customerRepository;

    public function __construct(\App\Repositories\CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get the sum of all given transactions
     * @param \Illuminate\Database\Eloquent\Collection $transaction
     * @return float
     */
    private function sumTransactionsValue(\Illuminate\Database\Eloquent\Collection $transactions)
    {
        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->value;
        }
        return $sum;
    }

    /**
     * Returns all customers in the database
     * @return \Illuminate\Database\Eloquent\Collection|static[] 
     */
    public function all()
    {
        return Transaction::all();
    }

    /**
     * Returns the customer withdrawn amount 
     * @param \App\Models\Customers\Customer $customer
     * @return float
     */
    public function getTotalWithdrawn(Customer $customer)
    {
        $transactions = $customer->transactions()->where('type', self::WITHDRAW)->get();
        return $this->sumTransactionsValue($transactions);
    }

    /**
     * Returns the customer deposited amount 
     * @param \App\Models\Customers\Customer $customer
     * @return float
     */
    public function getTotalDeposited(Customer $customer)
    {
        $transactions = $customer->transactions()->where('type', self::DEPOSIT)->get();
        return $this->sumTransactionsValue($transactions);
    }

    /**
     * Returns the customer transferred amount 
     * @param \App\Models\Customers\Customer $customer
     * @return float
     */
    public function getTotalTransferred(Customer $customer)
    {
        $transactions = $customer->transactions()->where('type', self::TRANSFER)->get();
        return $this->sumTransactionsValue($transactions);
    }

    /**
     * Returns the customer received amount 
     * @param \App\Models\Customers\Customer $customer
     * @return float
     */
    public function getTotalReceived(Customer $customer)
    {
        $transactions = $customer->received()->where('type', self::TRANSFER)->get();
        return $this->sumTransactionsValue($transactions);
    }

    /**
     * Get the customer current balance
     * @param \App\Models\Customers\Customer $customer
     * @return float
     */
    public function getBalance(Customer $customer)
    {
        $received = $this->getTotalReceived($customer);
        $deposited = $this->getTotalDeposited($customer);

        $transferred = $this->getTotalTransferred($customer);
        $withdraw = $this->getTotalWithdrawn($customer);

        $balance = $received + $deposited - $transferred - $withdraw;
        return $balance;
    }

    /**
     * Check if the customer's balance is enough to make a transaction
     * @param \App\Models\Customers\Customer $customer
     * @param float $value
     * @throws \App\Exceptions\NotEnoughBalanceException
     * @return void
     */
    public function checkBalanceBeforeTransfer(Customer $customer, float $value)
    {
        $balance = $this->getBalance($customer);
        if ($value > $balance) throw new NotEnoughBalanceException();
    }

    /**
     * Create a new withdraw transaction
     * @param \App\Models\Customers\Customer $customer
     * @param float $value
     * @return void
     */
    public function withdraw(Customer $customer, float $value)
    {
        $this->checkBalanceBeforeTransfer($customer, $value);

        $this->create($customer->id, $customer->id, $value, self::WITHDRAW);
    }

    /**
     * Create a new deposit transaction
     * @param \App\Models\Customers\Customer $customer
     * @param float $value
     * @return void
     */
    public function deposit(Customer $customer, float $value)
    {
        $this->create($customer->id, $customer->id, $value, self::DEPOSIT);
    }

    /**
     * Create a new transfer transaction
     * @param \App\Models\Customers\Customer $customer
     * @param string $destinationAccountNumber
     * @param float $value
     * @return void
     */
    public function transfer(Customer $customer, string $destinationAccountNumber, float $value)
    {
        $this->checkBalanceBeforeTransfer($customer, $value);

        $destination = $this->customerRepository->findByAccountNumberOrFail($destinationAccountNumber);

        $this->create($customer->id, $destination->id, $value, self::TRANSFER);
    }

    /**
     * Create a new transaction
     * @param int $originCustomerId
     * @param int $destinationCustomerId
     * @param float $value
     * @param string $type
     * @return void
     */
    public function create(int $originCustomerId, int $destinationCustomerId, float $value, string $type)
    {
        Transaction::create([
            "type"  => $type,
            "value" => $value,
            "origin_customer_id" => $originCustomerId,
            "destination_customer_id" => $destinationCustomerId
        ]);
    }
}
