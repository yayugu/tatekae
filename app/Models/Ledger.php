<?php

namespace Tatekae\Models;

class Ledger extends \Eloquent
{
    const STATE_APPROVAL_NOT_REQUIRED = 0;
    const STATE_ARRROVAL_WAITING = 1;
    const STATE_APPROVED = 2;
    const STATE_REJECTED = 3;

    protected $table = 'ledger';

    protected $fillable = [
        'created_by', 'item', 'payer', 'payee', 'value',
    ];

    public static function getLedgerAcross(int $accountIdSelf, int $accountIdClient)
    {
        $records = self::whereIn('payer', [$accountIdSelf, $accountIdClient])
            ->whereIn('payee', [$accountIdSelf, $accountIdClient])
            ->get()
            ->map(function ($record) use ($accountIdSelf) {
                if ((int)$record->payer === $accountIdSelf) {
                    return[
                        'item' => $record->item,
                        'account_receivable' => 0,
                        'account_payable' => (int)$record->value,
                        'created_at' => $record->created_at,
                    ];
                }
                return[
                    'item' => $record->item,
                    'account_receivable' => (int)$record->value,
                    'account_payable' => 0,
                    'created_at' => $record->created_at,
                ];
            });
        $sumRecord = $records->reduce(function ($partial, $record) {
            $partial += $record['account_receivable'];
            $partial -= $record['account_payable'];
            return $partial;
        }, 0);
        return [
            'records' => $records,
            'sum_record' => $sumRecord,
        ];
    }
}