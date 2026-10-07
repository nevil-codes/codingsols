<?php

namespace App\Models;

use App\Models\Concerns\HasVotes;
use Database\Factories\ThreadFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

#[Fillable(['title', 'body', 'edited_at'])]
class Thread extends Model
{
    /** @use HasFactory<ThreadFactory> */
    use HasFactory, HasVotes, Searchable;

    public const SORTS = ['latest' => 'Latest', 'top' => 'Top', 'unanswered' => 'Unanswered'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'edited_at' => 'datetime',
            'score' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }

    /**
     * @return BelongsTo<Comment, $this>
     */
    public function acceptedAnswer(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'accepted_comment_id');
    }

    /**
     * Order by latest, top score, or only threads without replies.
     *
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function sortBy(Builder $query, ?string $sort): void
    {
        match ($sort) {
            'top' => $query->orderByDesc('score')->latest(),
            'unanswered' => $query->doesntHave('comments')->latest(),
            default => $query->latest(),
        };
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return array<string, string>
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public function excerpt(int $limit = 160): string
    {
        return Str::limit(Str::squish(html_entity_decode(strip_tags(Str::markdown($this->body, ['html_input' => 'strip'])), ENT_QUOTES | ENT_HTML5)), $limit);
    }
}
