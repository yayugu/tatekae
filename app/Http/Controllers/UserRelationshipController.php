<?php

namespace Tatekae\Http\Controllers;

use Endroid\Twitter\Twitter;
use Illuminate\Http\Request;
use Tatekae\Models\User;
use Tatekae\Models\UserRelationship;

class UserRelationshipController extends Controller
{
    public function postNew(Request $request)
    {
        //$userId = User::where('screen_name', $request->input('screen_name'))->value('id');
        $friendUser = User::where('screen_name', $request->input('screen_name'))->get();
        if (!$friendUser) {
            $twitter = new Twitter(
                env('TWITTER_KEY'), env('TWITTER_SECRET'),
                \Auth::user()->social_token, \Auth::user()->social_token_secret
            );
            $twitter->
        }
        UserRelationship::create_(\Auth::user()->id, $userId);
        return redirect('/tatekae');
    }

    public function postReply(Request $request)
    {
        UserRelationship::response($request->input('user_id'), $request->input('is_approved'));
        return redirect('/tatekae');
    }
}