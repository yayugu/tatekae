<?php

namespace Tatekae\Models;

/**
 * Tatekae\Models\OwnAccount
 *
 * @property integer $account_id
 * @property integer $owner_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\OwnAccount whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\OwnAccount whereOwnerUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\OwnAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\OwnAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OwnAccount extends \Eloquent
{
    protected $primaryKey = 'account_id';
    protected $fillable = [
        'account_id', 'owner_user_id',
    ];
}