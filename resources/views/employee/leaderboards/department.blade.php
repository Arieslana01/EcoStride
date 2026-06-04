@extends('employee.layout')

@section('title', 'Department Leaderboard')

@section('content')
    <style>
        .leaderboard-header {
            margin-bottom: 2rem;
        }

        .leaderboard-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
        }

        .leaderboard-subtitle {
            color: #999;
            margin-bottom: 1.5rem;
        }

        .view-toggle {
            display: flex;
            gap: 0.75rem;
            background: white;
            padding: 0.4rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            width: fit-content;
        }

        .view-toggle .btn {
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            background: transparent;
            color: var(--dark-gray);
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .view-toggle .btn.active {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
        }

        .current-dept-card {
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.08) 0%, rgba(40, 199, 217, 0.08) 100%);
            border: 2px solid var(--primary-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: 80px 1fr 150px;
            align-items: center;
            gap: 1.5rem;
        }

        .rank-display {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .rank-display.top-rank {
            font-size: 3rem;
        }

        .dept-info h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin: 0 0 0.25rem 0;
        }

        .dept-employee-count {
            color: #999;
            font-size: 0.9rem;
        }

        .points-display-card {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .points-value {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--secondary-color), #18a5b1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .points-label {
            font-size: 0.8rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .leaderboard-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .leaderboard-entry {
            background: white;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            display: grid;
            grid-template-columns: 60px 1fr 80px 120px;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
        }

        .leaderboard-entry:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .leaderboard-entry.current-dept {
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.05), rgba(40, 199, 217, 0.05));
            border: 2px solid var(--primary-color);
        }

        .rank-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .rank-badge.gold {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
        }

        .rank-badge.silver {
            background: linear-gradient(135deg, #C0C0C0, #808080);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
        }

        .rank-badge.bronze {
            background: linear-gradient(135deg, #CD7F32, #A0673D);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
        }

        .rank-badge.number {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: var(--dark-gray);
            font-size: 1.25rem;
        }

        .entry-dept-name {
            font-weight: 700;
            color: var(--dark-gray);
            font-size: 1rem;
            margin: 0;
        }

        .entry-employee-count {
            display: inline-block;
            background: var(--light-gray);
            padding: 0.4rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            color: var(--dark-gray);
            font-weight: 600;
            text-align: center;
        }

        .entry-points {
            text-align: right;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, var(--secondary-color), #18a5b1);
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-size: 1rem;
        }

        .info-card {
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.05), rgba(40, 199, 217, 0.05));
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .info-card h6 {
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 1rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 0.5rem 0;
            color: #666;
            font-size: 0.9rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list strong {
            color: var(--dark-gray);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.05), rgba(40, 199, 217, 0.05));
            border-radius: 16px;
            color: #999;
        }

        @media (max-width: 768px) {
            .current-dept-card {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .leaderboard-entry {
                grid-template-columns: 50px 1fr 100px;
                gap: 1rem;
                padding: 1rem 1.25rem;
            }

            .entry-employee-count {
                display: none;
            }

            .entry-points {
                padding: 0.4rem 0.75rem;
                font-size: 0.85rem;
            }
        }
    </style>

    <!-- Header -->
    <div class="leaderboard-header">
        <h1 class="leaderboard-title">🏢 Department Leaderboard</h1>
        <p class="leaderboard-subtitle">See how your department ranks in sustainability!</p>
        <div class="view-toggle">
            <a href="{{ route('leaderboards.individual') }}" class="btn @if(request()->routeIs('leaderboards.individual')) active @endif">
                Individual
            </a>
            <a href="{{ route('leaderboards.department') }}" class="btn @if(request()->routeIs('leaderboards.department')) active @endif">
                Department
            </a>
        </div>
    </div>

    <!-- Current Department Info -->
    @if($currentUserDeptRank)
        <div class="current-dept-card">
            <div class="rank-display @if($currentUserDeptRank->rank <= 3) top-rank @endif">
                @if($currentUserDeptRank->rank == 1)
                    🥇
                @elseif($currentUserDeptRank->rank == 2)
                    🥈
                @elseif($currentUserDeptRank->rank == 3)
                    🥉
                @else
                    #{{ $currentUserDeptRank->rank }}
                @endif
            </div>
            <div class="dept-info">
                <h5>{{ $currentUserDeptRank->department }} <span style="font-weight: 500; font-size: 0.85rem;">(Your Dept)</span></h5>
                <p class="dept-employee-count">{{ $currentUserDeptRank->employee_count }} employees</p>
            </div>
            <div class="points-display-card">
                <div class="points-value">{{ $currentUserDeptRank->total_points }}</div>
                <div class="points-label">Points</div>
            </div>
        </div>
    @endif

    <!-- Department Rankings -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Department Rankings</h5>
        </div>
        <div class="card-body" style="padding: 1rem;">
            @if(count($leaderboard) > 0)
                <div class="leaderboard-list">
                    @foreach($leaderboard as $index => $dept)
                        <div class="leaderboard-entry @if(auth()->user()->department === $dept->department) current-dept @endif">
                            <div class="rank-badge @if($dept->rank == 1) gold @elseif($dept->rank == 2) silver @elseif($dept->rank == 3) bronze @else number @endif">
                                @if($dept->rank == 1)
                                    🥇
                                @elseif($dept->rank == 2)
                                    🥈
                                @elseif($dept->rank == 3)
                                    🥉
                                @else
                                    #{{ $dept->rank }}
                                @endif
                            </div>
                            <div>
                                <p class="entry-dept-name">
                                    {{ $dept->department }}
                                    @if(auth()->user()->department === $dept->department)
                                        <span style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 600; margin-left: 0.5rem;">(You)</span>
                                    @endif
                                </p>
                            </div>
                            <div class="entry-employee-count">
                                {{ $dept->employee_count }} 👥
                            </div>
                            <div class="entry-points">{{ $dept->total_points }} pts</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <p>No departments found in the leaderboard yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Average Stats Section -->
    @php
        if(count($leaderboard) > 0) {
            $avgLeaderboard = collect($leaderboard)
                ->map(function($dept) {
                    $dept->avg_points = $dept->employee_count > 0 ? round($dept->total_points / $dept->employee_count) : 0;
                    return $dept;
                })
                ->sortByDesc('avg_points');
        }
    @endphp

    @if(isset($avgLeaderboard) && count($avgLeaderboard) > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Average Points per Employee</h5>
            </div>
            <div class="card-body" style="padding: 1rem;">
                <div class="leaderboard-list">
                    @foreach($avgLeaderboard->take(5) as $dept)
                        <div class="leaderboard-entry @if(auth()->user()->department === $dept->department) current-dept @endif">
                            <div class="rank-badge number">
                                🔹
                            </div>
                            <div>
                                <p class="entry-dept-name">
                                    {{ $dept->department }}
                                    @if(auth()->user()->department === $dept->department)
                                        <span style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 600; margin-left: 0.5rem;">(You)</span>
                                    @endif
                                </p>
                            </div>
                            <div class="entry-employee-count">
                                {{ $dept->employee_count }} 👥
                            </div>
                            <div class="entry-points">{{ $dept->avg_points }} pts/avg</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Info Card -->
    <div class="info-card">
        <h6>How Points Are Calculated</h6>
        <ul class="info-list">
            <li><strong>Total Points:</strong> Sum of all employees' daily check-ins + event attendance</li>
            <li><strong>Ranking:</strong> Departments ranked by cumulative points</li>
            <li><strong>Average Points:</strong> Total points divided by number of employees</li>
            <li><strong>Includes:</strong> Daily check-ins (up to 35 pts/day) + event attendance (50 pts/event)</li>
        </ul>
    </div>
@endsection
