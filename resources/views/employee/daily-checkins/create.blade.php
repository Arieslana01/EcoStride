@extends('employee.layout')

@section('title', 'Submit Daily Check-In')

@section('content')
    <div class="mb-4">
        <h2>✅ Submit Your Daily Sustainability Check-In</h2>
        <p class="text-muted">Select the sustainability activities you completed today to earn points!</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('checkins.store') }}">
                        @csrf

                        <div class="checkbox-group">
                            <!-- Tumbler -->
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" name="tumbler" value="1">
                                    <span>
                                        🥤 Bring Tumbler
                                        <span class="points-badge">+5 pts</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Public Transport or Bicycle -->
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" name="public_transport_bicycle" value="1">
                                    <span>
                                        🚴 Use Public Transportation or Bicycle
                                        <span class="points-badge">+10 pts</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Exercise -->
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" name="exercise" value="1">
                                    <span>
                                        💪 Exercise Today
                                        <span class="points-badge">+15 pts</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Lunch Box -->
                            <div class="checkbox-item">
                                <label>
                                    <input type="checkbox" name="lunch_box" value="1">
                                    <span>
                                        🍱 Bring Lunch Box / Reusable Food Container
                                        <span class="points-badge">+5 pts</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <hr>

                        <!-- Points Summary -->
                        <div class="alert alert-info">
                            <h6 class="fw-bold">💡 Points Breakdown:</h6>
                            <ul class="mb-0">
                                <li>🥤 Tumbler: 5 points</li>
                                <li>🚴 Public Transport/Bicycle: 10 points</li>
                                <li>💪 Exercise: 15 points</li>
                                <li>🍱 Lunch Box: 5 points</li>
                                <li><strong>Maximum Daily: 35 points</strong></li>
                            </ul>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                ✓ Submit Check-In
                            </button>
                            <a href="{{ route('checkins.index') }}" class="btn btn-secondary">
                                ← Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">📌 Important Notes</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong>⏰ One Per Day</strong>
                            <p class="text-muted mb-0">You can submit only one check-in per day (UTC).</p>
                        </li>
                        <li class="mb-3">
                            <strong>🎯 Track Progress</strong>
                            <p class="text-muted mb-0">Monitor your points and climb the leaderboard!</p>
                        </li>
                        <li class="mb-3">
                            <strong>🌱 Be Sustainable</strong>
                            <p class="text-muted mb-0">Every small action contributes to a greener workplace.</p>
                        </li>
                        <li>
                            <strong>🏆 Earn Rewards</strong>
                            <p class="text-muted mb-0">Accumulate points and earn recognition!</p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">🎓 Tips for Success</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-0">
                        Start with one or two activities and gradually build sustainable habits. 
                        Remember, consistency is key to climbing the leaderboard!
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Optional: Add real-time points calculation
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
                
                // Optional: Display current points
                console.log('Current points: ' + points);
            }
        </script>
    @endpush
@endsection
