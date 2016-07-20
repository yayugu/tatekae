@extends('layouts.master')
@section('title', '- ' . $account->name)

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
        <div class="box">
            <div class="columns is-gapless">
                <div class="column">
                    <strong>累計</strong>
                </div>
                <div class="column">
                    <div style="display: flex; margin: -10px;">
                        @if ($ledger['sum_record'] > 0)
                            <div class="column has-text-right">
                                <strong>+{{$ledger['sum_record']}}</strong>
                            </div>
                            <div class="column has-text-right">
                            </div>
                        @else
                            <div class="column has-text-right">
                            </div>
                            <div class="column has-text-right">
                                <strong>{{$ledger['sum_record']}}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @foreach($ledger['records'] as $record)
            <div class="box">
                <div class="columns is-gapless">
                    <div class="column">
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
                    <div class="column">
                        <div style="display: flex; margin: -10px;">
                            <div class="column has-text-right">
                                +{{$record['account_receivable']}}
                            </div>
                            <div class="column has-text-right">
                                -{{$record['account_payable']}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </section>

@stop

