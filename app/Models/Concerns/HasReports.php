<?php

namespace App\Models\Concerns;

use App\Models\Report;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasReports
{
    /**
     * @return MorphMany<Report, $this>
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Reports on deleted content are moot, so remove them with the content.
     */
    public static function bootHasReports(): void
    {
        static::deleting(function (self $model): void {
            $model->reports()->delete();
        });
    }
}
