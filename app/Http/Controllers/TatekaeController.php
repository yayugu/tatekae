<?php

namespace Tatekae\Http\Controllers;

use Tatekae\Models\Account;
use Tatekae\Models\Ledger;
use Tatekae\Models\OwnAccounts;

class TatekaeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMypage()
    {
        $user = \Auth::user();
        return view('tatekae.mypage', [
            'user' => $user,
        ]);
    }

    public function getLedger(string $account_id)
    {
        $ledger = Ledger::getLedgerAcross(\Auth::user()->account->id, $account_id);
        return view('tatekae.ledger', [
            'account' => Account::find($account_id),
            'ledger' => $ledger,
        ]);
    }

    public function postNewAccount()
    {
        $a = null;
        \DB::transaction(function () use (&$a) {
            $user = \Auth::user();
            $a = Account::create([
                'name' => \Request::input('name'),
            ]);
            OwnAccounts::create([
                'owner_user_id' => $user->id,
                'account_id' => $a->id,
            ]);
        });
        return redirect()->action('TatekaeController@getLedger', [$a->id]);
    }

    public function postNewLedgerRecord(string $account_id)
    {
        $user = \Auth::user();
        if (\Request::input('type') === 'account_receivable') {
            $payer = $account_id;
            $payee = $user->account->id;
        } else {
            $payer = $user->account->id;
            $payee = $account_id;
        }
        Ledger::create([
            'created_by' => $user->account->id,
            'item' => Request::input('item'),
            'payer' => $payer,
            'payee' => $payee,
            'value' => Request::input('value'),
        ]);
        return redirect()->action('TatekaeController@getLedger', [$account_id]);
    }

    public function postEditLedgerRecord(string $account_id, $ledger_id)
    {

    }
}