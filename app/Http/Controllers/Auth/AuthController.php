<?php

namespace Tatekae\Http\Controllers\Auth;

use Tatekae\Models\Account;
use Tatekae\Models\User;
use Validator;
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

    protected $username = 'screen_name';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'screen_name' => ['required', 'regex:/[a-z_]+/', 'max:255', 'unique:users'],
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = null;
        \DB::transaction(function () use ($data, &$user) {
            $account = Account::create([
                'name' => $data['screen_name'],
            ]);
            $user = User::create([
                'screen_name' => $data['screen_name'],
                'password' => bcrypt($data['password']),
                'account_id' => $account->id,
            ]);
        });
        return $user;
    }
}
