@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    {{-- Admin Welcome Header --}}
    <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #7c3aed 100%); border-radius: 16px; padding: 2rem; margin-bottom: 2rem; color: white; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.75; margin-bottom: 0.4rem;">
                🛡️ Admin Control Panel
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 800; margin: 0 0 0.4rem 0;">Welcome back, {{ auth()->user()->name }}</h2>
            <p style="opacity: 0.8; margin: 0; font-size: 0.95rem;">Manage events, approve registrations, and oversee employee participation.</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('admin.events.create') }}"
               style="background: white; color: var(--primary-color); padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-plus-circle-fill"></i> Create New Event
            </a>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;"><i class="bi bi-people"></i></div>
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
                    <div style="font-size: 2rem; color: var(--secondary-color); margin-bottom: 0.5rem;"><i class="bi bi-building"></i></div>
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
                    <div style="font-size: 2rem; color: var(--accent-color); margin-bottom: 0.5rem;"><i class="bi bi-calendar-event"></i></div>
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
                    <div style="font-size: 2rem; color: #28a745; margin-bottom: 0.5rem;"><i class="bi bi-check-circle"></i></div>
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
                    <h6 class="mb-0">Most Active Employee</h6>
                </div>
                <div class="card-body">
                    @if($mostActiveEmployee)
                        <div class="d-flex align-items-center">
                            <div style="font-size: 3rem; margin-right: 1rem; color: #ffc107;"><i class="bi bi-trophy"></i></div>
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
                    <h6 class="mb-0">Most Active Department</h6>
                </div>
                <div class="card-body">
                    @if($mostActiveDept)
                        <div class="d-flex align-items-center">
                            <div style="font-size: 3rem; margin-right: 1rem; color: var(--secondary-color);"><i class="bi bi-award"></i></div>
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

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 1.5rem;">
            <h6 class="mb-0 fw-bold" style="color: var(--primary-color);">⚡ Quick Actions</h6>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                <a href="{{ route('admin.events.create') }}"
                   style="display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem 1rem; background: linear-gradient(135deg, var(--primary-color), #7c3aed); border-radius: 12px; text-decoration: none; color: white; transition: all 0.2s; text-align: center;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(90,45,145,0.35)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <i class="bi bi-calendar-plus" style="font-size: 1.75rem;"></i>
                    <span style="font-weight: 700; font-size: 0.9rem;">Create New Event</span>
                </a>
                <a href="{{ route('admin.events.index') }}"
                   style="display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem 1rem; background: white; border: 2px solid var(--primary-color); border-radius: 12px; text-decoration: none; color: var(--primary-color); transition: all 0.2s; text-align: center;"
                   onmouseover="this.style.background='rgba(90,45,145,0.06)'"
                   onmouseout="this.style.background='white'">
                    <i class="bi bi-calendar-check" style="font-size: 1.75rem;"></i>
                    <span style="font-weight: 700; font-size: 0.9rem;">Manage Events</span>
                </a>
                <a href="{{ route('admin.employees.index') }}"
                   style="display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem 1rem; background: white; border: 2px solid var(--secondary-color); border-radius: 12px; text-decoration: none; color: var(--secondary-color); transition: all 0.2s; text-align: center;"
                   onmouseover="this.style.background='rgba(40,199,217,0.06)'"
                   onmouseout="this.style.background='white'">
                    <i class="bi bi-people" style="font-size: 1.75rem;"></i>
                    <span style="font-weight: 700; font-size: 0.9rem;">Manage Employees</span>
                </a>
                <a href="{{ route('admin.employees.create') }}"
                   style="display: flex; flex-direction: column; align-items: center; gap: 0.75rem; padding: 1.5rem 1rem; background: white; border: 2px solid var(--accent-color); border-radius: 12px; text-decoration: none; color: var(--accent-color); transition: all 0.2s; text-align: center;"
                   onmouseover="this.style.background='rgba(233,30,143,0.06)'"
                   onmouseout="this.style.background='white'">
                    <i class="bi bi-person-plus" style="font-size: 1.75rem;"></i>
                    <span style="font-weight: 700; font-size: 0.9rem;">Add Employee</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Monthly Participation Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: var(--light-gray);">
                    <h6 class="mb-0">Monthly Participation & Points</h6>
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
