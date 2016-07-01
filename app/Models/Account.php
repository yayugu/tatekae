<?php

namespace Tatekae\Models;

/**
 * Tatekae\Models\Account
 *
 * @property integer $id
 * @property string $name
 * @property integer $state
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Account whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Account whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Account whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends \Eloquent
{
    protected $fillable = [
        'name',
    ];

    protected function user()
    {
        return $this->hasOne('App\Phone');
    }
}