<?php

namespace Tatekae\Http\Controllers;

use Tatekae\Models\Account;
use Tatekae\Models\Ledger;
use Tatekae\Models\OwnAccount;
use Tatekae\Models\User;
use Tatekae\Models\UserRelationship;

class TatekaeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getMypage()
    {
        $user = \Auth::user();
        $sums = Ledger::getSumsByAccount($user->id);
        $user_relationships = UserRelationship::friends($user->id);
        $friends = User::whereIn('id', $user_relationships->pluck('id'))->get();

        return view('tatekae.mypage', [
            'user' => $user,
            'sums' => $sums,
            'user_relationships', $user_relationships,
            'friends' => $friends,
        ]);
    }

    public function getAccountLedger(string $account_id)
    {
        $ledger = Ledger::getLedgerAcross(\Auth::user()->account->id, $account_id);
        return view('tatekae.ledger', [
            'account' => Account::find($account_id),
            'ledger' => $ledger,
        ]);
    }

    public function getUserLedger(string $user_relationship_id)
    {
        $account_id = UserRelationship::getMyRelation((int)$user_relationship_id);
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
            OwnAccount::create([
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
        $value = preg_replace("/[^\d]+/", "", \Request::input('value'));
        Ledger::create([
            'created_by' => $user->account->id,
            'item' => \Request::input('item'),
            'payer' => $payer,
            'payee' => $payee,
            'value' => $value,
        ]);
        return redirect()->action('TatekaeController@getLedger', [$account_id]);
    }

    public function postEditLedgerRecord(string $account_id, $ledger_id)
    {

    }
}