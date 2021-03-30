<?php

namespace App\Models\Customers\RegistrationData;

use Illuminate\Database\Eloquent\Model;

class PersonRegistrationData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_people_registration_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'national_identity_card',
        'birth_date',
        'customer_id'
    ];
}
