<?php

namespace App\Constants;

class BookingFilterType
{
    public const ALL = 'all';
    public const FUTURE = 'future';
    public const PAST = 'past';

    /**
     * Check if a given filter is valid.
     *
     * @param string $filter
     * @return bool
     */
    public static function isValid(string $filter): bool
    {
        return in_array($filter, [self::ALL, self::FUTURE, self::PAST]);
    }
}
