<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'branch', 'account_type', 'account_balance', 'account_no'
    ];


}
