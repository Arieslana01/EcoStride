<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeEventController extends Controller
{
    /**
     * Display all upcoming events in a modern card layout.
     */
    public function index(): View
    {
        // Upcoming events are events that are not completed and have date >= today
        $events = Event::where('status', '!=', 'Completed')
            ->where('event_date', '>=', Carbon::today())
            ->orderBy('event_date', 'asc')
            ->get();

        return view('employee.events.index', compact('events'));
    }

    /**
     * Display a specific event's details.
     */
    public function show(Event $event): View
    {
        $userId = auth()->id();
        
        // Check if user is already registered for this event
        $isRegistered = EventRegistration::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->exists();

        // Get count of registered participants
        $registeredCount = $event->registrations()
            ->where('attendance', '!=', 'Absent')
            ->count();

        return view('employee.events.show', compact('event', 'isRegistered', 'registeredCount'));
    }

    /**
     * Register the employee for an event.
     */
    public function join(Request $request, Event $event)
    {
        $userId = auth()->id();

        // 1. Cannot join closed or completed event
        if ($event->status !== 'Open') {
            return redirect()->back()
                ->with('error', 'This event is closed or completed and cannot be joined.');
        }

        // 2. Cannot join same event twice
        $exists = EventRegistration::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'You have already registered for this event.');
        }

        // 3. Cannot join full event
        if ($event->isFull()) {
            return redirect()->back()
                ->with('error', 'This event is already full.');
        }

        // Create the registration
        EventRegistration::create([
            'user_id' => $userId,
            'event_id' => $event->id,
            'attendance' => 'Pending',
        ]);

        return redirect()->route('events.show', $event)
            ->with('success', 'You have successfully joined the event!');
    }

    /**
     * View joined events (upcoming and completed).
     */
    public function myEvents(): View
    {
        $userId = auth()->id();

        // Upcoming joined events (event_date >= today and event status !== Completed)
        $upcomingRegistrations = EventRegistration::where('user_id', $userId)
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->where('events.event_date', '>=', Carbon::today())
            ->where('events.status', '!=', 'Completed')
            ->orderBy('events.event_date', 'asc')
            ->select('event_registrations.*')
            ->with('event')
            ->get();

        // Completed events (event_date < today OR event status == Completed)
        $completedRegistrations = EventRegistration::where('user_id', $userId)
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->where(function ($query) {
                $query->where('events.event_date', '<', Carbon::today())
                      ->orWhere('events.status', '=', 'Completed');
            })
            ->orderBy('events.event_date', 'desc')
            ->select('event_registrations.*')
            ->with('event')
            ->get();

        return view('employee.events.my-events', compact('upcomingRegistrations', 'completedRegistrations'));
    }
}
