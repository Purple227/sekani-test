<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'branch', 'account_type', 'account_balance'
    ];


}
