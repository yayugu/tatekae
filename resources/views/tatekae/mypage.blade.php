@extends('layouts.master')
@section('title', '- Dashboard')

@section('content')
    @include('parts.error_message')

    <?php $totalAble = \Tatekae\Models\Ledger::getTotalAble($sums) ?>
    トータル支払える額: {{$totalAble['payable']}}<br>
    トータル受け取れる額: {{$totalAble['receivable']}}<br>

    <section class="section">
        <div class="container">
            <h1 class="title">Accounts</h1>

            <table class="table">
                @foreach($user->ownAccounts()->get() as $account)
                    <tr>
                        <td>
                            <a href="{{action('TatekaeController@getLedger', $account->id)}}">
                                {{$account->name}}  {{$sums[$account->id] ?? 0}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>

            <form method="POST" action="{{url('/tatekae/new')}}">
                {!! csrf_field() !!}
                <p class="control has-addons">
                    <input class="input is-expanded" type="text" name="name" placeholder="なまえ">
                    <button type="submit" class="button is-primary">友達を追加（相手に見せない）</button>
                </p>
                <p class="control">
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
                                <img src="{{$friend_user->icon}}" width="32px" height="32px">
                                {{$friend_user->account->name}} {{$sums[$friend_user->account->id] ?? 0}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>

            <form method="POST" action="{{action('UserRelationshipController@postNew')}}">
                {!! csrf_field() !!}
                <p class="control has-addons">
                    <input class="input is-expanded" type="text" name="name" placeholder="Twitter username (ex. @foobar) ">
                    <button type="submit" class="button is-primary">友達を追加</button>
                </p>
                <p class="control">
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