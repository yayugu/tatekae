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
        'screen_name', 'password', 'account_id',
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
        $account_ids = OwnAccount::where('owner_user_id', $this->id)->pluck('account_id');
        return Account::whereIn('id', $account_ids);
    }

    public function friends()
    {
        return self::whereIn('id', UserRelationship::friendsIds($this->id));
    }

    public function pendingFriends()
    {
        return self::whereIn('id', UserRelationship::pendingFriendsIds($this->id));
    }

    public function pendingFriendsCreatedBy()
    {
        return self::whereIn('id', UserRelationship::pendingFriendsCreatedByIds($this->id));
    }

    /**
     * overrides.
     *
     * @see \Illuminate\Contracts\Auth\Authenticatable::setRememberToken()
     */
    public function setRememberToken($value)
    {
    }
}