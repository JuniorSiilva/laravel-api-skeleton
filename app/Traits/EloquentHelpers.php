<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait EloquentHelpers
{
    public function scopeWhereFromToDate(Builder $query, string $from, string $to, string $column = 'created_at', string $cast = 'DATE')
    {
        $from = $from ?: Carbon::now()->subDays(29)->format('Y-m-d');

        $to = $to ?: Carbon::now()->format('Y-m-d');

        $query->whereRaw("$column::$cast BETWEEN ? AND ?", [$from, $to]);
    }
}
