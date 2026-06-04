<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'attendance',
    ];

    protected $casts = [
        'attendance' => 'string',
    ];

    /**
     * Get the user associated with this registration
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event associated with this registration
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Check if user attended the event
     */
    public function isAttended(): bool
    {
        return $this->attendance === 'Present';
    }
}
