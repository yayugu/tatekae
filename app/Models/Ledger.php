<?php

namespace Tatekae\Models;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $table = 'ledger';

    protected $fillable = [
        'created_by', 'item', 'payer', 'payee', 'value',
    ];

    public static function getLedgerAcross(int $account_id_self, int $account_id_client)
    {
        $records = self::whereIn('payer', [$account_id_self, $account_id_client])
            ->whereIn('payee', [$account_id_self, $account_id_client])
            ->get()
            ->map(function ($record) use ($account_id_self) {
                if ($record->payer === $account_id_self) {
                    return[
                        'item' => $record->item,
                        'account_receivable' => 0,
                        'account_payable' => (int)$record->value,
                    ];
                }
                return[
                    'item' => $record->item,
                    'account_receivable' => (int)$record->value,
                    'account_payable' => 0,
                ];
            });
        $sum_record = $records->reduce(function ($partial, $record) {
            $partial['account_receivable'] += $record['account_receivable'];
            $partial['account_payable'] += $record['account_payable'];
            return $partial;
        }, [
            'account_receivable' => 0,
            'account_payable' => 0,
        ]);
        return [
            'records' => $records,
            'sum_record' => $sum_record,
        ];
    }
}