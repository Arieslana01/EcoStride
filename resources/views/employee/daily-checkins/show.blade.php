@extends('employee.layout')

@section('title', 'Check-In Details')

@section('content')
    <div class="mb-4">
        <h2>✅ Check-In Details: {{ $checkin->date->format('M d, Y') }}</h2>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h5 class="mb-0">📋 Activities Completed</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @php
                            $activities = [
                                ['key' => 'tumbler', 'name' => '🥤 Bring Tumbler', 'points' => 5],
                                ['key' => 'public_transport_bicycle', 'name' => '🚴 Public Transportation/Bicycle', 'points' => 10],
                                ['key' => 'exercise', 'name' => '💪 Exercise Today', 'points' => 15],
                                ['key' => 'lunch_box', 'name' => '🍱 Lunch Box / Reusable Container', 'points' => 5],
                            ];
                        @endphp

                        @foreach($activities as $activity)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    @if($checkin->{$activity['key']})
                                        <span class="badge bg-success me-2">✓</span>
                                    @else
                                        <span class="badge bg-light text-dark me-2">✗</span>
                                    @endif
                                    {{ $activity['name'] }}
                                </span>
                                <span class="badge bg-info">{{ $activity['points'] }} pts</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h5 class="mb-0">🏆 Points Summary</h5>
                </div>
                <div class="card-body text-center">
                    <div style="font-size: 3rem; font-weight: bold; color: var(--primary-color); margin: 1rem 0;">
                        {{ $checkin->total_points }}
                    </div>
                    <p class="text-muted">Total Points Earned</p>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted">Submitted on</small>
                        <div class="h6">{{ $checkin->created_at->format('M d, Y \a\t H:i A') }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Date</small>
                        <div class="h6">{{ $checkin->date->format('dddd, M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body text-center">
                    <a href="{{ route('checkins.index') }}" class="btn btn-secondary">
                        ← Back to Check-In History
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
