<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'anniversary_date',
    ];

    protected $casts = [
        'dob'              => 'date',
        'anniversary_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /** upcoming birthdays/anniversaries helper (next N days) */
    public function scopeUpcomingDate(Builder $q, string $column, Carbon $from, int $days = 10): Builder
    {
        // works in Postgres: compare month/day ignoring year, within next N days
        $start = $from->copy();
        $end   = $from->copy()->addDays($days);

        return $q->whereNotNull($column)
            ->whereRaw("
                to_char({$column}, 'MM-DD') BETWEEN to_char(?::date, 'MM-DD')
                                               AND     to_char(?::date, 'MM-DD')
            ", [$start->toDateString(), $end->toDateString()]);
    }
}
