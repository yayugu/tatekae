<?php

namespace Tatekae\Http\Controllers\Auth;

use Tatekae\Models\Account;
use Tatekae\Models\User;
use Tatekae\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/tatekae';

    protected $loginPath = '/login';

    protected $username = 'social_id';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function getSocialRedirect()
    {
        return \Socialite::driver('twitter')->redirect();
    }

    public function getSocialHandle()
    {
        $providerRespondedUser = \Socialite::driver('twitter')->user();
        /** @var User $user */
        $user = User::where('social_id', $providerRespondedUser->id)
            ->where('social_provider', 'twitter')
            ->first();
        if (!$user) {
            $user = $this->createUser($providerRespondedUser);
        }
        $this->updateUserInfo($user, $providerRespondedUser);
        \Auth::login($user, true);
        return redirect()->intended($this->redirectPath());
    }

    protected function createUser(\Laravel\Socialite\AbstractUser $providerRespondedUser) : User
    {
        $user = null;
        \DB::transaction(function () use ($providerRespondedUser, &$user) {
            $account = Account::create([
                'name' => $providerRespondedUser->name,
            ]);
            $user = User::create([
                'account_id' => $account->id,
                'social_provider' => 'twitter',
                'social_id' => $providerRespondedUser->id,
                'screen_name' => $providerRespondedUser->nickname,
                'icon' => $providerRespondedUser->avatar,
            ]);
        });
        return $user;
    }

    protected function updateUserInfo(User $user, \Laravel\Socialite\AbstractUser $providerRespondedUser)
    {
        $user->screen_name = $providerRespondedUser->nickname;
        $user->icon = $providerRespondedUser->avatar;
        $user->saveOrFail();
    }
}
