<?php

namespace App\Models\Transactions;

use App\Models\Customers\Customer;
use App\Models\Transactions\Transaction;

class Withdraw extends Transaction
{


    public function origin()
    {
        return $this->hasOne(Customer::class, 'origin_customer_id');
    }

    public function destination()
    {
        return $this->hasOne(Customer::class, 'destination_customer_id');
    }
}
