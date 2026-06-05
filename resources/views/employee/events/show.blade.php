@extends('employee.layout')

@section('title', $event->title)

@section('content')
    <div class="mb-4">
        <a href="{{ route('events.index') }}" class="text-decoration-none" style="color: var(--primary-color); font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
            <i class="bi bi-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="card overflow-hidden">
        <!-- Event Banner Image -->
        @if($event->image)
            <div style="height: 320px; overflow: hidden; position: relative;">
                <img src="{{ asset('images/events/' . $event->image) }}" class="w-100 h-100" alt="{{ $event->title }}" style="object-fit: cover; width: 100%; height: 100%;">
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); padding: 2rem 1.5rem; color: white;">
                    <span class="badge bg-secondary mb-2" style="background-color: var(--secondary-color) !important; color: white;">{{ $event->category }}</span>
                    <h2 class="fw-bold mb-0" style="color: white; text-shadow: 0 1px 3px rgba(0,0,0,0.5);">{{ $event->title }}</h2>
                </div>
            </div>
        @else
            <div class="p-5 text-white" style="background: var(--primary-color);">
                <span class="badge bg-secondary mb-2" style="background-color: var(--secondary-color) !important; color: white;">{{ $event->category }}</span>
                <h2 class="fw-bold mb-0" style="color: white;">{{ $event->title }}</h2>
            </div>
        @endif

        <div class="card-body" style="padding: 2.5rem 2rem;">
            <div class="row" style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem;">
                
                <!-- Left Column: Description & Info -->
                <div>
                    <h5 class="fw-bold mb-3" style="color: var(--primary-color);">Event Description</h5>
                    <p class="text-muted" style="white-space: pre-line; line-height: 1.7; font-size: 1rem;">
                        {{ $event->description ?: 'No description provided for this event. Join us for a great session of wellness and sports!' }}
                    </p>
                </div>

                <!-- Right Column: Event Info Cards -->
                <div>
                    <div style="background: var(--light-gray); border-radius: 16px; padding: 2rem; border: 1px solid #e5e7eb;">
                        <h5 class="fw-bold mb-4" style="color: var(--dark-gray); font-size: 1.1rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 0.5rem;">Event Info</h5>
                        
                        <!-- Points Badge -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.9rem;">Reward Points</span>
                            <span class="badge bg-success" style="font-size: 0.95rem; padding: 0.5rem 1rem;">+{{ $event->points }} points</span>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <small class="text-muted d-block" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Date</small>
                            <span class="fw-bold" style="font-size: 1rem;">{{ $event->event_date->format('l, M d, Y') }}</span>
                        </div>

                        <!-- Time -->
                        <div class="mb-3">
                            <small class="text-muted d-block" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Time</small>
                            <span class="fw-bold" style="font-size: 1rem;">{{ $event->event_time->format('H:i') }}</span>
                        </div>

                        <!-- Location -->
                        <div class="mb-3">
                            <small class="text-muted d-block" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Location</small>
                            <span class="fw-bold" style="font-size: 1rem;">{{ $event->location }}</span>
                        </div>

                        <!-- Quota & Registered -->
                        <div class="mb-4">
                            <small class="text-muted d-block" style="font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">Quota Filled</small>
                            <span class="fw-bold" style="font-size: 1rem;">{{ $registeredCount }} / {{ $event->quota }} registered</span>
                        </div>

                        <hr class="mb-4">

                        {{-- Registration Button / Status --}}
                        @if($isRegistered)
                            @php
                                $myReg = App\Models\EventRegistration::where('user_id', auth()->id())->where('event_id', $event->id)->first();
                            @endphp
                            @if($myReg && $myReg->attendance === 'Present')
                                <div style="background: #dcfce7; border: 1.5px solid #86efac; border-radius: 12px; padding: 1rem; text-align: center; margin-bottom: 0;">
                                    <div style="font-size: 1.25rem; margin-bottom: 0.25rem;">✅</div>
                                    <div style="font-weight: 700; color: #166534; font-size: 0.95rem;">Approved — You're in!</div>
                                    <div style="font-size: 0.8rem; color: #4ade80; margin-top: 0.2rem;">Admin has confirmed your spot</div>
                                </div>
                            @elseif($myReg && $myReg->attendance === 'Absent')
                                <div style="background: #fee2e2; border: 1.5px solid #fca5a5; border-radius: 12px; padding: 1rem; text-align: center; margin-bottom: 0;">
                                    <div style="font-size: 1.25rem; margin-bottom: 0.25rem;">❌</div>
                                    <div style="font-weight: 700; color: #991b1b; font-size: 0.95rem;">Registration Declined</div>
                                    <div style="font-size: 0.8rem; color: #f87171; margin-top: 0.2rem;">Your registration was not accepted</div>
                                </div>
                            @else
                                <div style="background: #fff3e0; border: 1.5px solid #fed7aa; border-radius: 12px; padding: 1rem; text-align: center; margin-bottom: 0;">
                                    <div style="font-size: 1.25rem; margin-bottom: 0.25rem;">⏳</div>
                                    <div style="font-weight: 700; color: #c2410c; font-size: 0.95rem;">Registration Pending</div>
                                    <div style="font-size: 0.8rem; color: #fb923c; margin-top: 0.2rem;">Waiting for admin approval</div>
                                    <a href="{{ route('events.my-events') }}" style="display: block; margin-top: 0.75rem; font-size: 0.8rem; color: var(--primary-color); font-weight: 600; text-decoration: none;">View in My Events →</a>
                                </div>
                            @endif
                        @elseif($event->isFull())
                            <button class="btn btn-secondary w-100" style="cursor: not-allowed; background-color: #6c757d;" disabled>
                                Event Full
                            </button>
                        @elseif($event->status !== 'Open')
                            <button class="btn btn-secondary w-100" style="cursor: not-allowed; background-color: #6c757d;" disabled>
                                Registration Closed
                            </button>
                        @else
                            <form method="POST" action="{{ route('events.join', $event) }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100" style="width: 100%;">
                                    Join Event
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
