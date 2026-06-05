@extends('admin.layout')

@section('title', 'Create Event')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Create New Event</h2>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">Fill in the event details below. Fields marked with * are required.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
    </div>

    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- Left Column: Core Info -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
                        <h6 class="mb-0 fw-bold" style="color: var(--primary-color); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-info-circle"></i> Event Information
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Event Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="e.g. EcoStride Tennis Tournament 2025"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror"
                                    id="category"
                                    name="category"
                                    required>
                                <option value="">-- Select a Sport / Activity --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" @selected(old('category') === $category)>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-0">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Describe the event, rules, what to bring, etc.">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
                        <h6 class="mb-0 fw-bold" style="color: var(--primary-color); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-calendar-event"></i> Schedule & Location
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="row g-3 mb-4">
                            <!-- Event Date -->
                            <div class="col-md-6">
                                <label for="event_date" class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('event_date') is-invalid @enderror"
                                       id="event_date"
                                       name="event_date"
                                       value="{{ old('event_date') }}"
                                       required>
                                @error('event_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Event Time -->
                            <div class="col-md-6">
                                <label for="event_time" class="form-label fw-semibold">Event Time <span class="text-danger">*</span></label>
                                <input type="time"
                                       class="form-control @error('event_time') is-invalid @enderror"
                                       id="event_time"
                                       name="event_time"
                                       value="{{ old('event_time') }}"
                                       required>
                                @error('event_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="mb-0">
                            <label for="location" class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('location') is-invalid @enderror"
                                   id="location"
                                   name="location"
                                   value="{{ old('location') }}"
                                   placeholder="e.g. Court A, Green Sports Complex"
                                   required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Image -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
                        <h6 class="mb-0 fw-bold" style="color: var(--primary-color); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-sliders"></i> Settings
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <!-- Quota -->
                        <div class="mb-4">
                            <label for="quota" class="form-label fw-semibold">Participant Quota <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('quota') is-invalid @enderror"
                                   id="quota"
                                   name="quota"
                                   value="{{ old('quota', 20) }}"
                                   min="1"
                                   required>
                            @error('quota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Points -->
                        <div class="mb-4">
                            <label for="points" class="form-label fw-semibold">Points Reward <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">+</span>
                                <input type="number"
                                       class="form-control @error('points') is-invalid @enderror"
                                       id="points"
                                       name="points"
                                       value="{{ old('points', 50) }}"
                                       min="0"
                                       required>
                                <span class="input-group-text">pts</span>
                            </div>
                            @error('points')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-0">
                            <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status') === $value || $value === 'Open')>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Banner Image -->
                <div class="card mb-4">
                    <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
                        <h6 class="mb-0 fw-bold" style="color: var(--primary-color); display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-image"></i> Event Banner
                        </h6>
                    </div>
                    <div class="card-body" style="padding: 1.5rem;">
                        <div class="mb-0">
                            <label for="image" class="form-label fw-semibold">Upload Image</label>
                            <input type="file"
                                   class="form-control @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/*">
                            <small class="text-muted d-block mt-1">
                                <i class="bi bi-info-circle"></i> Optional. If left blank, the default <strong>{{ old('category') ?: 'category' }}</strong> sport image will be used automatically.
                            </small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection
