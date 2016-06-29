<?php

namespace Tatekae\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'social_provider',
        'social_id',
        'email',
        'icon',
        'account_id',
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