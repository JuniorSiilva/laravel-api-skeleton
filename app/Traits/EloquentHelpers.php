<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

//TODO: Melhorar essa funcionalidade completa
trait EloquentHelpers
{
    private $methods = [
        'LAST_30_DAYS' => 'getLast30Days',

        'CURRENT_MONTH' => 'getCurrentMonth',
    ];

    public function scopeWhereFromToDate(Builder $query, string $from, string $to, string $column = 'created_at', string $cast = 'DATE', string $scope = 'LAST_30_DAYS')
    {
        if (! $from && ! $to) {
            [$from, $to] = $this->{$this->methods[$scope]}(new Carbon);
        }

        $query->whereRaw("$column::$cast BETWEEN ? AND ?", [$from, $to]);
    }

    private function getLast30Days(Carbon $carbon) : array
    {
        return [
            $carbon->now()->subDays(29)->format('Y-m-d'),

            $carbon->now()->format('Y-m-d'),
        ];
    }

    private function getCurrentMonth(Carbon $carbon) : array
    {
        return [
            $carbon->firstOfMonth()->format('Y-m-d'),

            $carbon->lastOfMonth()->format('Y-m-d'),
        ];
    }
}
