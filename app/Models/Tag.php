<?php

namespace App\Models;

use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug'])]
class Tag extends Model
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;

    /**
     * Allowed tag names: lowercase letters, digits and . + # - (for c++, c#, .net, node.js).
     */
    public const NAME_PATTERN = '/^[a-z0-9.+#-]{1,30}$/';

    public const MAX_PER_THREAD = 5;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return BelongsToMany<Thread, $this>
     */
    public function threads(): BelongsToMany
    {
        return $this->belongsToMany(Thread::class);
    }

    /**
     * Normalize free-form input ("Pandas, #CSV  data-frames") into unique tag names.
     *
     * @return list<string>
     */
    public static function parse(?string $input): array
    {
        return collect(preg_split('/[\s,]+/', mb_strtolower((string) $input), -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn (string $name) => ltrim($name, '#'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * URL-safe slug that keeps c++, c# and .net distinct from c and net.
     */
    public static function slugFor(string $name): string
    {
        return Str::slug(str_replace(['+', '#', '.'], ['plus', 'sharp', 'dot'], $name));
    }

    /**
     * Find or create tags by name.
     *
     * @param  list<string>  $names
     * @return Collection<int, Tag>
     */
    public static function findOrCreateMany(array $names): Collection
    {
        return new Collection(array_map(fn (string $name) => static::firstOrCreate(
            ['name' => $name],
            ['slug' => static::uniqueSlugFor($name)],
        ), $names));
    }

    /**
     * A slug not yet used by another tag ("cplusplus" and "c++" both slug to cplusplus).
     */
    private static function uniqueSlugFor(string $name): string
    {
        $base = static::slugFor($name) ?: 'tag';
        $slug = $base;

        for ($i = 2; static::where('slug', $slug)->exists(); $i++) {
            $slug = $base.'-'.$i;
        }

        return $slug;
    }
}
