@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-4">
        <h2>📊 Admin Dashboard</h2>
        <p class="text-muted">Overview of system performance and participation</p>
    </div>

    <!-- Key Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div style="font-size: 2rem;">👥</div>
                    <p class="text-muted small mb-2">Total Employees</p>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--primary-color);">
                        {{ $totalEmployees }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div style="font-size: 2rem;">🏢</div>
                    <p class="text-muted small mb-2">Total Departments</p>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--secondary-color);">
                        {{ $totalDepartments }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div style="font-size: 2rem;">🎉</div>
                    <p class="text-muted small mb-2">Total Events</p>
                    <div style="font-size: 2rem; font-weight: bold; color: var(--accent-color);">
                        {{ $totalEvents }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div style="font-size: 2rem;">✅</div>
                    <p class="text-muted small mb-2">Total Check-Ins</p>
                    <div style="font-size: 2rem; font-weight: bold; color: #28a745;">
                        {{ $totalCheckins }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">⭐ Most Active Employee</h6>
                </div>
                <div class="card-body">
                    @if($mostActiveEmployee)
                        <div class="d-flex align-items-center">
                            <div style="font-size: 3rem; margin-right: 1rem;">🏆</div>
                            <div>
                                <h5 class="mb-0">{{ $mostActiveEmployee->name }}</h5>
                                <p class="text-muted mb-2">{{ $mostActiveEmployee->total_points }} points</p>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">No employee data available yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">🏆 Most Active Department</h6>
                </div>
                <div class="card-body">
                    @if($mostActiveDept)
                        <div class="d-flex align-items-center">
                            <div style="font-size: 3rem; margin-right: 1rem;">🥇</div>
                            <div>
                                <h5 class="mb-0">{{ $mostActiveDept->department }}</h5>
                                <p class="text-muted mb-2">{{ $mostActiveDept->total_points }} points</p>
                                <span class="badge bg-success">Leading</span>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">No department data available yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">⚙️ Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-primary w-100">
                                👥 Manage Employees
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.employees.create') }}" class="btn btn-outline-primary w-100">
                                ➕ Add Employee
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary w-100">
                                🎉 Manage Events
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-outline-secondary w-100">
                                ➕ Create Event
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Participation Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">📈 Monthly Participation & Points</h6>
                </div>
                <div class="card-body">
                    @if($monthlyParticipation->count() > 0)
                        <canvas id="participationChart" style="max-height: 300px;"></canvas>
                    @else
                        <div class="alert alert-info mb-0">
                            No participation data available for this month yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            @if($monthlyParticipation->count() > 0)
                const ctx = document.getElementById('participationChart').getContext('2d');
                const participationData = {
                    labels: [
                        @foreach($monthlyParticipation as $data)
                            'Day {{ $data->day }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Active Participants',
                            data: [
                                @foreach($monthlyParticipation as $data)
                                    {{ $data->participants }},
                                @endforeach
                            ],
                            borderColor: '#5A2D91',
                            backgroundColor: 'rgba(90, 45, 145, 0.1)',
                            borderWidth: 2,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Total Points Earned',
                            data: [
                                @foreach($monthlyParticipation as $data)
                                    {{ $data->total_points }},
                                @endforeach
                            ],
                            borderColor: '#28C7D9',
                            backgroundColor: 'rgba(40, 199, 217, 0.1)',
                            borderWidth: 2,
                            yAxisID: 'y1'
                        }
                    ]
                };

                const participationChart = new Chart(ctx, {
                    type: 'line',
                    data: participationData,
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Participants'
                                },
                                beginAtZero: true
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Points'
                                },
                                grid: {
                                    drawOnChartArea: false,
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            @endif
        </script>
    @endpush
@endsection
