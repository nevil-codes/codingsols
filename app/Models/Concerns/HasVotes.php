<?php

namespace App\Models\Concerns;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

/**
 * Up/down voting with a denormalized `score` column for fast sorting.
 */
trait HasVotes
{
    /**
     * Votes have no foreign key to their target, so remove them with it.
     */
    public static function bootHasVotes(): void
    {
        // Must not return a value: a non-null return from a "deleting" listener
        // stops the remaining listeners from running.
        static::deleting(function (self $model): void {
            $model->votes()->delete();
        });
    }

    /**
     * @return MorphMany<Vote, $this>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * Cast, change or retract a vote. Voting the same way twice removes the
     * vote. Returns the user's vote afterwards (1, -1 or 0).
     */
    public function vote(User $user, int $value): int
    {
        return DB::transaction(function () use ($user, $value) {
            $existing = $this->votes()->where('user_id', $user->id)->lockForUpdate()->first();

            if ($existing && $existing->value === $value) {
                $existing->delete();
                $delta = -$value;
                $current = 0;
            } elseif ($existing) {
                $delta = $value - $existing->value;
                $existing->update(['value' => $value]);
                $current = $value;
            } else {
                $this->votes()->create(['user_id' => $user->id, 'value' => $value]);
                $delta = $value;
                $current = $value;
            }

            // Adjust the score without touching updated_at or firing model events.
            $this->newQuery()->whereKey($this->getKey())->toBase()->increment('score', $delta);
            $this->score += $delta;

            return $current;
        });
    }
}
