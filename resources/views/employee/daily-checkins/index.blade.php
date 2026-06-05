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
            display: inline-flex;
            align-items: center;
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 10px 30px rgba(90, 45, 145, 0.06);
            transform: translateY(-2px);
            border-color: rgba(90, 45, 145, 0.1);
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bg-light-purple { background-color: rgba(90, 45, 145, 0.1); }
        .text-purple { color: var(--primary-color); }

        .bg-light-cyan { background-color: rgba(40, 199, 217, 0.1); }
        .text-cyan { color: var(--secondary-color); }

        .bg-light-pink { background-color: rgba(233, 30, 143, 0.1); }
        .text-pink { color: var(--accent-color); }

        .bg-light-yellow { background-color: rgba(254, 239, 195, 0.5); }
        .text-yellow { color: #b06000; }

        .stat-details {
            text-align: left;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark-gray);
            margin: 0;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .checkin-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .checkin-item {
            background: white;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }

        .checkin-item:hover {
            box-shadow: 0 8px 24px rgba(90, 45, 145, 0.08);
            border-color: rgba(90, 45, 145, 0.2);
            border-left-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .checkin-date {
            font-weight: 700;
            color: var(--primary-color);
            min-width: 120px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkin-activities {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            flex: 1;
        }

        .activity-tag {
            padding: 0.4rem 0.8rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .activity-tag.tag-tumbler {
            background-color: #e6f4ea;
            color: #137333;
        }
        .activity-tag.tag-tumbler i {
            color: #137333 !important;
        }

        .activity-tag.tag-commute {
            background-color: #f3e8ff;
            color: #6b21a8;
        }
        .activity-tag.tag-commute i {
            color: #6b21a8 !important;
        }

        .activity-tag.tag-exercise {
            background-color: #fce8e6;
            color: #c5221f;
        }
        .activity-tag.tag-exercise i {
            color: #c5221f !important;
        }

        .activity-tag.tag-lunch {
            background-color: #feefc3;
            color: #b06000;
        }
        .activity-tag.tag-lunch i {
            color: #b06000 !important;
        }

        .checkin-points {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 0.85rem;
            border-radius: 20px;
            font-weight: 700;
            white-space: nowrap;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(90, 45, 145, 0.2);
            text-align: center;
        }

        .checkin-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-small {
            background-color: transparent;
            border: 1.5px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            text-decoration: none;
        }

        .btn-small:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(90, 45, 145, 0.2);
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
            background: var(--primary-color);
            color: white;
        }

        @media (max-width: 768px) {
            .checkin-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
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
        <div>
            <h1 class="checkin-title">Check-In History</h1>
            <p class="text-muted small mb-0">Review your sustainability logs and tracked points</p>
        </div>
        @if(!$todayCheckin)
            <a href="{{ route('checkins.create') }}" class="btn btn-primary d-flex align-items-center gap-2" style="text-decoration: none;">
                <i class="bi bi-plus-lg"></i>
                <span>Submit Today</span>
            </a>
        @else
            <div class="status-badge submitted d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span>Today submitted!</span>
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrapper bg-light-purple">
                <i class="bi bi-award text-purple" style="font-size: 1.5rem;"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value">{{ $totalPoints }}</div>
                <div class="stat-label">Total Points</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrapper bg-light-cyan">
                <i class="bi bi-check-all text-cyan" style="font-size: 1.5rem;"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value">{{ $checkins->total() }}</div>
                <div class="stat-label">Check-ins</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrapper bg-light-pink">
                <i class="bi bi-graph-up text-pink" style="font-size: 1.5rem;"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value">
                    {{ $checkins->total() > 0 ? round($totalPoints / $checkins->total()) : 0 }}
                </div>
                <div class="stat-label">Average Points</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrapper bg-light-yellow">
                <i class="bi bi-lightning-charge text-yellow" style="font-size: 1.5rem;"></i>
            </div>
            <div class="stat-details">
                <div class="stat-value">7</div>
                <div class="stat-label">Active Streak</div>
            </div>
        </div>
    </div>

    <!-- Check-in List -->
    <div class="card" style="border-radius: 16px; border: 1px solid #f0f0f0; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); overflow: hidden;">
        <div class="card-header" style="background-color: #fcfcfc; border-bottom: 1px solid #f0f0f0; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0" style="font-weight: 700; color: var(--dark-gray); font-size: 1.1rem;">Your Check-ins</h5>
        </div>
        <div class="card-body" style="padding: 1.5rem; background-color: #fafafa;">
            @if($checkins->count() > 0)
                <div class="checkin-list">
                    @foreach($checkins as $checkin)
                        <div class="checkin-item">
                            <div class="checkin-date">
                                <i class="bi bi-calendar3" style="font-size: 1.1rem; color: var(--primary-color);"></i>
                                <span style="font-size: 0.95rem; font-weight: 600; color: #4b5563;">{{ $checkin->date->format('D, M d, Y') }}</span>
                            </div>
                            <div class="checkin-activities">
                                @php
                                    $activities = [];
                                    if ($checkin->tumbler) {
                                        $activities[] = [
                                            'icon' => 'bi-cup-straw', 
                                            'label' => 'Tumbler',
                                            'class' => 'tag-tumbler'
                                        ];
                                    }
                                    if ($checkin->public_transport_bicycle) {
                                        $activities[] = [
                                            'icon' => 'bi-bicycle', 
                                            'label' => 'Commute',
                                            'class' => 'tag-commute'
                                        ];
                                    }
                                    if ($checkin->exercise) {
                                        $activities[] = [
                                            'icon' => 'bi-heart-pulse', 
                                            'label' => 'Exercise',
                                            'class' => 'tag-exercise'
                                        ];
                                    }
                                    if ($checkin->lunch_box) {
                                        $activities[] = [
                                            'icon' => 'bi-box-seam', 
                                            'label' => 'Lunch Box',
                                            'class' => 'tag-lunch'
                                        ];
                                    }
                                @endphp
                                @foreach($activities as $activity)
                                    <span class="activity-tag {{ $activity['class'] }}">
                                        <i class="bi {{ $activity['icon'] }}"></i>
                                        <span>{{ $activity['label'] }}</span>
                                    </span>
                                @endforeach
                            </div>
                            <div class="checkin-points">
                                +{{ $checkin->total_points }} pts
                            </div>
                            <div class="checkin-actions">
                                <a href="{{ route('checkins.show', $checkin) }}" class="btn-small">
                                    View
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
                    <div class="empty-state-icon" style="color: var(--primary-color);"><i class="bi bi-journal-text" style="font-size: 3.5rem;"></i></div>
                    <div class="empty-state-title">No check-ins yet</div>
                    <div class="empty-state-text">Start tracking your sustainability activities today!</div>
                    <a href="{{ route('checkins.create') }}" class="btn btn-primary" style="text-decoration: none;">
                        Submit Your First Check-In
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
