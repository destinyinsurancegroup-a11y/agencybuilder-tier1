<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'user_id',
        'activity_date',
        'calls',
        'answered',
        'stops',
        'presentations',
        'nos',
        'sales_apps',
        'sales_premium',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
        'calls'         => 'integer',
        'answered'      => 'integer',
        'stops'         => 'integer',
        'presentations' => 'integer',
        'nos'           => 'integer',
        'sales_apps'    => 'integer',
        'sales_premium' => 'decimal:2',
    ];

    public function scopeForUser(Builder $q, $userId): Builder
    {
        return $q->where('user_id', $userId);
    }

    public static function sumRange(Carbon $start, Carbon $end)
    {
        $userId = auth()->id();

        return static::forUser($userId)
            ->whereBetween('activity_date', [$start, $end])
            ->selectRaw('
                COALESCE(SUM(calls),0)           AS calls,
                COALESCE(SUM(answered),0)        AS answered,
                COALESCE(SUM(stops),0)           AS stops,
                COALESCE(SUM(presentations),0)   AS presentations,
                COALESCE(SUM(nos),0)             AS nos,
                COALESCE(SUM(sales_apps),0)      AS sales_apps,
                COALESCE(SUM(sales_premium),0)   AS sales_premium
            ')
            ->first();
    }
}
