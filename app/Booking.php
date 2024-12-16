<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    public function getStartAttribute($value): string
    {
        return $this->attributes['start'] = Carbon::parse($value)->toIso8601String();
    }

    public function getEndAttribute($value): string
    {
        return $this->attributes['end'] = Carbon::parse($value)->toIso8601String();
    }
}
