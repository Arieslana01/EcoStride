@extends('employee.layout')

@section('title', 'Dashboard')

@section('content')

    <style>
        :root {
            --primary-color: #5A2D91;
            --secondary-color: #28C7D9;
            --accent-color: #E91E8F;
            --dark-gray: #333333;
            --light-gray: #F5F6F8;
            --border-color: #e5e7eb;
            --text-muted: #666666;
        }

        * {
            --bs-font-sans-serif: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background: #ffffff;
        }

        .dashboard-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
        }

        /* ===== HERO SECTION ===== */
        .hero-section {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 5rem;
            padding: 0;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-content h1 {
            font-size: 2.75rem;
            font-weight: 800;
            color: var(--dark-gray);
            margin-bottom: 1rem;
            line-height: 1.2;
            letter-spacing: -0.75px;
        }

        .hero-content p {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .btn-checkin {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(90, 45, 145, 0.2);
            width: fit-content;
        }

        .btn-checkin:hover {
            background: #4a2173;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(90, 45, 145, 0.3);
            color: white;
        }

        .hero-image {
            position: relative;
            height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--light-gray) 0%, #f0f0f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 1rem;
        }

        /* ===== SCORE CARDS SECTION ===== */
        .score-section {
            margin-bottom: 5rem;
        }

        .score-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .score-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .score-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-color);
        }

        .score-card:nth-child(2)::before {
            background: var(--secondary-color);
        }

        .score-card:nth-child(3)::before {
            background: var(--accent-color);
        }

        .score-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .score-card-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
            display: block;
        }

        .score-card-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: block;
            line-height: 1;
        }

        .score-card:nth-child(2) .score-card-value {
            color: var(--secondary-color);
        }

        .score-card:nth-child(3) .score-card-value {
            color: var(--accent-color);
        }

        .score-card-sublabel {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary-color);
            font-size: 1.75rem;
        }

        /* ===== ACTIONS SECTION ===== */
        .actions-section {
            margin-bottom: 5rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .action-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: row;
            align-items: stretch;
            height: 100%;
        }

        .action-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 24px rgba(90, 45, 145, 0.15);
            transform: translateY(-4px);
        }

        .action-image {
            width: 220px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--light-gray) 0%, #f0f0f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: #999;
            overflow: hidden;
            position: relative;
        }

        .action-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .action-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .action-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .action-description {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .action-points {
            align-self: flex-start;
            background: var(--secondary-color);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        /* ===== EVENTS SECTION ===== */
        .events-section {
            margin-bottom: 5rem;
        }

        .events-carousel {
            display: flex;
            gap: 2rem;
            overflow-x: auto;
            padding: 1rem 0;
            scroll-behavior: smooth;
        }

        .events-carousel::-webkit-scrollbar {
            height: 6px;
        }

        .events-carousel::-webkit-scrollbar-track {
            background: var(--light-gray);
            border-radius: 10px;
        }

        .events-carousel::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        .event-card {
            flex: 0 0 320px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            box-shadow: 0 12px 36px rgba(0, 0, 0, 0.12);
            transform: translateY(-4px);
            border-color: var(--primary-color);
        }

        .event-image {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--light-gray) 0%, #f0f0f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: #999;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-content {
            padding: 1.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .event-badge {
            display: inline-block;
            background: var(--light-gray);
            color: var(--primary-color);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 0.75rem;
            width: fit-content;
        }

        .event-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .event-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex: 1;
        }

        .event-detail-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .event-detail-icon {
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .event-footer {
            margin-top: auto;
        }

        .btn-join {
            width: 100%;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.875rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-join:hover {
            background: #4a2173;
            transform: scale(1.02);
        }

        /* ===== LEADERBOARD SECTION ===== */
        .leaderboard-section {
            margin-bottom: 3rem;
        }

        .leaderboard-container {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .leaderboard-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to right, #fafbfc, #ffffff);
        }

        .leaderboard-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark-gray);
        }

        .view-all-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .view-all-link:hover {
            color: var(--accent-color);
        }

        .leaderboard-body {
            padding: 0;
        }

        .leaderboard-item {
            display: grid;
            grid-template-columns: 60px 1fr 1fr 120px;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.2s ease;
        }

        .leaderboard-item:last-child {
            border-bottom: none;
        }

        .leaderboard-item:hover {
            background: var(--light-gray);
        }

        .leaderboard-item.current-user {
            background: rgba(90, 45, 145, 0.05);
        }

        .rank-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--dark-gray);
            height: 48px;
            width: 48px;
            background: var(--light-gray);
            border-radius: 50%;
        }

        .rank-badge.rank-1 {
            background: linear-gradient(135deg, #ffc107 0%, #ffb700 100%);
            color: #fff;
            font-size: 1.3rem;
        }

        .rank-badge.rank-2 {
            background: linear-gradient(135deg, #c0c0c0 0%, #b0b0b0 100%);
            color: #fff;
            font-size: 1.3rem;
        }

        .rank-badge.rank-3 {
            background: linear-gradient(135deg, #cd7f32 0%, #b86e1f 100%);
            color: #fff;
            font-size: 1.3rem;
        }

        .employee-info h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin: 0 0 0.25rem 0;
        }

        .employee-dept {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .points-display {
            text-align: right;
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--primary-color);
        }

        .empty-state {
            padding: 2rem;
            text-align: center;
            color: var(--text-muted);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .hero-section {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .hero-image {
                height: 350px;
            }

            .leaderboard-item {
                grid-template-columns: 50px 1fr 100px;
                gap: 1rem;
                padding: 1.25rem 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1.5rem 1rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-image {
                height: 280px;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .action-card {
                flex-direction: column;
            }

            .action-image {
                width: 100%;
                height: 180px;
            }

            .events-carousel {
                margin-left: -1rem;
                margin-right: -1rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .event-card {
                flex: 0 0 280px;
            }

            .leaderboard-item {
                grid-template-columns: 40px 1fr 80px;
                gap: 0.75rem;
                padding: 1rem 1.25rem;
            }

            .rank-badge {
                height: 40px;
                width: 40px;
                font-size: 0.9rem;
            }

            .rank-badge.rank-1,
            .rank-badge.rank-2,
            .rank-badge.rank-3 {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 1.25rem;
            }
        }

        /* ===== HERO STATIC WIDGET ===== */
        .sustainability-simple-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .simple-vector-svg {
            width: 85%;
            height: 85%;
            max-width: 360px;
            filter: drop-shadow(0 15px 35px rgba(90, 45, 145, 0.08));
        }
    </style>

    <div class="dashboard-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1>Building a Sustainable Workplace Together</h1>
                <p>Track your sustainable actions, participate in wellness activities, and contribute to a greener workplace culture.</p>
                <a href="{{ route('checkins.create') }}" class="btn-checkin">
                    <i class="bi bi-check-circle"></i> Check In Today
                </a>
            </div>

            <div class="hero-image">
                <img src="{{ asset('images/hero.png') }}" alt="Sustainability" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
        </div>

        <!-- Score Cards Section -->
        <div class="score-section">
            <div class="score-grid">
                <div class="score-card">
                    <span class="score-card-label">Total Points</span>
                    <span class="score-card-value">{{ $totalPoints }}</span>
                    <span class="score-card-sublabel">Your sustainability score</span>
                </div>
                <div class="score-card">
                    <span class="score-card-label">Your Rank</span>
                    <span class="score-card-value">
                        @if(is_numeric($userRank))
                            #{{ $userRank }}
                        @else
                            —
                        @endif
                    </span>
                    <span class="score-card-sublabel">Among all employees</span>
                </div>
                <div class="score-card">
                    <span class="score-card-label">Department Rank</span>
                    <span class="score-card-value">
                        @if(is_numeric($deptRank))
                            #{{ $deptRank }}
                        @else
                            —
                        @endif
                    </span>
                    <span class="score-card-sublabel">{{ auth()->user()->department }}</span>
                </div>
            </div>
        </div>

        <!-- Sustainability Actions -->
        <div class="actions-section">
            <h2 class="section-title">
                <i class="bi bi-leaf"></i> Daily Sustainability Actions
            </h2>
            <div class="actions-grid">
                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <div class="action-image">
                            <img src="{{ asset('images/actions/tumbler.png') }}" alt="Bring Tumbler">
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Bring Tumbler</h3>
                            <p class="action-description">Use a reusable water bottle and reduce plastic waste</p>
                            <span class="action-points">+5 pts</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <div class="action-image">
                            <img src="{{ asset('images/actions/commute.png') }}" alt="Public Transport / Bicycle">
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Public Transport / Bicycle</h3>
                            <p class="action-description">Choose eco-friendly commuting options</p>
                            <span class="action-points">+10 pts</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <div class="action-image">
                            <img src="{{ asset('images/actions/exercise.png') }}" alt="Exercise Today">
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Exercise Today</h3>
                            <p class="action-description">Stay active and improve your wellness</p>
                            <span class="action-points">+15 pts</span>
                        </div>
                    </div>
                </a>

                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <div class="action-image">
                            <img src="{{ asset('images/actions/lunch.png') }}" alt="Bring Lunch Box">
                        </div>
                        <div class="action-content">
                            <h3 class="action-title">Bring Lunch Box</h3>
                            <p class="action-description">Use reusable containers to minimize waste</p>
                            <span class="action-points">+5 pts</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="events-section">
            <h2 class="section-title">
                <i class="bi bi-calendar-event"></i> Upcoming Wellness Events
            </h2>
            @if($upcomingEvents->count() > 0)
                <div class="events-carousel">
                    @foreach($upcomingEvents as $event)
                        <div class="event-card">
                            <div class="event-image">
                                @if($event->image)
                                    <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}">
                                @else
                                    <div style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                        {{ $event->category }}
                                    </div>
                                @endif
                            </div>
                            <div class="event-content">
                                <span class="event-badge">{{ $event->category }}</span>
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <div class="event-details">
                                    <div class="event-detail-item">
                                        <span class="event-detail-icon"><i class="bi bi-calendar-event"></i></span>
                                        <span>{{ $event->event_date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="event-detail-item">
                                        <span class="event-detail-icon"><i class="bi bi-clock"></i></span>
                                        <span>{{ $event->event_time->format('H:i') }}</span>
                                    </div>
                                    <div class="event-detail-item">
                                        <span class="event-detail-icon"><i class="bi bi-geo-alt"></i></span>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                    <div class="event-detail-item">
                                        <span class="event-detail-icon"><i class="bi bi-people"></i></span>
                                        <span>{{ $event->getAvailableSlots() }} / {{ $event->quota }} slots</span>
                                    </div>
                                </div>
                            </div>
                            <div class="event-footer">
                                <a href="{{ route('events.show', $event) }}" class="btn-join" style="display: block; text-align: center; text-decoration: none;">View & Join</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route('events.index') }}" class="view-all-link">
                        View all events <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="empty-state">
                    <p><i class="bi bi-info-circle" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i> No upcoming events at the moment. Check back soon!</p>
                </div>
            @endif
        </div>

        <!-- Leaderboard Preview -->
        <div class="leaderboard-section">
            <h2 class="section-title">
                <i class="bi bi-trophy"></i> Top Performers
            </h2>
            <div class="leaderboard-container">
                <div class="leaderboard-header">
                    <h3>Employee Rankings</h3>
                    <a href="{{ route('leaderboards.individual') }}" class="view-all-link">
                        View full rankings <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="leaderboard-body">
                    @if(isset($leaderboard) && $leaderboard->count() > 0)
                        @foreach($leaderboard->take(5) as $index => $employee)
                            <div class="leaderboard-item @if(auth()->user()->id === $employee->id) current-user @endif">
                                <div class="rank-badge @if($index === 0) rank-1 @elseif($index === 1) rank-2 @elseif($index === 2) rank-3 @endif">
                                    @if($index === 0)
                                        1
                                    @elseif($index === 1)
                                        2
                                    @elseif($index === 2)
                                        3
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <div class="employee-info">
                                    <h5>{{ $employee->name }}@if(auth()->user()->id === $employee->id) <span style="font-size: 0.7rem; background: var(--primary-color); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; margin-left: 0.5rem;">You</span>@endif</h5>
                                    <span class="employee-dept">{{ $employee->department }}</span>
                                </div>
                                <div></div>
                                <div class="points-display">{{ $employee->total_points }} pts</div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <p>Leaderboard data will appear once check-ins are submitted.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Smooth scroll for carousel with mouse drag
            const carousel = document.querySelector('.events-carousel');
            if (carousel) {
                let isDown = false;
                let startX;
                let scrollLeft;

                carousel.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - carousel.offsetLeft;
                    scrollLeft = carousel.scrollLeft;
                    carousel.style.cursor = 'grabbing';
                });

                carousel.addEventListener('mouseleave', () => {
                    isDown = false;
                    carousel.style.cursor = 'grab';
                });

                carousel.addEventListener('mouseup', () => {
                    isDown = false;
                    carousel.style.cursor = 'grab';
                });

                carousel.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - carousel.offsetLeft;
                    const walk = (x - startX) * 1;
                    carousel.scrollLeft = scrollLeft - walk;
                });
            }
        </script>
    @endpush
@endsection
