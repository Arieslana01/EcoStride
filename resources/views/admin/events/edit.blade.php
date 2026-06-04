@extends('admin.layout')

@section('title', 'Edit Event')

@section('content')
    <div class="mb-4">
        <h2>✏️ Edit Event: {{ $event->title }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.events.update', $event) }}">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Event Title *</label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $event->title) }}"
                           placeholder="Enter event title"
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category" class="form-label fw-bold">Category *</label>
                    <select class="form-select @error('category') is-invalid @enderror" 
                            id="category" 
                            name="category" 
                            required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @selected(old('category', $event->category) === $category)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3"
                              placeholder="Enter event description">{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <div class="row">
                    <!-- Event Date -->
                    <div class="col-md-6 mb-3">
                        <label for="event_date" class="form-label fw-bold">Event Date *</label>
                        <input type="date" 
                               class="form-control @error('event_date') is-invalid @enderror" 
                               id="event_date" 
                               name="event_date" 
                               value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}"
                               required>
                        @error('event_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Event Time -->
                    <div class="col-md-6 mb-3">
                        <label for="event_time" class="form-label fw-bold">Event Time *</label>
                        <input type="time" 
                               class="form-control @error('event_time') is-invalid @enderror" 
                               id="event_time" 
                               name="event_time" 
                               value="{{ old('event_time', $event->event_time->format('H:i')) }}"
                               required>
                        @error('event_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label for="location" class="form-label fw-bold">Location *</label>
                    <input type="text" 
                           class="form-control @error('location') is-invalid @enderror" 
                           id="location" 
                           name="location" 
                           value="{{ old('location', $event->location) }}"
                           placeholder="Enter event location"
                           required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <div class="row">
                    <!-- Quota -->
                    <div class="col-md-6 mb-3">
                        <label for="quota" class="form-label fw-bold">Participant Quota *</label>
                        <input type="number" 
                               class="form-control @error('quota') is-invalid @enderror" 
                               id="quota" 
                               name="quota" 
                               value="{{ old('quota', $event->quota) }}"
                               min="1"
                               required>
                        @error('quota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Points -->
                    <div class="col-md-6 mb-3">
                        <label for="points" class="form-label fw-bold">Points Reward *</label>
                        <input type="number" 
                               class="form-control @error('points') is-invalid @enderror" 
                               id="points" 
                               name="points" 
                               value="{{ old('points', $event->points) }}"
                               min="0"
                               required>
                        @error('points')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status" 
                            required>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $event->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        ✓ Update Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                        ← Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
