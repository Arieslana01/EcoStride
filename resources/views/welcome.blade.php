<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoStride - Corporate Wellness & Sustainability</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        :root {
            --primary-color: #5A2D91;
            --secondary-color: #28C7D9;
            --dark-gray: #333333;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: var(--dark-gray);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .brand img {
            height: 40px;
            width: auto;
            border-radius: 8px;
        }

        .brand span {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .login-btn {
            color: var(--dark-gray);
        }

        .login-btn:hover {
            color: var(--primary-color);
        }

        .register-btn {
            background: var(--primary-color);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(90, 45, 145, 0.2);
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(90, 45, 145, 0.3);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 3rem;
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-content {
            flex: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark-gray);
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #666;
            margin-bottom: 2.5rem;
            max-width: 500px;
        }

        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-decoration: none;
            padding: 1rem 2.5rem;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(40, 199, 217, 0.2);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(40, 199, 217, 0.3);
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            max-height: 500px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 2rem 1.5rem;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-description {
                margin: 0 auto 2rem auto;
            }
            .navbar {
                padding: 1rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="EcoStride">
            <span>EcoStride</span>
        </a>
        
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="register-btn">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="login-btn">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="register-btn">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Step Into a <span>Healthier</span> Future.</h1>
            <p class="hero-description">
                Join the EcoStride movement! Track your daily eco-friendly habits, register for exciting corporate sports events, and climb the leaderboard.
            </p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="cta-btn">View My Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="cta-btn">Get Started Today</a>
                @endauth
            @endif
        </div>
        <div class="hero-image">
            <!-- Using the generated custom hero image -->
            <img src="{{ asset('images/hero.png') }}" alt="EcoStride Earth Mascot">
        </div>
    </main>
</body>
</html>
