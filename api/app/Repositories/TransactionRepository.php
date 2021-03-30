<?php

namespace App\Repositories;

use App\Models\Transactions\Transaction;


class CustomerRepository
{
    /**
     * Returns all customers in the database
     * @return \Illuminate\Database\Eloquent\Collection|static[] 
     */
    public function all()
    {
        return Transaction::all();
    }

}
