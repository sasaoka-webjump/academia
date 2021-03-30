<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'origin_customer_id',
        'destination_customer_id',
        'value'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';
}
