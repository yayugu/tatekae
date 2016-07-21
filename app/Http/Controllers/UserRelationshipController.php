<?php

namespace Tatekae\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use Tatekae\Models\User;
use Tatekae\Models\UserRelationship;

class UserRelationshipController extends Controller
{
    public function postNew(Request $request)
    {
        //$userId = User::where('screen_name', $request->input('screen_name'))->value('id');
        $screenName = $request->input('screen_name');
        $friendUser = User::where('screen_name', $screenName)->first();
        if (!$friendUser) {
            $twitter = new TwitterOAuth(
                config('services.twitter.client_id'), config('services.twitter.client_secret'),
                \Auth::user()->social_token, \Auth::user()->social_token_secret
            );
            $twitter_user = $twitter->get('users/show', ['screen_name' => $screenName]);
            $friendUser = User::createUserByOtherRequest($twitter_user);
        }
        UserRelationship::create_(\Auth::user()->id, $friendUser->id);
        return redirect('/tatekae');
    }

    public function postReply(Request $request)
    {
        UserRelationship::response($request->input('user_id'), $request->input('is_approved'));
        return redirect('/tatekae');
    }
}