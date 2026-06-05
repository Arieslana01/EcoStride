<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
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
            'event_time' => ['required'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'points' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Open,Closed,Completed'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/events'), $filename);
            $validated['image'] = $filename;
        } else {
            // Default to category default image
            $categoryImages = [
                'Tennis' => 'tennis.png',
                'Table Tennis' => 'table_tennis.png',
                'Padel' => 'padel.png',
                'Mini Soccer' => 'mini_soccer.png',
                'Yoga' => 'yoga.png',
                'Pilates' => 'pilates.png',
            ];
            $validated['image'] = $categoryImages[$validated['category']] ?? null;
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display a specific event's participants and details.
     */
    public function show(Event $event): View
    {
        $registrations = $event->registrations()->with('user')->get();
        return view('admin.events.show', compact('event', 'registrations'));
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
            'event_time' => ['required'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'points' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Open,Closed,Completed'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/events'), $filename);

            // Delete old custom image if exists
            $defaults = ['tennis.png', 'table_tennis.png', 'padel.png', 'mini_soccer.png', 'yoga.png', 'pilates.png'];
            if ($event->image && !in_array($event->image, $defaults)) {
                $oldPath = public_path('images/events/' . $event->image);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            $validated['image'] = $filename;
        }

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

        // Delete custom image if exists
        $defaults = ['tennis.png', 'table_tennis.png', 'padel.png', 'mini_soccer.png', 'yoga.png', 'pilates.png'];
        if ($event->image && !in_array($event->image, $defaults)) {
            $oldPath = public_path('images/events/' . $event->image);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }
        
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Mark attendance for a registration.
     */
    public function markAttendance(Request $request, EventRegistration $registration)
    {
        $validated = $request->validate([
            'attendance' => ['required', 'in:Present,Absent'],
        ]);

        $registration->update([
            'attendance' => $validated['attendance'],
        ]);

        return redirect()->back()
            ->with('success', 'Attendance marked as ' . $validated['attendance'] . ' successfully.');
    }
}
