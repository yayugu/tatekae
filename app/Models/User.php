<?php

namespace Tatekae\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Tatekae\Models\User
 *
 * @property integer $id
 * @property string $social_provider
 * @property string $social_id
 * @property string $screen_name
 * @property string $icon
 * @property integer $account_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Tatekae\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereSocialProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereSocialId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereScreenName($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    protected $fillable = [
        'social_provider',
        'social_id',
        'screen_name',
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