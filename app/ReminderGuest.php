<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReminderGuest extends Pivot
{
    public const REFUSED = 0;

    public const PENDING = 1;

    public const ACCEPTED = 2;

    protected $appends = [
        'human_readable_date',
    ];

    public function getHumanReadableDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
