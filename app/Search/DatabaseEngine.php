<?php

namespace App\Search;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\DatabaseEngine as ScoutDatabaseEngine;

/**
 * Scout's database engine matches the whole query as one phrase, so
 * "csv pandas" would not find "How do I read a CSV file into pandas?".
 * This engine requires every word to appear in at least one column.
 */
class DatabaseEngine extends ScoutDatabaseEngine
{
    protected function addTextSearchConstraints($query, Builder $builder, array $columns, array $prefixColumns = [], array $fullTextColumns = [])
    {
        $terms = static::terms($builder->query);

        if ($terms === []) {
            return $query;
        }

        $likeOperator = $builder->modelConnectionType() === 'pgsql' ? 'ilike' : 'like';

        foreach ($terms as $term) {
            $query->where(function ($query) use ($builder, $columns, $term, $likeOperator) {
                foreach ($columns as $column) {
                    $query->orWhere($builder->model->qualifyColumn($column), $likeOperator, '%'.$term.'%');
                }
            });
        }

        return $query;
    }

    /**
     * Split a search query into at most eight unique words.
     *
     * @return list<string>
     */
    public static function terms(?string $query): array
    {
        return collect(preg_split('/\s+/u', trim((string) $query), -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn (string $term) => mb_strtolower($term))
            ->unique()
            ->take(8)
            ->values()
            ->all();
    }
}
