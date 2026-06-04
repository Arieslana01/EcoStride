@extends('employee.layout')

@section('title', 'Individual Leaderboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">🏆 Individual Leaderboard</h2>
            <p class="text-muted mb-0">Compete with colleagues and climb the rankings!</p>
        </div>
        <div>
            <a href="{{ route('leaderboards.individual') }}" class="btn btn-primary active me-2">
                👤 Individual
            </a>
            <a href="{{ route('leaderboards.department') }}" class="btn btn-secondary">
                🏢 Department
            </a>
        </div>
    </div>

    <!-- Current User Info -->
    @if($currentUserRank)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card" style="border: 2px solid var(--primary-color); background: linear-gradient(135deg, rgba(90, 45, 145, 0.05) 0%, rgba(40, 199, 217, 0.05) 100%);">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                @if($currentUserRank->rank == 1)
                                    <div style="font-size: 3rem;">🥇</div>
                                    <p class="text-muted mb-0">1st Place</p>
                                @elseif($currentUserRank->rank == 2)
                                    <div style="font-size: 3rem;">🥈</div>
                                    <p class="text-muted mb-0">2nd Place</p>
                                @elseif($currentUserRank->rank == 3)
                                    <div style="font-size: 3rem;">🥉</div>
                                    <p class="text-muted mb-0">3rd Place</p>
                                @else
                                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-color);">#{{ $currentUserRank->rank }}</div>
                                    <p class="text-muted mb-0">Your Rank</p>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h5 class="mb-1">{{ $currentUserRank->name }}</h5>
                                <p class="text-muted mb-0">{{ $currentUserRank->department }}</p>
                            </div>
                            <div class="col-md-3 text-end">
                                <div style="font-size: 2rem; font-weight: bold; color: var(--secondary-color);">
                                    {{ $currentUserRank->total_points }}
                                </div>
                                <p class="text-muted mb-0">Total Points</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Leaderboard Table -->
    <div class="card">
        <div class="card-header" style="background-color: var(--light-gray);">
            <h5 class="mb-0">📊 Rankings</h5>
        </div>
        <div class="card-body">
            @if($leaderboard->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">Rank</th>
                                <th style="width: 30%;">Employee Name</th>
                                <th style="width: 30%;">Department</th>
                                <th style="width: 30%; text-align: right;">Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard as $index => $user)
                                <tr @if(auth()->user()->id === $user->id) style="background-color: var(--light-gray); border-left: 4px solid var(--primary-color);" @endif>
                                    <td class="fw-bold">
                                        @if($user->rank == 1)
                                            🥇 1st
                                        @elseif($user->rank == 2)
                                            🥈 2nd
                                        @elseif($user->rank == 3)
                                            🥉 3rd
                                        @else
                                            #{{ $user->rank }}
                                        @endif
                                    </td>
                                    <td class="fw-bold">
                                        {{ $user->name }}
                                        @if(auth()->user()->id === $user->id)
                                            <span class="badge bg-primary ms-2">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->department }}</td>
                                    <td style="text-align: right;">
                                        <span class="badge" style="font-size: 1rem; background-color: var(--secondary-color);">
                                            {{ $user->total_points }} pts
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <p class="mb-0">No employees found in the leaderboard.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">📌 How Points Are Calculated</h6>
                    <ul class="mb-0 text-muted small">
                        <li><strong>Daily Check-In:</strong> Up to 35 points per day (5+10+15+5)</li>
                        <li><strong>Event Attendance:</strong> 50 points per event attended</li>
                        <li><strong>Total Points:</strong> Sum of all daily check-ins + event attendance</li>
                        <li><strong>Ranking:</strong> Updated automatically based on cumulative points</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
