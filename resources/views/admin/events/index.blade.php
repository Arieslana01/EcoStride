@extends('admin.layout')

@section('title', 'Event Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Event Management</h2>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Create events, manage registrations, and approve participants.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Create New Event
        </a>
    </div>

    <div class="card">
        <div class="card-body" style="padding: 0;">
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="margin-bottom: 0;">
                        <thead class="table-light">
                            <tr>
                                <th style="padding: 1rem 1.25rem;">Event Name</th>
                                <th style="padding: 1rem 1.25rem;">Category</th>
                                <th style="padding: 1rem 1.25rem;">Date & Time</th>
                                <th style="padding: 1rem 1.25rem;">Registrations</th>
                                <th style="padding: 1rem 1.25rem;">Points</th>
                                <th style="padding: 1rem 1.25rem;">Status</th>
                                <th style="padding: 1rem 1.25rem; text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                @php
                                    $pendingCount = $event->registrations()->where('attendance', 'Pending')->count();
                                    $approvedCount = $event->registrations()->where('attendance', 'Present')->count();
                                    $totalReg = $event->registrations()->count();
                                @endphp
                                <tr>
                                    <td style="padding: 1rem 1.25rem;">
                                        <div class="fw-bold">
                                            <a href="{{ route('admin.events.show', $event) }}" style="text-decoration: none; color: var(--primary-color);">
                                                {{ $event->title }}
                                            </a>
                                        </div>
                                        <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $event->location }}</small>
                                    </td>
                                    <td style="padding: 1rem 1.25rem;">
                                        <span class="badge bg-secondary">{{ $event->category }}</span>
                                    </td>
                                    <td style="padding: 1rem 1.25rem;">
                                        {{ $event->event_date->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ $event->event_time->format('H:i') }}</small>
                                    </td>
                                    <td style="padding: 1rem 1.25rem;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                            <span class="badge" style="background: #e8f5e9; color: #2e7d32; font-size: 0.78rem;">
                                                {{ $approvedCount }} approved
                                            </span>
                                            @if($pendingCount > 0)
                                                <span class="badge" style="background: #fff3e0; color: #e65100; font-size: 0.78rem; animation: pulse-border 1.5s infinite;">
                                                    {{ $pendingCount }} pending
                                                </span>
                                            @endif
                                            <span class="text-muted" style="font-size: 0.8rem;">/ {{ $event->quota }} quota</span>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem 1.25rem;">
                                        <span class="badge bg-success">+{{ $event->points }} pts</span>
                                    </td>
                                    <td style="padding: 1rem 1.25rem;">
                                        @if($event->status === 'Open')
                                            <span class="badge bg-success">Open</span>
                                        @elseif($event->status === 'Closed')
                                            <span class="badge bg-warning text-dark">Closed</span>
                                        @else
                                            <span class="badge bg-secondary">Completed</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.25rem; text-align: right;">
                                        <div style="display: flex; gap: 0.4rem; justify-content: flex-end; align-items: center;">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                               class="btn btn-sm"
                                               style="background: var(--primary-color); color: white; border: none; position: relative;">
                                                <i class="bi bi-people"></i> Approvals
                                                @if($pendingCount > 0)
                                                    <span style="position: absolute; top: -6px; right: -6px; background: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: 700;">{{ $pendingCount }}</span>
                                                @endif
                                            </a>
                                            <a href="{{ route('admin.events.edit', $event) }}"
                                               class="btn btn-sm btn-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.events.destroy', $event) }}"
                                                  method="POST"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Delete this event and all its registrations?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="padding: 1rem 1.25rem;">
                    {{ $events->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5 my-3">
                    <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                    <h5 class="fw-bold mt-3">No Events Yet</h5>
                    <p class="text-muted mb-3">Get started by creating your first wellness or sports event.</p>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Create First Event
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes pulse-border {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
    </style>
@endsection
