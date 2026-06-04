<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(): View
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        $categories = [
            'Tennis',
            'Table Tennis',
            'Padel',
            'Mini Soccer',
            'Yoga',
            'Pilates',
        ];

        $statuses = [
            'Open' => 'Open',
            'Closed' => 'Closed',
            'Completed' => 'Completed',
        ];

        return view('admin.events.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Tennis,Table Tennis,Padel,Mini Soccer,Yoga,Pilates'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'points' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Open,Closed,Completed'],
        ]);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        $categories = [
            'Tennis',
            'Table Tennis',
            'Padel',
            'Mini Soccer',
            'Yoga',
            'Pilates',
        ];

        $statuses = [
            'Open' => 'Open',
            'Closed' => 'Closed',
            'Completed' => 'Completed',
        ];

        return view('admin.events.edit', compact('event', 'categories', 'statuses'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Tennis,Table Tennis,Padel,Mini Soccer,Yoga,Pilates'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'event_time' => ['required', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'points' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Open,Closed,Completed'],
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete related registrations first
        $event->registrations()->delete();
        
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
