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
 * @property string $social_token
 * @property string $social_token_secret
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereSocialToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\User whereSocialTokenSecret($value)
 */
class User extends Authenticatable
{
    protected $fillable = [
        'social_provider',
        'social_id',
        'screen_name',
        'social_token',
        'social_token_secret',
        'icon',
        'account_id',
    ];

    public static function createUserWithAuthentication(\Laravel\Socialite\AbstractUser $providerRespondedUser) : User
    {
        $user = null;
        \DB::transaction(function () use ($providerRespondedUser, &$user) {
            $account = Account::create([
                'name' => $providerRespondedUser->name,
            ]);
            $user = self::create([
                'account_id' => $account->id,
                'social_provider' => 'twitter',
                'social_id' => $providerRespondedUser->id,
                'social_token' => $providerRespondedUser->token,
                'social_token_secret' => $providerRespondedUser->tokenSecret,
                'screen_name' => $providerRespondedUser->nickname,
                'icon' => $providerRespondedUser->avatar,
            ]);
        });
        return $user;
    }

    public static function createUserByOtherRequest(\stdClass $apiRespondedUser) : User
    {
        $user = null;
        \DB::transaction(function () use ($apiRespondedUser, &$user) {
            $account = Account::create([
                'name' => $apiRespondedUser->name,
            ]);
            $user = self::create([
                'account_id' => $account->id,
                'social_provider' => 'twitter',
                'social_id' => $apiRespondedUser->id_str,
                'social_token' => '',
                'social_token_secret' => '',
                'screen_name' => $apiRespondedUser->screen_name,
                'icon' => $apiRespondedUser->profile_image_url,
            ]);
        });
        return $user;
    }

    public function updateUserInfo(\Laravel\Socialite\AbstractUser $providerRespondedUser)
    {
        $this->social_token = $providerRespondedUser->token;
        $this->social_token_secret = $providerRespondedUser->tokenSecret;
        $this->screen_name = $providerRespondedUser->nickname;
        $this->icon = $providerRespondedUser->avatar;
        $this->saveOrFail();
    }

    public function account()
    {
        return $this->belongsTo('Tatekae\Models\Account');
    }

    public function ownAccounts()
    {
        $account_ids = OwnAccount::where('owner_user_id', $this->id)->pluck('account_id');
        return Account::whereIn('id', $account_ids);
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