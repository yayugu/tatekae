<?php

namespace Tatekae\Models;

class OwnAccounts extends \Eloquent
{
    protected $primaryKey = 'account_id';
    protected $fillable = [
        'account_id', 'owner_user_id',
    ];
}