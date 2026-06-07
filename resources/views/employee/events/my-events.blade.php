@extends('employee.layout')

@section('title', 'My Events')

@section('content')
    <div style="margin-bottom: 2rem;">
        <h2 class="fw-bold mb-1" style="color: var(--dark-gray); font-size: 1.75rem; font-weight: 900 !important;">My Registered Events</h2>
        <p class="text-muted mb-0">Track your registrations, approval status, and points earned from sports activities.</p>
    </div>

    {{-- Quick Stats --}}
    @php
        $allRegs = $upcomingRegistrations->merge($completedRegistrations);
        $pendingCount  = $allRegs->where('attendance', 'Pending')->count();
        $approvedCount = $allRegs->where('attendance', 'Present')->count();
        $declinedCount = $allRegs->where('attendance', 'Absent')->count();
    @endphp
    @if($allRegs->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 42px; height: 42px; background: #fff3e0; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="bi bi-clock" style="color: #f59e0b; font-size: 1.25rem;"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #f59e0b; line-height: 1;">{{ $pendingCount }}</div>
                <div style="font-size: 0.8rem; color: #888; font-weight: 500;">Awaiting Approval</div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #22c55e; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 42px; height: 42px; background: #dcfce7; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="bi bi-check-circle" style="color: #22c55e; font-size: 1.25rem;"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #22c55e; line-height: 1;">{{ $approvedCount }}</div>
                <div style="font-size: 0.8rem; color: #888; font-weight: 500;">Approved</div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 1.25rem 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #ef4444; display: flex; align-items: center; gap: 1rem;">
            <div style="width: 42px; height: 42px; background: #fee2e2; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="bi bi-x-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
            </div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #ef4444; line-height: 1;">{{ $declinedCount }}</div>
                <div style="font-size: 0.8rem; color: #888; font-weight: 500;">Declined</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Upcoming / Active Registrations --}}
    <div class="card mb-4">
        <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0 fw-bold" style="font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-calendar-check" style="color: var(--primary-color);"></i>
                Upcoming Events
                @if($pendingCount > 0)
                    <span style="background: #fff3e0; color: #c2410c; font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 20px; font-weight: 700;">
                        {{ $pendingCount }} pending approval
                    </span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0">
            @if($upcomingRegistrations->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle" style="margin-bottom: 0;">
                        <thead class="table-light">
                            <tr>
                                <th style="padding: 0.9rem 1.5rem; width: 35%;">Event</th>
                                <th style="padding: 0.9rem 1.5rem; width: 15%;">Category</th>
                                <th style="padding: 0.9rem 1.5rem; width: 20%;">Date & Time</th>
                                <th style="padding: 0.9rem 1.5rem; width: 20%;">Approval Status</th>
                                <th style="padding: 0.9rem 1.5rem; width: 10%; text-align: right;">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingRegistrations->sortBy(function($r){ return match($r->attendance){ 'Pending'=>0,'Present'=>1,'Absent'=>2,default=>3 }; }) as $reg)
                                <tr style="{{ $reg->attendance === 'Pending' ? 'background: #fffbf0;' : '' }}">
                                    <td style="padding: 1rem 1.5rem;">
                                        <a href="{{ route('events.show', $reg->event) }}"
                                           class="fw-bold text-decoration-none"
                                           style="color: var(--primary-color);">
                                            {{ $reg->event->title }}
                                        </a><br>
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt"></i> {{ $reg->event->location }}
                                        </small>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="background: rgba(90,45,145,0.08); color: var(--primary-color); padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">
                                            {{ $reg->event->category }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; font-size: 0.875rem;">
                                        {{ $reg->event->event_date->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ $reg->event->event_time->format('H:i') }}</small>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        @if($reg->attendance === 'Present')
                                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; width: fit-content;">
                                                    <i class="bi bi-check-circle-fill"></i> Approved — You're in!
                                                </span>
                                                <small class="text-muted" style="font-size: 0.75rem;">Admin confirmed your registration</small>
                                            </div>
                                        @elseif($reg->attendance === 'Absent')
                                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; width: fit-content;">
                                                    <i class="bi bi-x-circle-fill"></i> Declined
                                                </span>
                                                <small class="text-muted" style="font-size: 0.75rem;">Your registration was not accepted</small>
                                            </div>
                                        @else
                                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fff3e0; color: #c2410c; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; width: fit-content;">
                                                    <i class="bi bi-hourglass-split"></i> Pending Approval
                                                </span>
                                                <small class="text-muted" style="font-size: 0.75rem;">Waiting for admin to review</small>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: right;">
                                        <div style="font-weight: 700; color: var(--primary-color);">+{{ $reg->event->points }} pts</div>
                                        <div style="font-size: 0.7rem; font-weight: 600; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 0.2rem;">(Potential)</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-plus" style="font-size: 2.5rem; color: #ccc;"></i>
                    <h5 class="fw-bold mt-3" style="color: #555;">No Upcoming Registrations</h5>
                    <p class="text-muted small mb-3">You haven't joined any upcoming events yet.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm">Browse Events</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Past / Completed Events --}}
    <div class="card">
        <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
            <h5 class="mb-0 fw-bold" style="font-size: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-clock-history" style="color: var(--primary-color);"></i> Past & Completed Events
            </h5>
        </div>
        <div class="card-body p-0">
            @if($completedRegistrations->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle" style="margin-bottom: 0;">
                        <thead class="table-light">
                            <tr>
                                <th style="padding: 0.9rem 1.5rem; width: 40%;">Event</th>
                                <th style="padding: 0.9rem 1.5rem; width: 15%;">Category</th>
                                <th style="padding: 0.9rem 1.5rem; width: 20%;">Date</th>
                                <th style="padding: 0.9rem 1.5rem; width: 15%;">Status</th>
                                <th style="padding: 0.9rem 1.5rem; width: 10%; text-align: right;">Points Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedRegistrations as $reg)
                                <tr>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span class="fw-bold" style="color: #555;">{{ $reg->event->title }}</span><br>
                                        <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $reg->event->location }}</small>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="background: #f3f4f6; color: #666; padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $reg->event->category }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: #666;">
                                        {{ $reg->event->event_date->format('M d, Y') }}
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        @if($reg->attendance === 'Present')
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                                <i class="bi bi-check-circle-fill"></i> Attended
                                            </span>
                                        @elseif($reg->attendance === 'Absent')
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                                <i class="bi bi-x-circle-fill"></i> Absent
                                            </span>
                                        @else
                                            <span style="background: #f3f4f6; color: #888; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                                Not Marked
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: right; font-weight: 700;">
                                        @if($reg->attendance === 'Present')
                                            <span style="color: var(--primary-color);">+{{ $reg->event->points }} pts</span>
                                        @else
                                            <span class="text-muted">— 0 pts</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <p class="mb-0">No completed events recorded yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
