@extends('layouts.master')
@section('title', '- ' . $account->name)

@section('hero-body')
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                <img src="{{$account->user->icon}}" width="22px" height="22px">
                {{$account->name}} (&#64;{{$account->user->screen_name}})
            </h1>
            <h2 class="subtitle">
            </h2>
        </div>
    </div>
@stop

@section('content')
    <section class="section">
        <form method="POST" action="{{ action('TatekaeController@postNewLedgerRecord', [$account->id]) }}">
            {!! csrf_field() !!}

            @include('parts.error_message')

            <div class="control is-grouped">
                <div class="control">
                    <span class="select">
                        <select name="type">
                            <option value="account_receivable">受取 / 受取予定</option>
                            <option value="account_payable">支払 / 支払予定</option>
                        </select>
                    </span>
                </div>
                <div class="control">
                    <input class="input" type="text" name="item" value="" placeholder="項目">
                </div>
                <div class="control">
                    <input class="input" type="text" name="value" value="" placeholder="金額">
                </div>
                <div class="control">
                    <button class="button" type="submit">追加</button>
                </div>
            </div>
        </form>
    </section>
    <section class="section">
        <div class="ledger-record">
            <div class="non-responsive-columns">
                <div class="non-responsive-column">
                    <strong>累計</strong>
                </div>
                        @if ($ledger['sum_record'] > 0)
                            <div class="non-responsive-column has-text-right">
                                <strong>+{{$ledger['sum_record']}}</strong>
                            </div>
                            <div class="non-responsive-column has-text-right">
                            </div>
                        @else
                            <div class="non-responsive-column has-text-right">
                            </div>
                            <div class="non-responsive-column has-text-right">
                                <strong>{{$ledger['sum_record']}}</strong>
                            </div>
                        @endif

            </div>
        </div>
        @foreach($ledger['records'] as $record)
            <div class="ledger-record">
                <div class="non-responsive-columns">
                    <div class="non-responsive-column">
                        <strong>{{$record['item']}}</strong>
                        <small>
                            @if($record['is_created_by_self'])
                                by じぶん
                            @else
                                by あいて
                            @endif
                            {{datetime_tz($record['created_at'])}}
                        </small>
                    </div>
                            <div class="non-responsive-column leger-number-column has-text-right">
                                +{{$record['account_receivable']}}
                            </div>
                            <div class="non-responsive-column leger-number-column has-text-right">
                                -{{$record['account_payable']}}
                            </div>
                        </div>
            </div>
        @endforeach

    </section>

@stop

