<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReminderGuest extends Pivot
{
    protected $appends = [
        'human_readable_date',
    ];

    public function getHumanReadableDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
