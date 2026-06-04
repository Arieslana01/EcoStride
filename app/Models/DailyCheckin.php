<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyCheckin extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'tumbler',
        'public_transport_bicycle',
        'exercise',
        'lunch_box',
        'total_points',
    ];

    protected $casts = [
        'date' => 'date',
        'tumbler' => 'boolean',
        'public_transport_bicycle' => 'boolean',
        'exercise' => 'boolean',
        'lunch_box' => 'boolean',
    ];

    /**
     * Get the user that owns this check-in
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total points based on selected activities
     */
    public function calculatePoints(): int
    {
        $points = 0;
        if ($this->tumbler) $points += 5;
        if ($this->public_transport_bicycle) $points += 10;
        if ($this->exercise) $points += 15;
        if ($this->lunch_box) $points += 5;
        
        return $points;
    }
}
