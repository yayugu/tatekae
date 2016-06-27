<?php

namespace Tatekae\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserRelationship extends \Eloquent
{
    const STATE_PENDING = 0;
    const STATE_APPROVED = 1;
    const STATE_REJECTED = 2;

    protected $primaryKey = 'user_one_id';

    protected $fillable = [
        'user_one_id', 'user_two_id', 'created_by', 'state',
    ];

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

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
    
    public static function pendingFriendsIds(int $user): Collection
    {
        $user_ids_a = self::where('user_one_id', $user)
            ->where('state', self::STATE_PENDING)
            ->where('created_by', '!=', $user)
            ->pluck('user_two_id');
        $user_ids_b = self::where('user_two_id', $user)
            ->where('state', self::STATE_PENDING)
            ->where('created_by', '!=', $user)
            ->pluck('user_one_id');
        return $user_ids_a->merge($user_ids_b);
    }

    public static function pendingFriendsCreatedByIds(int $user): Collection
    {
        $user_ids_a = self::where('user_one_id', $user)
            ->where('state', self::STATE_PENDING)
            ->where('created_by', $user)
            ->pluck('user_two_id');
        $user_ids_b = self::where('user_two_id', $user)
            ->where('state', self::STATE_PENDING)
            ->where('created_by', $user)
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