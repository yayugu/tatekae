<?php

namespace Tatekae\Http\Controllers;

use Illuminate\Http\Request;
use Tatekae\Models\User;
use Tatekae\Models\UserRelationship;

class UserRelationshipController extends Controller
{
    public function postNew(Request $request)
    {
        $userId = User::where('screen_name', $request->input('screen_name'))->value('id');
        UserRelationship::create_(\Auth::user()->id, $userId);
        return redirect('/tatekae');
    }

    public function postReply(Request $request)
    {
        $userId = User::where('screen_name', $request->input('screen_name'))->value('id');
        UserRelationship::response($userId, $request->input('is_approved'));
        return redirect('/tatekae');
    }
}