<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accountNumber',
        'password',
        'phone_number',
        'zip_code',
        'adress_state',
        'adress_city',
        'adress_district',
        'adress_street',
        'adress_number',
        'adress_complement',
        'is_company'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';
}
