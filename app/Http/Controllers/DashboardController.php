<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckin;
use App\Models\Event;
use App\Models\EventRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display employee dashboard.
     */
    public function employee(): View
    {
        $userId = auth()->id();

        // Total accumulated points
        $totalPoints = DailyCheckin::where('user_id', $userId)->sum('total_points') +
            EventRegistration::where('user_id', $userId)
                ->where('attendance', 'Present')
                ->join('events', 'event_registrations.event_id', '=', 'events.id')
                ->sum('events.points');

        // Checkins this month
        $monthlyCheckins = DailyCheckin::where('user_id', $userId)
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->count();

        // Events attended this month
        $eventsAttended = EventRegistration::where('user_id', $userId)
            ->where('attendance', 'Present')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->whereYear('events.event_date', Carbon::now()->year)
            ->whereMonth('events.event_date', Carbon::now()->month)
            ->count();

        // Upcoming events
        $upcomingEvents = Event::where('status', 'Open')
            ->where('event_date', '>=', Carbon::today())
            ->orderBy('event_date')
            ->take(5)
            ->get();

        // Recent check-ins
        $recentCheckins = DailyCheckin::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Individual ranking
        $allPoints = DailyCheckin::select(
            'users.id',
            'users.name',
            DB::raw('COALESCE(SUM(daily_checkins.total_points), 0) + COALESCE(SUM(CASE WHEN event_registrations.attendance = "Present" THEN events.points ELSE 0 END), 0) as total_points')
        )
            ->leftJoin('users', 'daily_checkins.user_id', '=', 'users.id')
            ->leftJoin('event_registrations', 'users.id', '=', 'event_registrations.user_id')
            ->leftJoin('events', 'event_registrations.event_id', '=', 'events.id')
            ->where('users.role', 'employee')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_points')
            ->get();

        $userRank = $allPoints->search(function ($item) use ($userId) {
            return $item->id == $userId;
        });
        $userRank = $userRank !== false ? $userRank + 1 : 'N/A';

        // Department ranking
        $deptPoints = DB::table('users')
            ->where('role', 'employee')
            ->select(
                'department',
                DB::raw('COALESCE(SUM(daily_checkins.total_points), 0) + COALESCE(SUM(CASE WHEN event_registrations.attendance = "Present" THEN events.points ELSE 0 END), 0) as total_points')
            )
            ->leftJoin('daily_checkins', 'users.id', '=', 'daily_checkins.user_id')
            ->leftJoin('event_registrations', 'users.id', '=', 'event_registrations.user_id')
            ->leftJoin('events', 'event_registrations.event_id', '=', 'events.id')
            ->groupBy('department')
            ->orderByDesc('total_points')
            ->get();

        $deptRank = $deptPoints->search(function ($item) {
            return $item->department == auth()->user()->department;
        });
        $deptRank = $deptRank !== false ? $deptRank + 1 : 'N/A';

        // Monthly check-in data for chart
        $monthlyData = DailyCheckin::where('user_id', $userId)
            ->selectRaw('DAY(date) as day, SUM(total_points) as points')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Activity distribution
        $tumbler = DailyCheckin::where('user_id', $userId)->where('tumbler', true)->count();
        $transport = DailyCheckin::where('user_id', $userId)->where('public_transport_bicycle', true)->count();
        $exercise = DailyCheckin::where('user_id', $userId)->where('exercise', true)->count();
        $lunch = DailyCheckin::where('user_id', $userId)->where('lunch_box', true)->count();

        // Build leaderboard for dashboard preview (same data, aliased for view)
        $leaderboard = $allPoints;

        return view('employee.dashboard', compact(
            'totalPoints',
            'monthlyCheckins',
            'eventsAttended',
            'upcomingEvents',
            'recentCheckins',
            'userRank',
            'deptRank',
            'monthlyData',
            'tumbler',
            'transport',
            'exercise',
            'lunch',
            'leaderboard'
        ));
    }

    /**
     * Display admin dashboard.
     */
    public function admin(): View
    {
        // Total statistics
        $totalEmployees = \App\Models\User::where('role', 'employee')->count();
        $totalDepartments = \App\Models\User::where('role', 'employee')->distinct('department')->count();
        $totalEvents = Event::count();
        $totalCheckins = DailyCheckin::count();

        // Most active employee
        $mostActiveEmployee = \App\Models\User::where('role', 'employee')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COALESCE(SUM(daily_checkins.total_points), 0) + COALESCE(SUM(CASE WHEN event_registrations.attendance = "Present" THEN events.points ELSE 0 END), 0) as total_points')
            )
            ->leftJoin('daily_checkins', 'users.id', '=', 'daily_checkins.user_id')
            ->leftJoin('event_registrations', 'users.id', '=', 'event_registrations.user_id')
            ->leftJoin('events', 'event_registrations.event_id', '=', 'events.id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_points')
            ->first();

        // Most active department
        $mostActiveDept = DB::table('users')
            ->where('role', 'employee')
            ->select(
                'department',
                DB::raw('COALESCE(SUM(daily_checkins.total_points), 0) + COALESCE(SUM(CASE WHEN event_registrations.attendance = "Present" THEN events.points ELSE 0 END), 0) as total_points')
            )
            ->leftJoin('daily_checkins', 'users.id', '=', 'daily_checkins.user_id')
            ->leftJoin('event_registrations', 'users.id', '=', 'event_registrations.user_id')
            ->leftJoin('events', 'event_registrations.event_id', '=', 'events.id')
            ->groupBy('department')
            ->orderByDesc('total_points')
            ->first();

        // Monthly participation
        $monthlyParticipation = DailyCheckin::selectRaw('DAY(date) as day, COUNT(DISTINCT user_id) as participants, SUM(total_points) as total_points')
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalDepartments',
            'totalEvents',
            'totalCheckins',
            'mostActiveEmployee',
            'mostActiveDept',
            'monthlyParticipation'
        ));
    }
}
