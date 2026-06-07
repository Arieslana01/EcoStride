<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EcoStride Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background: var(--primary-color);
            color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sidebar {
            background: white;
            border-right: 1px solid #e0e0e0;
            min-height: calc(100vh - 56px);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-menu a {
            display: block;
            padding: 1rem;
            color: var(--dark-gray);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover {
            background-color: var(--light-gray);
            color: var(--primary-color);
            padding-left: 1.5rem;
        }

        .sidebar-menu a.active {
            background-color: var(--secondary-color);
            color: white;
            border-left: 4px solid var(--primary-color);
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
            background: var(--primary-color);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: #4a207b;
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
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <x-application-logo style="height: 28px; width: 28px;" />
                <span>EcoStride Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="sidebar">
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="@if(request()->routeIs('admin.dashboard')) active @endif">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.employees.index') }}" 
                           class="@if(request()->routeIs('admin.employees.*')) active @endif">
                            Employees
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events.index') }}" 
                           class="@if(request()->routeIs('admin.events.*')) active @endif">
                            Events
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; width: 100%; text-align: left; padding: 1rem; color: #dc3545; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                <i class="bi bi-box-arrow-right" style="margin-right: 0.5rem;"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
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
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
