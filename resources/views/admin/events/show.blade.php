@extends('admin.layout')

@section('title', 'Event Registrations & Approvals')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <nav style="font-size: 0.85rem; color: #888; margin-bottom: 0.4rem;">
                <a href="{{ route('admin.events.index') }}" style="color: var(--primary-color); text-decoration: none;">Events</a>
                <span style="margin: 0 0.4rem;">›</span>
                <span>{{ $event->title }}</span>
            </nav>
            <h2 class="mb-1">{{ $event->title }}</h2>
            <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                <span class="badge bg-secondary">{{ $event->category }}</span>
                @if($event->status === 'Open')
                    <span class="badge bg-success">Open</span>
                @elseif($event->status === 'Closed')
                    <span class="badge bg-warning text-dark">Closed</span>
                @else
                    <span class="badge bg-secondary">Completed</span>
                @endif
                <span style="font-size: 0.85rem; color: #666;">
                    <i class="bi bi-calendar-event"></i>
                    {{ $event->event_date->format('l, M d, Y') }} at {{ $event->event_time->format('H:i') }}
                </span>
                <span style="font-size: 0.85rem; color: #666;">
                    <i class="bi bi-geo-alt"></i> {{ $event->location }}
                </span>
            </div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil"></i> Edit Event
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Summary Stats --}}
    @php
        $pendingCount  = $registrations->where('attendance', 'Pending')->count();
        $approvedCount = $registrations->where('attendance', 'Present')->count();
        $declinedCount = $registrations->where('attendance', 'Absent')->count();
        $totalReg      = $registrations->count();
    @endphp
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div style="background: white; border-radius: 10px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid var(--primary-color);">
            <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Total Registered</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--primary-color);">{{ $totalReg }}</div>
            <div style="font-size: 0.8rem; color: #888;">of {{ $event->quota }} quota</div>
        </div>
        <div style="background: white; border-radius: 10px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b;">
            <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Awaiting Approval</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #f59e0b;">{{ $pendingCount }}</div>
            <div style="font-size: 0.8rem; color: #888;">need your action</div>
        </div>
        <div style="background: white; border-radius: 10px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #22c55e;">
            <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Approved</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #22c55e;">{{ $approvedCount }}</div>
            <div style="font-size: 0.8rem; color: #888;">confirmed to join</div>
        </div>
        <div style="background: white; border-radius: 10px; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-left: 4px solid #ef4444;">
            <div style="font-size: 0.75rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Declined</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #ef4444;">{{ $declinedCount }}</div>
            <div style="font-size: 0.8rem; color: #888;">not attending</div>
        </div>
    </div>

    {{-- Registrations Table --}}
    <div class="card">
        <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h5 class="mb-0 fw-bold" style="font-size: 1rem;">
                <i class="bi bi-people" style="color: var(--primary-color);"></i>
                Registrations & Approvals
                @if($pendingCount > 0)
                    <span style="background: #fff3e0; color: #e65100; font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 20px; font-weight: 700; margin-left: 0.5rem;">
                        {{ $pendingCount }} pending
                    </span>
                @endif
            </h5>
            <small class="text-muted">Pending registrations are shown first</small>
        </div>
        <div class="card-body p-0">
            @if($registrations->count() > 0)
                {{-- Sort: Pending first, then Approved, then Declined --}}
                @php
                    $sorted = $registrations->sortBy(function($r) {
                        return match($r->attendance) {
                            'Pending' => 0,
                            'Present' => 1,
                            'Absent'  => 2,
                            default   => 3,
                        };
                    });
                @endphp
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="margin-bottom: 0;">
                        <thead class="table-light">
                            <tr>
                                <th style="padding: 1rem 1.5rem;">#</th>
                                <th style="padding: 1rem 1.5rem;">Employee</th>
                                <th style="padding: 1rem 1.5rem;">Department</th>
                                <th style="padding: 1rem 1.5rem;">Registered At</th>
                                <th style="padding: 1rem 1.5rem;">Status</th>
                                <th style="padding: 1rem 1.5rem; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sorted as $i => $reg)
                                <tr style="{{ $reg->attendance === 'Pending' ? 'background: #fffbf0;' : '' }}">
                                    <td style="padding: 1rem 1.5rem; color: #999; font-size: 0.85rem;">{{ $i + 1 }}</td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-color); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                                {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold" style="font-size: 0.95rem;">{{ $reg->user->name }}</div>
                                                <small class="text-muted">{{ $reg->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="font-size: 0.875rem; color: #555;">{{ $reg->user->department }}</span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="font-size: 0.85rem; color: #888;">{{ $reg->created_at->format('M d, Y H:i') }}</span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        @if($reg->attendance === 'Present')
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #dcfce7; color: #166534; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                                <i class="bi bi-check-circle-fill"></i> Approved
                                            </span>
                                        @elseif($reg->attendance === 'Absent')
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fee2e2; color: #991b1b; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                                <i class="bi bi-x-circle-fill"></i> Declined
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 0.3rem; background: #fff3e0; color: #c2410c; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                                                <i class="bi bi-clock-fill"></i> Pending Review
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: right;">
                                        <div style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                            {{-- Approve Button --}}
                                            <form method="POST" action="{{ route('admin.events.attendance', $reg) }}" style="margin: 0;">
                                                @csrf
                                                <input type="hidden" name="attendance" value="Present">
                                                <button type="submit"
                                                        style="padding: 0.4rem 1rem; border-radius: 8px; border: none; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: all 0.2s;
                                                               {{ $reg->attendance === 'Present' ? 'background: #dcfce7; color: #166534; cursor: default; opacity: 0.7;' : 'background: #22c55e; color: white;' }}"
                                                        @if($reg->attendance === 'Present') disabled @endif
                                                        onmouseover="{{ $reg->attendance !== 'Present' ? 'this.style.background=\"#16a34a\"' : '' }}"
                                                        onmouseout="{{ $reg->attendance !== 'Present' ? 'this.style.background=\"#22c55e\"' : '' }}">
                                                    <i class="bi bi-check-lg"></i>
                                                    {{ $reg->attendance === 'Present' ? 'Approved' : 'Approve' }}
                                                </button>
                                            </form>

                                            {{-- Decline Button --}}
                                            <form method="POST" action="{{ route('admin.events.attendance', $reg) }}" style="margin: 0;">
                                                @csrf
                                                <input type="hidden" name="attendance" value="Absent">
                                                <button type="submit"
                                                        style="padding: 0.4rem 1rem; border-radius: 8px; border: 1.5px solid #e5e7eb; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
                                                               {{ $reg->attendance === 'Absent' ? 'background: #fee2e2; color: #991b1b; border-color: #fca5a5; cursor: default; opacity: 0.7;' : 'background: white; color: #888;' }}"
                                                        @if($reg->attendance === 'Absent') disabled @endif
                                                        onmouseover="{{ $reg->attendance !== 'Absent' ? 'this.style.background=\"#fee2e2\"; this.style.color=\"#991b1b\"; this.style.borderColor=\"#fca5a5\"' : '' }}"
                                                        onmouseout="{{ $reg->attendance !== 'Absent' ? 'this.style.background=\"white\"; this.style.color=\"#888\"; this.style.borderColor=\"#e5e7eb\"' : '' }}">
                                                    <i class="bi bi-x-lg"></i>
                                                    {{ $reg->attendance === 'Absent' ? 'Declined' : 'Decline' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <h5 class="fw-bold mt-3" style="color: #555;">No Registrations Yet</h5>
                    <p class="text-muted mb-0">Employees haven't registered for this event. Share it with them!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
