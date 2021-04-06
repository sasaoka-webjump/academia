<?php

namespace App\Repositories;

use App\Models\Customers\Customer;
use App\Models\Customers\CustomerCompany;
use App\Models\Customers\CustomerPerson;
use App\Models\Customers\RegistrationData\CompanyRegistrationData;
use App\Models\Customers\RegistrationData\PersonRegistrationData;
use App\Exceptions\CustomerNotFoundException;

class CustomerRepository
{
    /**
     * Returns all customers in the database
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Customer::all();
    }

    /**
     * Try to find a specific customer by id.
     * Throws an error if not able to find it.
     * 
     * @param integer $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return \App\Models\Customers\Customer
     */
    public function findOrFail($id)
    {
        $customer = Customer::findOrFail($id);

        return $customer;
    }

    /**
     * Try to find a specific customer by account number.
     * Throws an error if not able to find it.
     * 
     * @param string $accountNumber
     * @throws \App\Exceptions\CustomerNotFoundException
     * @return \App\Models\Customers\Customer
     */
    public function findByAccountNumberOrFail($accountNumber)
    {
        $customer = Customer::where('accountNumber', $accountNumber)->first();

        if($customer) return $customer;

        throw new CustomerNotFoundException();
    }

    /**
     * Creates a new Customer
     * 
     * @param Array $inputData
     * @return \App\Models\CustomerCompany|\App\Models\CustomerPerson;
     */
    public function create($inputData)
    {
        $storeData = [
            'accountNumber' => $inputData['accountNumber'],
            'password' => md5($inputData['password']),
            'phone_number' => $inputData['phone_number'],
            'zip_code' => $inputData['zip_code'],
            'adress_state' => $inputData['adress_state'],
            'adress_city' => $inputData['adress_city'],
            'adress_district' => $inputData['adress_district'],
            'adress_street' => $inputData['adress_street'],
            'adress_number' => $inputData['adress_number'],
            'adress_complement' => $inputData['adress_complement'],
            'is_company' => $inputData['is_company']
        ];

        if($inputData['is_company'])
        {
            $customer = CustomerCompany::create($storeData);
            CompanyRegistrationData::create([
                'company_name' => $inputData['name'],
                'cnpj'  => $inputData['national_registration'],
                'state_registration' => $inputData['state_registration'],
                'foundation_date' => $inputData['birth_date'],
                'customer_id' => $customer->id
            ]);


        } else {
            $customer = CustomerPerson::create($storeData);
            PersonRegistrationData::create([
                'name' => $inputData['name'],
                'cpf'  => $inputData['national_registration'],
                'national_identity_card' => $inputData['state_registration'],
                'birth_date' => $inputData['birth_date'],
                'customer_id' => $customer->id
            ]);
        }

        return $customer;
    }
}
