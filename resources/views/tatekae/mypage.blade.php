@extends('layouts.master')
@section('title', '- Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <h1 class="title">Accounts</h1>

            <table class="table">
                @foreach($user->ownAccounts()->get() as $account)
                    <tr>
                        <td>
                            <a href="{{action('TatekaeController@getLedger', $account->id)}}">
                                {{$account->name}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h1 class="title">Add Account</h1>

            <form method="POST" action="{{url('/tatekae/new')}}">
                {!! csrf_field() !!}

                <label class="label">Name</label>
                <p class="control">
                    <input type="text" class="input" name="name" value="">
                </p>

                <p class="control">
                    <button type="submit" class="button is-primary">Submit</button>
                </p>
            </form>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h1 class="title">Friends</h1>

            <table class="table">
                @foreach($user->friends()->get() as $friend_user)
                    <tr>
                        <td>
                            <a href="{{action('TatekaeController@getLedger', $friend_user->account->id)}}">
                                {{$friend_user->account->name}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h1 class="title">Add Friend</h1>

            <form method="POST" action="{{action('UserRelationshipController@postNew')}}">
                {!! csrf_field() !!}

                <label class="label">Name (User id)</label>
                <p class="control">
                    <input type="text" class="input" name="screen_name" value="">
                </p>

                <p class="control">
                    <button type="submit" class="button is-primary">Add Friend</button>
                </p>
            </form>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h1 class="title">申請中</h1>

            <table class="table">
                @foreach($user->pendingFriendsCreatedBy()->get() as $friend_user)
                    <tr>
                        <td>
                            {{$friend_user->account->name}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h1 class="title">きている申請</h1>

            <table class="table">
                @foreach($user->pendingFriends()->get() as $friend_user)
                    <tr>
                        <td>
                            {{$friend_user->account->name}}
                        </td>
                        <td>
                            <form class="is-inline" method="POST" action="{{action('UserRelationshipController@postReply')}}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="user_id" value="{{$friend_user->id}}">
                                <input type="hidden" name="is_approved" value="1">
                                <button type="submit" class="button is-primary">Confirm</button>
                            </form>
                            <form class="is-inline"  method="POST" action="{{action('UserRelationshipController@postReply')}}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="user_id" value="{{$friend_user->id}}">
                                <input type="hidden" name="is_approved" value="0">
                                <button type="submit" class="button is-primary">Later</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@stop