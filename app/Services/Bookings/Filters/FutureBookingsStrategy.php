<?php

namespace App\Services\Bookings\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FutureBookingsStrategy implements BookingFilterStrategy
{
    public function filter(HasMany $query): HasMany
    {
        return $query->where('start', '>=', Carbon::now());
    }
}
