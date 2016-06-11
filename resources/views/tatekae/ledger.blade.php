<form method="POST" action="{{ action('TatekaeController@postNewLedgerRecord', [$account->id]) }}">
    {!! csrf_field() !!}

    <div>
        項目
        <input type="text" name="item" value="">
    </div>

    <input type="radio" name="type" value="account_receivable" checked>受け取り予定
    <input type="radio" name="type" value="account_payable">支払い予定

    <div>
        Value
        <input type="text" name="value" value="">
    </div>

    <div>
        <button type="submit">Add</button>
    </div>
</form>

<table>
    <tr>
        <th>受け取り予定</th>
        <th>支払い予定</th>
        <th>項目</th>
    </tr>
    @foreach($ledger['records'] as $record)
        <tr>
            <th>{{$record['account_receivable']}}</th>
            <th>{{$record['account_payable']}}</th>
            <th>{{$record['item']}}</th>
        </tr>
    @endforeach
    <tr>
        <th>{{$ledger['sum_record']}}</th>
        <th></th>
        <th>計</th>
    </tr>
</table>


