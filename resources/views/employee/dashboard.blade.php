@extends('employee.layout')

@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Hero Section */
        .hero-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            margin-bottom: 4rem;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .hero-content p {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .sustainability-score-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .sustainability-score-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .score-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .score-header h3 {
            font-size: 0.875rem;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .score-badge {
            background: linear-gradient(135deg, #5A2D91 0%, #E91E8F 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .score-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .score-item {
            text-align: center;
        }

        .score-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0.5rem 0;
            display: block;
        }

        .score-label {
            font-size: 0.75rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        /* Actions Section */
        .actions-section {
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-gray);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.75rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .action-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 24px rgba(90, 45, 145, 0.15);
            transform: translateY(-2px);
        }

        .action-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .action-card h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
        }

        .action-card p {
            font-size: 0.875rem;
            color: #999;
            margin-bottom: 1rem;
        }

        .points-badge {
            display: inline-block;
            background: var(--secondary-color);
            color: white;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Events Section */
        .events-section {
            margin-bottom: 4rem;
        }

        .events-carousel {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scroll-behavior: smooth;
        }

        .events-carousel::-webkit-scrollbar {
            height: 4px;
        }

        .events-carousel::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .events-carousel::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        .event-card {
            flex: 0 0 300px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .event-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .event-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .event-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .event-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.5rem;
        }

        .event-category {
            display: inline-block;
            background: var(--light-gray);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .event-details {
            padding: 1.5rem;
        }

        .event-detail {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }

        .event-detail:last-child {
            margin-bottom: 0;
        }

        .event-detail strong {
            color: var(--dark-gray);
            min-width: 60px;
        }

        .event-detail span {
            color: #666;
        }

        .event-footer {
            padding: 1.5rem;
            border-top: 1px solid #f0f0f0;
        }

        .btn-join {
            width: 100%;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-join:hover {
            background: var(--accent-color);
            transform: scale(1.02);
        }

        /* Leaderboard Section */
        .leaderboard-section {
            margin-bottom: 2rem;
        }

        .leaderboard-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .leaderboard-header {
            padding: 1.75rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .leaderboard-body {
            padding: 0;
        }

        .leaderboard-item {
            display: grid;
            grid-template-columns: 80px 1fr 100px;
            align-items: center;
            gap: 1.5rem;
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s ease;
        }

        .leaderboard-item:last-child {
            border-bottom: none;
        }

        .leaderboard-item:hover {
            background: var(--light-gray);
        }

        .leaderboard-item.current-user {
            background: rgba(90, 45, 145, 0.04);
            border-left: 3px solid var(--primary-color);
            padding-left: calc(1.75rem - 3px);
        }

        .rank-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            height: 50px;
            width: 50px;
        }

        .rank-badge.gold {
            color: #ffc107;
            font-size: 1.5rem;
        }

        .rank-badge.silver {
            color: #c0c0c0;
            font-size: 1.5rem;
        }

        .rank-badge.bronze {
            color: #cd7f32;
            font-size: 1.5rem;
        }

        .rank-badge.number {
            background: var(--light-gray);
            color: var(--dark-gray);
            border-radius: 50%;
        }

        .employee-info h5 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 0.25rem;
        }

        .employee-dept {
            font-size: 0.8rem;
            color: #999;
        }

        .points-display {
            text-align: right;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary-color);
        }

        .view-all-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .view-all-link:hover {
            color: var(--accent-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .actions-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
                grid-template-columns: 50px 1fr 80px;
                gap: 1rem;
                padding: 1rem 1.25rem;
            }

            .rank-badge {
                height: 40px;
                width: 40px;
                font-size: 1rem;
            }

            .rank-badge.gold,
            .rank-badge.silver,
            .rank-badge.bronze {
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="dashboard-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1>Welcome back, {{ auth()->user()->name }}</h1>
                <p>Sustainability starts with small daily actions. Track your progress and inspire your team to build a greener workplace together.</p>
                <a href="{{ route('checkins.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-check-circle"></i> Submit Today's Check-In
                </a>
            </div>

            <div class="sustainability-score-card">
                <div class="score-header">
                    <h3>Your Sustainability Score</h3>
                    <span class="score-badge">Active</span>
                </div>
                <div class="score-grid">
                    <div class="score-item">
                        <span class="score-value">{{ $totalPoints }}</span>
                        <span class="score-label">Total Points</span>
                    </div>
                    <div class="score-item">
                        <span class="score-value">
                            @if(is_numeric($userRank))
                                #{{ $userRank }}
                            @else
                                —
                            @endif
                        </span>
                        <span class="score-label">Your Rank</span>
                    </div>
                    <div class="score-item">
                        <span class="score-value">
                            @if(is_numeric($deptRank))
                                #{{ $deptRank }}
                            @else
                                —
                            @endif
                        </span>
                        <span class="score-label">Dept Rank</span>
                    </div>
                    <div class="score-item">
                        <span class="score-value" style="font-size: 1.2rem; line-height: 2rem;">{{ substr(auth()->user()->department, 0, 12) }}</span>
                        <span class="score-label">Department</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sustainability Actions -->
        <div class="actions-section">
            <h2 class="section-title">
                <i class="bi bi-tree"></i> Sustainability Actions
            </h2>
            <div class="actions-grid">
                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <span class="action-icon">🥤</span>
                        <h4>Bring Tumbler</h4>
                        <p>Use a reusable water bottle</p>
                        <span class="points-badge">+5 pts</span>
                    </div>
                </a>

                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <span class="action-icon">🚴</span>
                        <h4>Public Transport / Bicycle</h4>
                        <p>Eco-friendly commute</p>
                        <span class="points-badge">+10 pts</span>
                    </div>
                </a>

                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <span class="action-icon">💪</span>
                        <h4>Exercise Today</h4>
                        <p>Stay active and healthy</p>
                        <span class="points-badge">+15 pts</span>
                    </div>
                </a>

                <a href="{{ route('checkins.create') }}" style="text-decoration: none; color: inherit;">
                    <div class="action-card">
                        <span class="action-icon">🍱</span>
                        <h4>Bring Lunch Box</h4>
                        <p>Reusable food container</p>
                        <span class="points-badge">+5 pts</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="events-section">
            <h2 class="section-title">
                <i class="bi bi-calendar-event"></i> Upcoming Events
            </h2>
            @if($upcomingEvents->count() > 0)
                <div class="events-carousel">
                    @foreach($upcomingEvents as $event)
                        <div class="event-card">
                            <div class="event-header">
                                <div class="event-icon">
                                    @if(strpos($event->category, 'Tennis') !== false)
                                        🎾
                                    @elseif(strpos($event->category, 'Padel') !== false)
                                        🎾
                                    @elseif(strpos($event->category, 'Soccer') !== false)
                                        ⚽
                                    @elseif(strpos($event->category, 'Yoga') !== false)
                                        🧘
                                    @elseif(strpos($event->category, 'Pilates') !== false)
                                        🤸
                                    @else
                                        🎉
                                    @endif
                                </div>
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <span class="event-category">{{ $event->category }}</span>
                            </div>
                            <div class="event-details">
                                <div class="event-detail">
                                    <strong>📅</strong>
                                    <span>{{ $event->event_date->format('M d, Y') }}</span>
                                </div>
                                <div class="event-detail">
                                    <strong>🕐</strong>
                                    <span>{{ $event->event_time->format('H:i') }}</span>
                                </div>
                                <div class="event-detail">
                                    <strong>📍</strong>
                                    <span>{{ $event->location }}</span>
                                </div>
                            </div>
                            <div class="event-footer">
                                <button class="btn-join">Join Event</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <a href="#" class="view-all-link">
                        View all events <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @else
                <div style="background: var(--light-gray); border-radius: 12px; padding: 2rem; text-align: center; color: #999;">
                    <p>No upcoming events at the moment. Check back soon!</p>
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
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 600; color: var(--dark-gray);">Employee Rankings</h3>
                    <a href="{{ route('leaderboards.individual') }}" class="view-all-link">
                        View full rankings <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="leaderboard-body">
                    @if(isset($leaderboard) && $leaderboard->count() > 0)
                        @foreach($leaderboard->take(5) as $index => $employee)
                            <div class="leaderboard-item @if(auth()->user()->id === $employee->id) current-user @endif">
                                <div class="rank-badge @if($index === 0) gold @elseif($index === 1) silver @elseif($index === 2) bronze @else number @endif">
                                    @if($index === 0)
                                        🥇
                                    @elseif($index === 1)
                                        🥈
                                    @elseif($index === 2)
                                        🥉
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <div>
                                    <h5>{{ $employee->name }}@if(auth()->user()->id === $employee->id) <span class="badge bg-primary" style="font-size: 0.7rem;">You</span>@endif</h5>
                                    <span class="employee-dept">{{ $employee->department }}</span>
                                </div>
                                <div class="points-display">{{ $employee->total_points }} pts</div>
                            </div>
                        @endforeach
                    @else
                        <div style="padding: 2rem; text-align: center; color: #999;">
                            <p>Leaderboard data will appear once check-ins are submitted.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Smooth scroll for carousel
            const carousel = document.querySelector('.events-carousel');
            if (carousel) {
                let isDown = false;
                let startX;
                let scrollLeft;

                carousel.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - carousel.offsetLeft;
                    scrollLeft = carousel.scrollLeft;
                });

                carousel.addEventListener('mouseleave', () => {
                    isDown = false;
                });

                carousel.addEventListener('mouseup', () => {
                    isDown = false;
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
