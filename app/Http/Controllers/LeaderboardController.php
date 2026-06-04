<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    /**
     * Display individual employee leaderboard.
     */
    public function individual(): View
    {
        // Get all employees with their total points, ranked
        $leaderboard = User::where('role', 'employee')
            ->select(
                'users.id',
                'users.name',
                'users.department',
                'users.role',
                DB::raw('COALESCE(SUM(daily_checkins.total_points), 0) + COALESCE(SUM(CASE WHEN event_registrations.attendance = "Present" THEN events.points ELSE 0 END), 0) as total_points')
            )
            ->leftJoin('daily_checkins', 'users.id', '=', 'daily_checkins.user_id')
            ->leftJoin('event_registrations', 'users.id', '=', 'event_registrations.user_id')
            ->leftJoin('events', 'event_registrations.event_id', '=', 'events.id')
            ->groupBy('users.id', 'users.name', 'users.department', 'users.role')
            ->orderByDesc('total_points')
            ->get();

        // Add ranking
        $leaderboard = $leaderboard->map(function ($user, $index) {
            $user->rank = $index + 1;
            return $user;
        });

        // Get current user's rank
        $currentUser = auth()->user();
        $currentUserRank = $leaderboard->where('id', $currentUser->id)->first();

        return view('employee.leaderboards.individual', compact('leaderboard', 'currentUserRank'));
    }

    /**
     * Display department leaderboard.
     */
    public function department(): View
    {
        // Get all departments with their total points, ranked
        $departments = User::where('role', 'employee')
            ->select('department')
            ->distinct()
            ->get()
            ->map(function ($user) {
                return $user->department;
            });

        $leaderboard = [];
        foreach ($departments as $dept) {
            $totalPoints = User::where('role', 'employee')
                ->where('department', $dept)
                ->select(DB::raw('COALESCE(SUM(daily_checkins.total_points), 0) + COALESCE(SUM(CASE WHEN event_registrations.attendance = "Present" THEN events.points ELSE 0 END), 0) as total_points'))
                ->leftJoin('daily_checkins', 'users.id', '=', 'daily_checkins.user_id')
                ->leftJoin('event_registrations', 'users.id', '=', 'event_registrations.user_id')
                ->leftJoin('events', 'event_registrations.event_id', '=', 'events.id')
                ->value('total_points');

            $employeeCount = User::where('role', 'employee')
                ->where('department', $dept)
                ->count();

            $leaderboard[] = (object) [
                'department' => $dept,
                'total_points' => $totalPoints ?? 0,
                'employee_count' => $employeeCount,
            ];
        }

        // Sort by total points descending
        usort($leaderboard, function ($a, $b) {
            return $b->total_points <=> $a->total_points;
        });

        // Add ranking
        $leaderboard = array_map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        }, $leaderboard, array_keys($leaderboard));

        // Get current user's department info
        $currentUserDept = auth()->user()->department;
        $currentUserDeptRank = collect($leaderboard)
            ->where('department', $currentUserDept)
            ->first();

        return view('employee.leaderboards.department', compact('leaderboard', 'currentUserDeptRank'));
    }
}
