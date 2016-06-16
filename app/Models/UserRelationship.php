<?php

namespace Tatekae\Models;

use Illuminate\Support\Collection;

class UserRelationship extends \Eloquent
{
    const STATE_PENDING = 0;
    const STATE_APPROVED = 1;
    const STATE_REJECTED = 2;

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
            'state' => self::STATE_PENDING,
        ]);
    }

    public static function response(int $other, bool $isapproved)
    {
        \DB::transaction(function () use ($other, $isApproved) {
            $myUserId = \Auth::user()->id;
            list($userOne, $userTwo) = self::sort($myUserId, $other);
            $relationship = self::where('user_one_id', $userOne)
                ->where('user_two_id', $userTwo)
                ->where('created_by', $other)
                ->lockForUpdate()
                ->firstOrFail();
            if ($isApproved && $relationship->state == self::STATE_PENDING || $relationship->state == self::STATE_REJECTED) {
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

    public static function friendsIds(int $user): Collection
    {
        $user_ids_a = self::where('user_one_id', $user)
            ->where('state', self::STATE_APPROVED)
            ->pluck('user_two_id');
        $user_ids_b = self::where('user_two_id', $user)
            ->where('state', self::STATE_APPROVED)
            ->pluck('user_one_id');
        return $user_ids_a->merge($user_ids_b);
    }

    private static function sort(int $userOne, int $userTwo): array
    {
        $a = [$userOne, $userTwo];
        sort($a);
        return $a;
    }
}