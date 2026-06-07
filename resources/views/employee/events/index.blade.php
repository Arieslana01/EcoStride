@extends('employee.layout')

@section('title', 'Upcoming Events')

@section('content')
    <!-- Page Header -->
    <div style="margin-bottom: 2rem;">
        <h2 class="fw-bold mb-1" style="color: var(--dark-gray); font-size: 1.75rem; font-weight: 900 !important;">Wellness & Sports Activities</h2>
        <p class="text-muted mb-0">Register for upcoming activities, stay fit, and boost your leaderboard score.</p>
    </div>

    @if($events->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            @foreach($events as $event)
                @php $isJoined = $event->registrations()->where('user_id', auth()->id())->exists(); @endphp
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s ease; border: 1px solid #e5e7eb; display: flex; flex-direction: column;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.12)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">

                    <!-- Event Image -->
                    <div style="height: 190px; overflow: hidden; position: relative;">
                        @if($event->image)
                            <img src="{{ asset('images/events/' . $event->image) }}"
                                 alt="{{ $event->title }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.2rem;">
                                {{ $event->category }}
                            </div>
                        @endif

                        <!-- Points Badge -->
                        <span style="position: absolute; top: 12px; right: 12px; background: var(--primary-color); color: white; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; box-shadow: 0 2px 8px rgba(90,45,145,0.4);">
                            +{{ $event->points }} pts
                        </span>

                        <!-- Status badge if not Open -->
                        @if($event->status !== 'Open')
                            <span style="position: absolute; top: 12px; left: 12px; background: #6c757d; color: white; padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                {{ $event->status }}
                            </span>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div style="padding: 1.25rem 1.5rem; flex: 1; display: flex; flex-direction: column;">
                        <!-- Category chip -->
                        <span style="display: inline-block; background: rgba(90,45,145,0.08); color: var(--primary-color); padding: 0.25rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 0.6rem; width: fit-content;">
                            {{ $event->category }}
                        </span>

                        <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--dark-gray); line-height: 1.35; margin-bottom: 0.85rem;">
                            {{ $event->title }}
                        </h4>

                        <!-- Event Meta -->
                        <div style="display: flex; flex-direction: column; gap: 0.45rem; margin-bottom: 1.25rem; flex: 1;">
                            <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.875rem; color: #666;">
                                <i class="bi bi-calendar-event" style="color: var(--primary-color); width: 16px; text-align: center;"></i>
                                <span>{{ $event->event_date->format('D, M d, Y') }} &middot; {{ $event->event_time->format('H:i') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.875rem; color: #666;">
                                <i class="bi bi-geo-alt" style="color: var(--primary-color); width: 16px; text-align: center;"></i>
                                <span>{{ $event->location }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.875rem; color: #666;">
                                <i class="bi bi-people" style="color: var(--primary-color); width: 16px; text-align: center;"></i>
                                <span>
                                    @php $slots = $event->getAvailableSlots(); @endphp
                                    @if($slots > 0)
                                        {{ $slots }} of {{ $event->quota }} slots available
                                    @else
                                        <span style="color: #dc3545; font-weight: 600;">No slots available</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Slot Progress Bar -->
                        @php $filled = $event->quota - $event->getAvailableSlots(); $pct = $event->quota > 0 ? round(($filled / $event->quota) * 100) : 0; @endphp
                        <div style="margin-bottom: 1rem;">
                            <div style="background: #e5e7eb; border-radius: 10px; height: 5px; overflow: hidden;">
                                <div style="background: {{ $pct >= 90 ? '#dc3545' : ($pct >= 60 ? '#ffc107' : 'var(--primary-color)') }}; height: 100%; width: {{ $pct }}%; border-radius: 10px; transition: width 0.4s;"></div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div style="display: flex; gap: 0.6rem;">
                            <a href="{{ route('events.show', $event) }}"
                               style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 0.65rem; border-radius: 10px; border: 1.5px solid var(--primary-color); color: var(--primary-color); font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.2s;"
                               onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'"
                               onmouseout="this.style.background='transparent'; this.style.color='var(--primary-color)'">
                                Details
                            </a>

                            @if($isJoined)
                                <button disabled
                                        style="flex: 1; padding: 0.65rem; border-radius: 10px; border: none; background: #e5e7eb; color: #999; font-weight: 600; font-size: 0.875rem; cursor: not-allowed;">
                                    ✓ Joined
                                </button>
                            @elseif($event->status !== 'Open' || $event->isFull())
                                <button disabled
                                        style="flex: 1; padding: 0.65rem; border-radius: 10px; border: none; background: #f0f0f0; color: #aaa; font-weight: 600; font-size: 0.875rem; cursor: not-allowed;">
                                    {{ $event->status !== 'Open' ? 'Closed' : 'Full' }}
                                </button>
                            @else
                                <form method="POST" action="{{ route('events.join', $event) }}" style="flex: 1; margin: 0;">
                                    @csrf
                                    <button type="submit"
                                            style="width: 100%; padding: 0.65rem; border-radius: 10px; border: none; background: var(--primary-color); color: white; font-weight: 700; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.background='#4a2173'"
                                            onmouseout="this.style.background='var(--primary-color)'">
                                        Join Event
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: white; border-radius: 16px; padding: 4rem 2rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
            <i class="bi bi-calendar-x" style="font-size: 3.5rem; color: #ccc;"></i>
            <h4 class="fw-bold mt-3" style="color: var(--dark-gray);">No Upcoming Events</h4>
            <p class="text-muted mb-0">Check back soon for new company sports and wellness activities!</p>
        </div>
    @endif
@endsection
