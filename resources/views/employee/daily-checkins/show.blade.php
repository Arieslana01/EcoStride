@extends('employee.layout')

@section('title', 'Check-In Details')

@section('content')
    <style>
        .details-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .details-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-gray);
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
            align-items: start;
        }

        @media (max-width: 992px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        .details-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .details-card:hover {
            box-shadow: 0 8px 24px rgba(90, 45, 145, 0.06);
        }

        .details-card-header {
            background-color: #fcfcfc;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.25rem 1.5rem;
        }

        .details-card-header h5 {
            margin: 0;
            font-weight: 700;
            color: var(--dark-gray);
            font-size: 1.1rem;
        }

        .details-card-body {
            padding: 1.5rem;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            background: #fafafa;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .activity-row:hover {
            background: #ffffff;
            border-color: rgba(90, 45, 145, 0.15);
            transform: translateX(4px);
        }

        .activity-row.completed {
            border-left: 4px solid #10b981;
        }

        .activity-row.not-completed {
            border-left: 4px solid #9ca3af;
            opacity: 0.75;
        }

        .activity-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .activity-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .activity-row.completed .activity-icon-box {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .activity-row.not-completed .activity-icon-box {
            background-color: rgba(156, 163, 175, 0.1);
            color: #9ca3af;
        }

        .activity-name {
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.95rem;
        }

        .activity-pts-badge {
            background: rgba(40, 199, 217, 0.1);
            color: #18a5b1;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .points-summary-box {
            padding: 1.5rem 1rem;
            text-align: center;
        }

        .big-points-value {
            font-size: 3.5rem;
            font-weight: 850;
            color: var(--primary-color);
            margin: 0.5rem 0;
            line-height: 1;
        }

        .meta-list {
            margin-top: 1.5rem;
            border-top: 1px solid #f0f0f0;
            padding-top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-align: left;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .meta-label {
            color: #71717a;
            font-weight: 500;
        }

        .meta-value {
            color: var(--dark-gray);
            font-weight: 600;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            background: white;
            border: 1.5px solid var(--primary-color);
            border-radius: 12px;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .btn-back:hover {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(90, 45, 145, 0.15);
            transform: translateY(-1px);
        }
    </style>

    <!-- Header -->
    <div class="details-header">
        <div>
            <h1 class="details-title">Check-In Details</h1>
            <p class="text-muted small mb-0">Tracked actions for {{ $checkin->date->format('l, M d, Y') }}</p>
        </div>
        <a href="{{ route('checkins.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            <span>Back to History</span>
        </a>
    </div>

    <!-- Details Grid -->
    <div class="details-grid">
        <!-- Left: Activities Completed -->
        <div class="details-card">
            <div class="details-card-header">
                <h5>Activities Completed</h5>
            </div>
            <div class="details-card-body">
                <div class="activity-list">
                    @php
                        $activities = [
                            ['key' => 'tumbler', 'name' => 'Bring Tumbler', 'icon' => 'bi-cup-straw', 'points' => 5],
                            ['key' => 'public_transport_bicycle', 'name' => 'Public Transportation/Bicycle', 'icon' => 'bi-bicycle', 'points' => 10],
                            ['key' => 'exercise', 'name' => 'Exercise Today', 'icon' => 'bi-heart-pulse', 'points' => 15],
                            ['key' => 'lunch_box', 'name' => 'Lunch Box / Reusable Container', 'icon' => 'bi-box-seam', 'points' => 5],
                        ];
                    @endphp

                    @foreach($activities as $activity)
                        @php
                            $isCompleted = $checkin->{$activity['key']};
                        @endphp
                        <div class="activity-row {{ $isCompleted ? 'completed' : 'not-completed' }}">
                            <div class="activity-info">
                                @if($isCompleted)
                                    <i class="bi bi-check-circle-fill text-success" style="font-size: 1.25rem;" title="Completed"></i>
                                @else
                                    <i class="bi bi-x-circle text-muted" style="font-size: 1.25rem;" title="Not Completed"></i>
                                @endif
                                <div class="activity-icon-box">
                                    <i class="bi {{ $activity['icon'] }}"></i>
                                </div>
                                <span class="activity-name">{{ $activity['name'] }}</span>
                            </div>
                            <div>
                                <span class="activity-pts-badge">{{ $isCompleted ? '+' : '' }}{{ $activity['points'] }} pts</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Points Summary -->
        <div class="details-card">
            <div class="details-card-header">
                <h5>Points Summary</h5>
            </div>
            <div class="details-card-body">
                <div class="points-summary-box">
                    <div class="big-points-value">
                        {{ $checkin->total_points }}
                    </div>
                    <p style="font-weight: 700; color: #4b5563; margin-bottom: 0;">Total Points Earned</p>
                    
                    <div class="meta-list">
                        <div class="meta-item">
                            <span class="meta-label">Date Logged</span>
                            <span class="meta-value">{{ $checkin->date->format('l, M d, Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Submitted On</span>
                            <span class="meta-value">{{ $checkin->created_at->format('M d, Y \a\t H:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
