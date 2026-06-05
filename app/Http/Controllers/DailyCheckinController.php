<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DailyCheckinController extends Controller
{
    /**
     * Display daily checkin index for employee.
     */
    public function index(): View
    {
        $userId = auth()->id();
        $checkins = DailyCheckin::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(15);

        $totalPoints = DailyCheckin::where('user_id', $userId)->sum('total_points');
        $todayCheckin = DailyCheckin::where('user_id', $userId)
            ->whereDate('date', Carbon::today())
            ->first();

        return view('employee.daily-checkins.index', compact('checkins', 'totalPoints', 'todayCheckin'));
    }

    /**
     * Show the form for creating a new daily checkin.
     */
    public function create(): View|RedirectResponse
    {
        $userId = auth()->id();
        $today = Carbon::today();

        // Check if user already has a checkin today
        $existingCheckin = DailyCheckin::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($existingCheckin) {
            return redirect()->route('checkins.index')
                ->with('warning', 'You have already submitted a check-in today.');
        }

        return view('employee.daily-checkins.create');
    }

    /**
     * Store a newly created daily checkin in storage.
     */
    public function store(Request $request)
    {
        $userId = auth()->id();
        $today = Carbon::today();

        // Check if user already has a checkin today
        $existingCheckin = DailyCheckin::where('user_id', $userId)
            ->whereDate('date', $today)
            ->first();

        if ($existingCheckin) {
            return redirect()->route('checkins.index')
                ->with('error', 'You can only submit one check-in per day.');
        }

        $validated = $request->validate([
            'tumbler' => ['boolean'],
            'public_transport_bicycle' => ['boolean'],
            'exercise' => ['boolean'],
            'lunch_box' => ['boolean'],
        ]);

        // Convert string 'on' to boolean
        $validated['tumbler'] = $request->has('tumbler');
        $validated['public_transport_bicycle'] = $request->has('public_transport_bicycle');
        $validated['exercise'] = $request->has('exercise');
        $validated['lunch_box'] = $request->has('lunch_box');

        // Ensure at least one activity is selected
        if (!($validated['tumbler'] || $validated['public_transport_bicycle'] || 
              $validated['exercise'] || $validated['lunch_box'])) {
            return redirect()->back()
                ->with('error', 'Please select at least one sustainability activity.')
                ->withInput();
        }

        $checkin = new DailyCheckin();
        $checkin->user_id = $userId;
        $checkin->date = $today;
        $checkin->tumbler = $validated['tumbler'];
        $checkin->public_transport_bicycle = $validated['public_transport_bicycle'];
        $checkin->exercise = $validated['exercise'];
        $checkin->lunch_box = $validated['lunch_box'];
        $checkin->total_points = $checkin->calculatePoints();
        $checkin->save();

        return redirect()->route('checkins.index')
            ->with('success', "Great! You earned {$checkin->total_points} points today!");
    }

    /**
     * Show daily checkin details.
     */
    public function show(DailyCheckin $checkin): View
    {
        if ($checkin->user_id !== auth()->id()) {
            abort(403);
        }

        return view('employee.daily-checkins.show', compact('checkin'));
    }
}
