<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transactions\Transaction;

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

    /**
     * Get the transactions this customer made
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'origin_customer_id');
    }

    /**
     * Get the transactions this customer received
     */
    public function received()
    {
        return $this->hasMany(Transaction::class, 'destination_customer_id');
    }
}
