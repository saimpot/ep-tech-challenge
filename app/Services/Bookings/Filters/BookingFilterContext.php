<?php

namespace App\Services\Bookings\Filters;

use App\Constants\BookingFilterType;

class BookingFilterContext
{
    public static function resolve($filterType): BookingFilterStrategy
    {
        return match ($filterType) {
            BookingFilterType::FUTURE => new FutureBookingsStrategy(),
            BookingFilterType::PAST => new PastBookingsStrategy(),
            default => new AllBookingsStrategy(),
        };
    }
}
