<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'amount', 'status'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function getStatusAttribute()
    {
        return $this->attributes['status'] == 1 ? 'success' : 'fail'; // check!!!
    }
}
