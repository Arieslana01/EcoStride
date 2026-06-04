<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EcoStride</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-color: #5A2D91;
            --secondary-color: #28C7D9;
            --accent-color: #E91E8F;
            --light-gray: #F5F6F8;
            --dark-gray: #333333;
        }
        
        body {
            background-color: var(--light-gray);
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .nav-links a.active {
            border-bottom: 2px solid var(--secondary-color);
            padding-bottom: 0.5rem;
        }

        .main-content {
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border: none;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #1ea8b7;
            color: white;
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .table-hover tbody tr:hover {
            background-color: var(--light-gray);
            cursor: pointer;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: var(--dark-gray);
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 0.5rem 0;
        }

        .stat-card .stat-label {
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .checkbox-item {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .checkbox-item:hover {
            border-color: var(--primary-color);
            background-color: var(--light-gray);
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 0.5rem;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .points-badge {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-left: 0.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                🌍 EcoStride
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="nav-links ms-auto">
                    <a href="{{ route('dashboard') }}" 
                       class="@if(request()->routeIs('dashboard')) active @endif">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('checkins.index') }}" 
                       class="@if(request()->routeIs('checkins.*')) active @endif">
                        ✅ Daily Check-In
                    </a>
                    <a href="#" class="@if(request()->routeIs('events.*')) active @endif">
                        🎉 Events
                    </a>
                    <a href="{{ route('leaderboards.individual') }}" 
                       class="@if(request()->routeIs('leaderboards.*')) active @endif">
                        🏆 Leaderboard
                    </a>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">👤 Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        🚪 Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <h6 class="fw-bold mb-2">Please correct the following errors:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                ✗ {{ session('error') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                ⚠ {{ session('warning') }}
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">
                ℹ {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
