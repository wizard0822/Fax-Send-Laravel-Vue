<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $table = 'governments';

    protected $fillable = [
        'name',
        'department',
        'email',
        'fax',
        'address',
        'postal',
        'city',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
