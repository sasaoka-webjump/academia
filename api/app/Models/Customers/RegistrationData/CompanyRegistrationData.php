<?php

namespace App\Models\Customers\RegistrationData;

use Illuminate\Database\Eloquent\Model;

class CompanyRegistrationData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_companies_registration_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'cnpj',
        'state_registration',
        'foundation_date',
        'customer_id'
    ];
}
