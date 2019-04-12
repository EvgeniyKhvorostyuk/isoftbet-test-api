<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cnp'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
