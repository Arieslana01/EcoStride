@extends('employee.layout')

@section('title', 'Department Leaderboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">🏢 Department Leaderboard</h2>
            <p class="text-muted mb-0">See how your department stacks up against others!</p>
        </div>
        <div>
            <a href="{{ route('leaderboards.individual') }}" class="btn btn-secondary me-2">
                👤 Individual
            </a>
            <a href="{{ route('leaderboards.department') }}" class="btn btn-primary active">
                🏢 Department
            </a>
        </div>
    </div>

    <!-- Current Department Info -->
    @if($currentUserDeptRank)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card" style="border: 2px solid var(--primary-color); background: linear-gradient(135deg, rgba(90, 45, 145, 0.05) 0%, rgba(40, 199, 217, 0.05) 100%);">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                @if($currentUserDeptRank->rank == 1)
                                    <div style="font-size: 3rem;">🥇</div>
                                    <p class="text-muted mb-0">1st Place</p>
                                @elseif($currentUserDeptRank->rank == 2)
                                    <div style="font-size: 3rem;">🥈</div>
                                    <p class="text-muted mb-0">2nd Place</p>
                                @elseif($currentUserDeptRank->rank == 3)
                                    <div style="font-size: 3rem;">🥉</div>
                                    <p class="text-muted mb-0">3rd Place</p>
                                @else
                                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-color);">#{{ $currentUserDeptRank->rank }}</div>
                                    <p class="text-muted mb-0">Your Dept Rank</p>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <h5 class="mb-1">{{ $currentUserDeptRank->department }}</h5>
                                <p class="text-muted mb-0">{{ $currentUserDeptRank->employee_count }} employees</p>
                            </div>
                            <div class="col-md-3 text-end">
                                <div style="font-size: 2rem; font-weight: bold; color: var(--secondary-color);">
                                    {{ $currentUserDeptRank->total_points }}
                                </div>
                                <p class="text-muted mb-0">Total Points</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Department Rankings Table -->
    <div class="card">
        <div class="card-header" style="background-color: var(--light-gray);">
            <h5 class="mb-0">📊 Department Rankings</h5>
        </div>
        <div class="card-body">
            @if(count($leaderboard) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;">Rank</th>
                                <th style="width: 40%;">Department</th>
                                <th style="width: 20%; text-align: center;">Employees</th>
                                <th style="width: 30%; text-align: right;">Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard as $index => $dept)
                                <tr @if(auth()->user()->department === $dept->department) style="background-color: var(--light-gray); border-left: 4px solid var(--primary-color);" @endif>
                                    <td class="fw-bold">
                                        @if($dept->rank == 1)
                                            🥇 1st
                                        @elseif($dept->rank == 2)
                                            🥈 2nd
                                        @elseif($dept->rank == 3)
                                            🥉 3rd
                                        @else
                                            #{{ $dept->rank }}
                                        @endif
                                    </td>
                                    <td class="fw-bold">
                                        {{ $dept->department }}
                                        @if(auth()->user()->department === $dept->department)
                                            <span class="badge bg-primary ms-2">Your Department</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="badge bg-light text-dark">
                                            {{ $dept->employee_count }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <span class="badge" style="font-size: 1rem; background-color: var(--secondary-color);">
                                            {{ $dept->total_points }} pts
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-4">
                    <p class="mb-0">No departments found in the leaderboard.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Department Breakdown -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">📊 Average Points by Department</h6>
                </div>
                <div class="card-body">
                    @php
                        $avgLeaderboard = collect($leaderboard)
                            ->map(function ($dept) {
                                $dept->avg_points = $dept->employee_count > 0 ? round($dept->total_points / $dept->employee_count, 2) : 0;
                                return $dept;
                            })
                            ->sortByDesc('avg_points')
                            ->values();
                    @endphp

                    <div class="list-group">
                        @foreach($avgLeaderboard->take(5) as $dept)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $dept->department }}</span>
                                <span class="badge bg-info">{{ $dept->avg_points }} pts/person</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">📌 How Department Ranking Works</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0 text-muted small">
                        <li><strong>Department Total:</strong> Sum of all employee points</li>
                        <li><strong>Includes:</strong> Daily check-ins + event attendance</li>
                        <li><strong>Fair Comparison:</strong> Total points are directly comparable</li>
                        <li><strong>Motivation:</strong> Encourage team-wide participation</li>
                        <li><strong>Recognition:</strong> Top departments will be featured!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
