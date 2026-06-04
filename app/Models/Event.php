<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'category',
        'description',
        'event_date',
        'event_time',
        'location',
        'quota',
        'points',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'time',
    ];

    /**
     * Get all registrations for this event
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the number of available slots
     */
    public function getAvailableSlots(): int
    {
        $registeredCount = $this->registrations()
            ->where('attendance', '!=', 'Absent')
            ->count();
        
        return max(0, $this->quota - $registeredCount);
    }

    /**
     * Check if event is full
     */
    public function isFull(): bool
    {
        return $this->getAvailableSlots() <= 0;
    }
}
