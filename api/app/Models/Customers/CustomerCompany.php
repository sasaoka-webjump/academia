<?php

namespace App\Models\Customers;

use App\Models\Customers\Customer;
use App\Interfaces\Registered;

class CustomerCompany extends Customer implements Registered
{

    /**
     * Get the registration data associated with the customer.
     */
    public function registrationData()
    {
        return $this->hasOne(CompanyData::class);
    }
}
