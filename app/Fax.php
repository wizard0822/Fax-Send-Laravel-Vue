<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Fax
 * @package App
 *
 * @property Customer $customer
 * @property Government $government
 */
class Fax extends Model
{
    protected $table = 'faxes';

    protected $fillable = [
        'date',
        'pamfax_uuid',
        'letter_received',
        'applied_for',
        'government_id',
        'customer_id',
        'gen_faxcode',
        'gen_pdf',
        'new_trans',
        'status',
        'trans',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function government()
    {
        return $this->belongsTo(Government::class, 'government_id');
    }

}
