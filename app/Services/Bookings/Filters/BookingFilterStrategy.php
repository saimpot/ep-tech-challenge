<?php

namespace App\Services\Bookings\Filters;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface BookingFilterStrategy
{
    public function filter(HasMany $query): HasMany;
}
