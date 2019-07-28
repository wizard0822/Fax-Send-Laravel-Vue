<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'postal',
        'phone',
        'home_num',
        'email',
        'bank_account',
        'address',
        'city',
        'gender',
        'notes',
        'sign',
        'sign_name',
        'sign_path',
        'sign_image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
