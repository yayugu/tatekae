<?php

namespace Tatekae\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'account_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function account()
    {
        return $this->belongsTo('Tatekae\Models\Account');
    }

    public function ownAccounts()
    {
        $account_ids = OwnAccounts::where('owner_user_id', $this->id)->pluck('account_id');
        return Account::whereIn('id', $account_ids);
    }

    public function friends()
    {
        return self::whereIn('id', UserRelationships::friendsIds($this->id));
    }
}