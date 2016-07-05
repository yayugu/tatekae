<?php

namespace Tatekae\Models;

/**
 * Tatekae\Models\Ledger
 *
 * @property integer $id
 * @property integer $created_by
 * @property string $item
 * @property integer $payer
 * @property integer $payee
 * @property integer $value
 * @property integer $state
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger wherePayer($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger wherePayee($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Ledger whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
            ->orderBy('id', 'desc')
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

    public static function getSumsByAccount(int $accountId)
    {
        $query = '
            select
              `client`,
              sum(`value`) as `value`
            from
              (
                select
                  case when payer = ? then payee else payer end as `client`,
                  sum(
                    case when payer = ? then -value else value end
                  ) as `value`
                from
                  ledger
                where
                  payer = ? or payee = ?
                group by
                  payer,
                  payee
              ) as `sub1`
            group by 
              `client`
            ;
        ';
        return \DB::select($query , [$accountId, $accountId, $accountId, $accountId]);
    }
}