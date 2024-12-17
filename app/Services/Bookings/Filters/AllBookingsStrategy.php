<?php

namespace App\Services\Bookings\Filters;

use Illuminate\Database\Eloquent\Relations\HasMany;

class AllBookingsStrategy implements BookingFilterStrategy
{
    public function filter(HasMany $query): HasMany
    {
        return $query;
    }
}
