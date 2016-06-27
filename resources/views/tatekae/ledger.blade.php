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
        <table class="table">
            <thead>
            <tr>
                <th>項目</th>
                <th>受取 / 受取予定</th>
                <th>支払 / 支払予定</th>
                <th>記帳日</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ledger['records'] as $record)
                <tr>
                    <th>{{$record['item']}}</th>
                    <th>{{$record['account_receivable']}}</th>
                    <th>{{$record['account_payable']}}</th>
                    <th>{{datetime_tz($record['created_at'])}}</th>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>累計</th>
                @if ($ledger['sum_record'] > 0)
                    <th>{{$ledger['sum_record']}}</th>
                    <th></th>
                @else
                    <th></th>
                    <th>{{- $ledger['sum_record']}}</th>
                @endif
                <th></th>
            </tr>
            </tfoot>
        </table>
    </section>

@stop

