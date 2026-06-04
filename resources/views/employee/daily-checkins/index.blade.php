@extends('employee.layout')

@section('title', 'Daily Check-In History')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            ✅ Daily Sustainability Check-In
        </h2>
        @if(!$todayCheckin)
            <a href="{{ route('checkins.create') }}" class="btn btn-primary">
                ➕ Submit Today's Check-In
            </a>
        @else
            <span class="badge bg-success" style="font-size: 1rem;">
                ✓ Today's check-in submitted!
            </span>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label">Total Points</div>
                <div class="stat-value">{{ $totalPoints }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label">Check-ins</div>
                <div class="stat-value">{{ $checkins->total() }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label">Average Points</div>
                <div class="stat-value">
                    {{ $checkins->total() > 0 ? round($totalPoints / $checkins->total()) : 0 }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label">Streak</div>
                <div class="stat-value">0</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="background-color: var(--light-gray);">
            <h5 class="mb-0">📋 Check-In History</h5>
        </div>
        <div class="card-body">
            @if($checkins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Activities</th>
                                <th>Points Earned</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkins as $checkin)
                                <tr>
                                    <td class="fw-bold">{{ $checkin->date->format('M d, Y') }}</td>
                                    <td>
                                        @php
                                            $activities = [];
                                            if ($checkin->tumbler) $activities[] = '🥤 Tumbler';
                                            if ($checkin->public_transport_bicycle) $activities[] = '🚴 Public Transport/Bicycle';
                                            if ($checkin->exercise) $activities[] = '💪 Exercise';
                                            if ($checkin->lunch_box) $activities[] = '🍱 Lunch Box';
                                        @endphp
                                        {{ implode(' | ', $activities) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success" style="font-size: 1rem;">
                                            +{{ $checkin->total_points }} pts
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('checkins.show', $checkin) }}" 
                                           class="btn btn-sm btn-secondary">
                                            👁️ View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    {{ $checkins->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info text-center py-4">
                    <p class="mb-0">No check-ins yet. <a href="{{ route('checkins.create') }}">Submit your first check-in</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection
