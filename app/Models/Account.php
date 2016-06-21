<?php

namespace Tatekae\Models;

class Account extends \Eloquent
{
    protected $fillable = [
        'name',
    ];

    protected function user()
    {
        return $this->hasOne('App\Phone');
    }
}