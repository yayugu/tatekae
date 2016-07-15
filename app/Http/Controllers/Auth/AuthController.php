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

    protected $loginPath = '/social/redirect/twitter';

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
            $user = User::createUserWithAuthentication($providerRespondedUser);
        }
        $user->updateUserInfo($providerRespondedUser);
        \Auth::login($user, true);
        return redirect()->intended($this->redirectPath());
    }


}
