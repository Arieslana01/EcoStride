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
            --white: #FFFFFF;
            --ios-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            --ios-shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.16);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: var(--light-gray);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: var(--dark-gray);
        }

        /* iPhone-style Header */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--ios-shadow);
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--dark-gray);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .nav-links a.active {
            color: var(--primary-color);
        }
        
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 1.5px;
        }
        
        .nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .nav-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }


        .main-content {
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* iOS-style Card */
        .card {
            background: var(--white);
            border: none;
            border-radius: 16px;
            box-shadow: var(--ios-shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--ios-shadow-lg);
        }

        .card-header {
            background: var(--light-gray);
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* iOS-style Buttons */
        .btn {
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(90, 45, 145, 0.3);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #1ea8b7;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 199, 217, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* iOS-style Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            border-left: 4px solid;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left-color: #ffc107;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }

        /* iOS-style Badge */
        .badge {
            border-radius: 12px;
            padding: 0.4rem 0.75rem;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .bg-success { background-color: #28a745 !important; }
        .bg-danger { background-color: #dc3545 !important; }
        .bg-warning { background-color: #ffc107 !important; color: var(--dark-gray) !important; }
        .bg-primary { background: linear-gradient(135deg, var(--primary-color), var(--accent-color)) !important; }

        /* iOS-style Table */
        .table {
            margin-bottom: 0;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--light-gray);
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        /* iOS-style Form */
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .checkbox-item {
            background: var(--white);
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .checkbox-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(90, 45, 145, 0.1);
        }

        .checkbox-item input[type="checkbox"] {
            accent-color: var(--primary-color);
            cursor: pointer;
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
            width: 100%;
        }

        .points-badge {
            background: linear-gradient(135deg, var(--secondary-color), #18a5b1);
            color: white;
            padding: 0.35rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: auto;
            flex-shrink: 0;
        }

        /* iOS-style Stat Card */
        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--ios-shadow);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--ios-shadow-lg);
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0.5rem 0;
        }

        .stat-card .stat-label {
            color: #999;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .nav-links {
                gap: 1rem;
                font-size: 0.85rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- iPhone-style Header -->
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="{{ url('/') }}">
                🌍 EcoStride
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" 
                   class="@if(request()->routeIs('dashboard')) active @endif">
                    📊 Dashboard
                </a>
                <a href="{{ route('checkins.index') }}" 
                   class="@if(request()->routeIs('checkins.*')) active @endif">
                    ✅ Check-In
                </a>
                <a href="{{ route('leaderboards.individual') }}" 
                   class="@if(request()->routeIs('leaderboards.*')) active @endif">
                    🏆 Leaderboard
                </a>
                <div class="nav-user">
                    <div class="nav-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" style="color: var(--dark-gray); text-decoration: none;" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">👤 Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="cursor: pointer;">
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
