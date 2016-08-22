<?php

namespace Tatekae\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Tatekae\Models\UserRelationship
 *
 * @property integer $user_one_id
 * @property integer $user_two_id
 * @property integer $created_by
 * @property integer $state
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\UserRelationship whereUserOneId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\UserRelationship whereUserTwoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\UserRelationship whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\UserRelationship whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\UserRelationship whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tatekae\Models\UserRelationship whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserRelationship extends \Eloquent
{
    const STATE_PENDING = 0;
    const STATE_APPROVED = 1;
    const STATE_REJECTED = 2;

    protected $primaryKey = 'user_one_id'; // Composite key. Actually PK is ['user_one_id, 'user_two_id']

    protected $fillable = [
        'user_one_id', 'user_two_id', 'created_by', 'state',
    ];

    public static function create_(int $userCreatedBy, int $other): self
    {
        list($userOne, $userTwo) = self::sort($userCreatedBy, $other);
        return self::create([
            'user_one_id' => $userOne,
            'user_two_id' => $userTwo,
            'created_by' => $userCreatedBy,
            'state' => self::STATE_APPROVED,
        ]);
    }

    public static function response(int $other, bool $isApproved)
    {
        \DB::transaction(function () use ($other, $isApproved) {
            $myUserId = \Auth::user()->id;
            list($userOne, $userTwo) = self::sort($myUserId, $other);
            $relationship = self::where('user_one_id', $userOne)
                ->where('user_two_id', $userTwo)
                ->where('created_by', $other)
                ->lockForUpdate()
                ->firstOrFail();
            if ($isApproved && ($relationship->state == self::STATE_PENDING || $relationship->state == self::STATE_REJECTED)) {
                $relationship->state = self::STATE_APPROVED;
            } else if ($relationship->state == self::STATE_PENDING || $relationship->state == self::STATE_APPROVED) {
                $relationship->state = self::STATE_REJECTED;
            }
            $relationship->saveOrFail();
        });
    }

    public static function isFriend(int $userOne, int $userTwo): bool
    {
        list($userOne, $userTwo) = self::sort($userOne, $userTwo);
        return !!self::where('user_one_id', $userOne)
            ->where('user_two_id', $userTwo)
            ->where('state', self::STATE_APPROVED)->first();
    }

    public static function friends(int $user): Collection
    {
        $user_a = self::where('user_one_id', $user)
            ->where('state', self::STATE_APPROVED)
            ->get();
        $user_b = self::where('user_two_id', $user)
            ->where('state', self::STATE_APPROVED)
            ->get();
        return $user_a->merge($user_b);
    }

    public static function getMyRelation(int $user_relationship_id): self
    {
        $relationship = self::find($user_relationship_id);
        if ($relationship->user_one_id !== $user_relationship_id && $relationship->user_two_id !== $user_relationship_id) {
            abort(403);
        }
        return $relationship;
    }

    private static function sort(int $userOne, int $userTwo): array
    {
        $a = [$userOne, $userTwo];
        sort($a);
        return $a;
    }

    /**
     * Override to support composite key.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        parent::setKeysForSaveQuery($query);
        $query->where('user_two_id', '=', $this->user_two_id);
        return $query;
    }
}