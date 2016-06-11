<?php

namespace Tatekae\Models;

class UserRelationships extends \Eloquent
{
    const STATE_PENDING = 0;
    const STATE_APPROVED = 1;
    const STATE_REJECTED = 2;

    protected $fillable = [
        'user_one', 'user_two', 'created_by', 'state',
    ];

    public static function create_(int $userCreatedBy, int $other): Model
    {
        list($userOne, $userTwo) = self::sort($userCreatedBy, $other);
        return self::create([
            'user_one' => $userOne,
            'user_two' => $userTwo,
            'created_by' => $userCreatedBy,
            'state' => self::STATE_PENDING,
        ]);
    }

    public static function response(int $other)
    {
        \DB::transaction(function () use ($other) {
            $myUserId = \Auth::user()->id;
            list($userOne, $userTwo) = self::sort($myUserId, $other);
            $relationship = self::where('user_one', $userOne)
                ->where('user_two', $userTwo)
                ->where('created_by', $other)
                ->lockForUpdate()
                ->firstOrFail();
            if ($relationship->state == self::STATE_PENDING || $relationship->state == self::STATE_REJECTED) {
                $relationship->state = self::STATE_APPROVED;
            }
            $relationship->saveOrFail();
        });
    }

    public static function isFriend(int $userOne, int $userTwo): bool
    {
        list($userOne, $userTwo) = self::sort($userOne, $userTwo);
        return !!self::where('user_one', $userOne)
            ->where('user_two', $userTwo)
            ->where('state', self::STATE_APPROVED)->first();
    }

    private static function sort(int $userOne, int $userTwo): array
    {
        $a = [$userOne, $userTwo];
        sort($a);
        return $a;
    }
}