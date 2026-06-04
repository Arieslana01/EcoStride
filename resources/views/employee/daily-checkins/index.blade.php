@extends('employee.layout')

@section('title', 'Daily Check-In History')

@section('content')
    <style>
        .checkin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .checkin-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-gray);
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-badge.submitted {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #999;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .checkin-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .checkin-item {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }

        .checkin-item:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .checkin-date {
            font-weight: 700;
            color: var(--primary-color);
            min-width: 120px;
        }

        .checkin-activities {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            flex: 1;
        }

        .activity-tag {
            background: var(--light-gray);
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--dark-gray);
        }

        .checkin-points {
            background: linear-gradient(135deg, var(--secondary-color), #18a5b1);
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-weight: 700;
            white-space: nowrap;
            text-align: center;
        }

        .checkin-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            white-space: nowrap;
        }

        .empty-state {
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.05), rgba(40, 199, 217, 0.05));
            border: 2px dashed #e5e7eb;
            border-radius: 16px;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            color: #999;
            margin-bottom: 1.5rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.6rem 0.8rem;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
        }

        .pagination a {
            background: white;
            color: var(--primary-color);
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: var(--primary-color);
            color: white;
        }

        .pagination span.active {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
        }

        @media (max-width: 768px) {
            .checkin-item {
                flex-direction: column;
                text-align: center;
            }

            .checkin-date {
                min-width: auto;
            }

            .checkin-actions {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <!-- Header -->
    <div class="checkin-header">
        <h1 class="checkin-title">✅ Check-In History</h1>
        @if(!$todayCheckin)
            <a href="{{ route('checkins.create') }}" class="btn btn-primary">
                ➕ Submit Today
            </a>
        @else
            <div class="status-badge submitted">
                ✓ Today submitted!
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Points</div>
            <div class="stat-value">{{ $totalPoints }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Check-ins</div>
            <div class="stat-value">{{ $checkins->total() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Average Points</div>
            <div class="stat-value">
                {{ $checkins->total() > 0 ? round($totalPoints / $checkins->total()) : 0 }}
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Streak</div>
            <div class="stat-value">7</div>
        </div>
    </div>

    <!-- Check-in List -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Your Check-ins</h5>
        </div>
        <div class="card-body" style="padding: 1rem;">
            @if($checkins->count() > 0)
                <div class="checkin-list">
                    @foreach($checkins as $checkin)
                        <div class="checkin-item">
                            <div class="checkin-date">
                                {{ $checkin->date->format('M d, Y') }}
                            </div>
                            <div class="checkin-activities">
                                @php
                                    $activities = [];
                                    if ($checkin->tumbler) $activities[] = '🥤';
                                    if ($checkin->public_transport_bicycle) $activities[] = '🚴';
                                    if ($checkin->exercise) $activities[] = '💪';
                                    if ($checkin->lunch_box) $activities[] = '🍱';
                                @endphp
                                @foreach($activities as $activity)
                                    <span class="activity-tag">{{ $activity }}</span>
                                @endforeach
                            </div>
                            <div class="checkin-points">
                                +{{ $checkin->total_points }} pts
                            </div>
                            <div class="checkin-actions">
                                <a href="{{ route('checkins.show', $checkin) }}" class="btn btn-secondary btn-small">
                                    👁️ View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $checkins->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📝</div>
                    <div class="empty-state-title">No check-ins yet</div>
                    <div class="empty-state-text">Start tracking your sustainability activities today!</div>
                    <a href="{{ route('checkins.create') }}" class="btn btn-primary">
                        Submit Your First Check-In
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
