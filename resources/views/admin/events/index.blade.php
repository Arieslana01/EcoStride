@extends('admin.layout')

@section('title', 'Event Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            🎉 Event Management
        </h2>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Create New Event
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Event Name</th>
                                <th>Category</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Quota</th>
                                <th>Points</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td class="fw-bold">{{ $event->title }}</td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $event->category }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $event->event_date->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ $event->event_time->format('H:i') }}</small>
                                    </td>
                                    <td>{{ $event->location }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $event->registrations()->whereNotIn('attendance', ['Absent'])->count() }}/{{ $event->quota }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $event->points }} pts</span>
                                    </td>
                                    <td>
                                        @if($event->status === 'Open')
                                            <span class="badge bg-success">Open</span>
                                        @elseif($event->status === 'Closed')
                                            <span class="badge bg-warning">Closed</span>
                                        @else
                                            <span class="badge bg-secondary">Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.events.edit', $event) }}" 
                                           class="btn btn-sm btn-secondary me-2">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" 
                                              method="POST" 
                                              style="display:inline;"
                                              onsubmit="return confirm('Are you sure? This will also delete all registrations.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    {{ $events->links('pagination::bootstrap-5') }}
                </nav>
            @else
                <div class="alert alert-info text-center py-4">
                    <p class="mb-0">No events found. <a href="{{ route('admin.events.create') }}">Create one now</a></p>
                </div>
            @endif
        </div>
    </div>
@endsection
