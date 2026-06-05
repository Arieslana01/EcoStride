@extends('employee.layout')

@section('title', 'Submit Daily Check-In')

@section('content')
    <style>
        .checkin-hero {
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.08) 0%, rgba(40, 199, 217, 0.08) 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .checkin-hero h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .checkin-hero p {
            color: #666;
            margin: 0;
            font-size: 1.05rem;
        }

        .activities-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .activity-selector {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-height: 80px;
        }

        .activity-selector:hover {
            border-color: var(--primary-color);
            box-shadow: 0 8px 24px rgba(90, 45, 145, 0.1);
            transform: translateY(-2px);
        }

        .activity-selector input[type="checkbox"]:checked + .activity-content {
            color: var(--primary-color);
        }

        .activity-selector input[type="checkbox"]:checked {
            border-color: var(--primary-color);
        }

        .activity-icon {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: var(--light-gray);
            border-radius: 12px;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .activity-selector input[type="checkbox"]:checked ~ .activity-icon {
            background: var(--primary-color);
            color: white;
        }

        .activity-content {
            flex: 1;
        }

        .activity-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin: 0;
        }

        .activity-desc {
            font-size: 0.85rem;
            color: #999;
            margin: 0.25rem 0 0 0;
        }

        .points-label {
            background: linear-gradient(135deg, var(--secondary-color), #18a5b1);
            color: white;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            white-space: nowrap;
            margin-left: auto;
        }

        .summary-card {
            background: linear-gradient(135deg, rgba(90, 45, 145, 0.05), rgba(40, 199, 217, 0.05));
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card h3 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-gray);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .summary-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: white;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .summary-item strong {
            color: var(--dark-gray);
        }

        .summary-item .points {
            background: var(--secondary-color);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .max-points {
            grid-column: 1 / -1;
            background: var(--primary-color);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-buttons .btn {
            flex: 1;
            padding: 1rem;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .checkin-hero {
                padding: 1.5rem;
            }

            .checkin-hero h1 {
                font-size: 1.5rem;
            }

            .summary-list {
                grid-template-columns: 1fr;
            }

            .activity-selector {
                flex-direction: column;
                text-align: center;
                min-height: auto;
            }

            .activity-selector {
                gap: 0.75rem;
            }

            .points-label {
                margin-left: 0;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="checkin-hero">
        <h1>Today's Check-In</h1>
        <p>Select activities you completed to earn sustainability points!</p>
    </div>

    <!-- Main Form -->
    <form method="POST" action="{{ route('checkins.store') }}" style="max-width: 700px; margin: 0 auto;">
        @csrf

        <!-- Activities Selection -->
        <div class="activities-container">
            <!-- Tumbler -->
            <label class="activity-selector">
                <input type="checkbox" name="tumbler" value="1" style="width: 20px; height: 20px;">
                <div class="activity-icon"><i class="bi bi-cup-straw"></i></div>
                <div class="activity-content">
                    <div class="activity-name">Bring Tumbler</div>
                    <div class="activity-desc">Use a reusable water bottle</div>
                </div>
                <div class="points-label">+5 pts</div>
            </label>

            <!-- Public Transport / Bicycle -->
            <label class="activity-selector">
                <input type="checkbox" name="public_transport_bicycle" value="1" style="width: 20px; height: 20px;">
                <div class="activity-icon"><i class="bi bi-bicycle"></i></div>
                <div class="activity-content">
                    <div class="activity-name">Eco-Friendly Commute</div>
                    <div class="activity-desc">Public transport or bicycle</div>
                </div>
                <div class="points-label">+10 pts</div>
            </label>

            <!-- Exercise -->
            <label class="activity-selector">
                <input type="checkbox" name="exercise" value="1" style="width: 20px; height: 20px;">
                <div class="activity-icon"><i class="bi bi-heart-pulse"></i></div>
                <div class="activity-content">
                    <div class="activity-name">Exercise Today</div>
                    <div class="activity-desc">Stay active and healthy</div>
                </div>
                <div class="points-label">+15 pts</div>
            </label>

            <!-- Lunch Box -->
            <label class="activity-selector">
                <input type="checkbox" name="lunch_box" value="1" style="width: 20px; height: 20px;">
                <div class="activity-icon"><i class="bi bi-box-seam"></i></div>
                <div class="activity-content">
                    <div class="activity-name">Bring Lunch Box</div>
                    <div class="activity-desc">Reusable food container</div>
                </div>
                <div class="points-label">+5 pts</div>
            </label>
        </div>

        <!-- Points Summary -->
        <div class="summary-card">
            <h3>Points Breakdown</h3>
            <div class="summary-list">
                <div class="summary-item">
                    <span>Tumbler</span>
                    <span class="points">+5 pts</span>
                </div>
                <div class="summary-item">
                    <span>Eco Commute</span>
                    <span class="points">+10 pts</span>
                </div>
                <div class="summary-item">
                    <span>Exercise</span>
                    <span class="points">+15 pts</span>
                </div>
                <div class="summary-item">
                    <span>Lunch Box</span>
                    <span class="points">+5 pts</span>
                </div>
                <div class="max-points">
                    <i class="bi bi-lightning-charge"></i> Maximum Daily: 35 Points
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('checkins.index') }}" class="btn btn-outline">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                Submit Check-In
            </button>
        </div>
    </form>

    <!-- Info Card -->
    <div class="card" style="max-width: 700px; margin: 2rem auto 0;">
        <div class="card-header">
            <h6 class="mb-0">Important Information</h6>
        </div>
        <div class="card-body">
            <ul class="list-unstyled" style="margin: 0;">
                <li class="mb-3">
                    <strong>One Per Day</strong>
                    <p class="text-muted mb-0">You can submit only one check-in per day (UTC).</p>
                </li>
                <li class="mb-3">
                    <strong>Track Progress</strong>
                    <p class="text-muted mb-0">Monitor your points and climb the leaderboard!</p>
                </li>
                <li class="mb-3">
                    <strong>Be Sustainable</strong>
                    <p class="text-muted mb-0">Every small action contributes to a greener workplace.</p>
                </li>
                <li>
                    <strong>Earn Rewards</strong>
                    <p class="text-muted mb-0">Accumulate points and earn recognition!</p>
                </li>
            </ul>
        </div>
    </div>

    @push('scripts')
        <script>
            // Real-time points calculation
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    calculatePoints();
                });
            });

            function calculatePoints() {
                let points = 0;
                if (document.querySelector('input[name="tumbler"]').checked) points += 5;
                if (document.querySelector('input[name="public_transport_bicycle"]').checked) points += 10;
                if (document.querySelector('input[name="exercise"]').checked) points += 15;
                if (document.querySelector('input[name="lunch_box"]').checked) points += 5;
                console.log('Current points: ' + points);
            }
        </script>
    @endpush
@endsection
