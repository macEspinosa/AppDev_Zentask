<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zentask - Professional Task Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #FAF7F2;
            color: #2C2C2C;
        }

        /* Navbar */
        .navbar {
            background: #FAF7F2;
            padding: 20px 0;
            border-bottom: 1px solid #E8E1D4;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 26px;
            font-weight: 700;
            color: #3D3D3D;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            color: #A68A64;
            margin-right: 8px;
        }

        .nav-btn {
            background: transparent;
            border: 1px solid #D4C9B8;
            padding: 8px 24px;
            border-radius: 8px;
            color: #5C4B37;
            text-decoration: none;
            margin-left: 12px;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 14px;
        }

        .nav-btn:hover {
            background: #F0EAE1;
            color: #3D3D3D;
            border-color: #B8A88C;
        }

        /* Hero Section */
        .hero {
            padding: 100px 0;
            text-align: center;
            background: linear-gradient(180deg, #FAF7F2 0%, #F5EFE8 100%);
        }

        .hero h1 {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 24px;
            color: #3D3D3D;
            letter-spacing: -1.5px;
        }

        .hero h1 span {
            color: #A68A64;
        }

        .hero p {
            font-size: 18px;
            color: #7A6B5D;
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #A68A64;
            border: none;
            padding: 14px 36px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            color: #FFFFFF;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(166,138,100,0.2);
        }

        .btn-primary:hover {
            background: #8B6F4E;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(166,138,100,0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #D4C9B8;
            padding: 14px 36px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            color: #5C4B37;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: #F0EAE1;
            border-color: #B8A88C;
            color: #3D3D3D;
            transform: translateY(-2px);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #FFFFFF;
        }

        .section-title {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #3D3D3D;
        }

        .section-subtitle {
            text-align: center;
            color: #7A6B5D;
            margin-bottom: 60px;
            font-size: 16px;
        }

        .feature-card {
            background: #FFFFFF;
            text-align: center;
            padding: 40px 30px;
            border-radius: 20px;
            transition: all 0.3s;
            border: 1px solid #E8E1D4;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: #A68A64;
            box-shadow: 0 20px 30px rgba(0,0,0,0.05);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: #F5EFE8;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            transition: all 0.3s;
        }

        .feature-card:hover .feature-icon {
            background: #E8DDD0;
        }

        .feature-icon i {
            font-size: 32px;
            color: #A68A64;
        }

        .feature-card h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #3D3D3D;
        }

        .feature-card p {
            color: #7A6B5D;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 60px 0;
            background: #F5EFE8;
            border-top: 1px solid #E8E1D4;
            border-bottom: 1px solid #E8E1D4;
        }

        .stat-box {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 42px;
            font-weight: 800;
            color: #A68A64;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 14px;
            color: #7A6B5D;
            letter-spacing: 0.5px;
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: #A68A64;
            text-align: center;
        }

        .cta-card {
            max-width: 700px;
            margin: 0 auto;
            padding: 50px;
        }

        .cta-card h3 {
            font-size: 32px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 16px;
        }

        .cta-card p {
            color: #F0EAE1;
            margin-bottom: 32px;
            font-size: 16px;
        }

        .cta-btn {
            background: #FFFFFF;
            color: #A68A64;
            border: none;
            padding: 14px 40px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Footer */
        .footer {
            background: #FAF7F2;
            padding: 40px 0;
            text-align: center;
            border-top: 1px solid #E8E1D4;
        }

        .footer p {
            color: #B8A88C;
            font-size: 13px;
        }

        .footer-links {
            margin-bottom: 20px;
        }

        .footer-links a {
            color: #7A6B5D;
            text-decoration: none;
            margin: 0 15px;
            font-size: 13px;
        }

        .footer-links a:hover {
            color: #A68A64;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 { font-size: 36px; }
            .hero p { font-size: 16px; }
            .btn-primary, .btn-outline { padding: 10px 24px; font-size: 14px; }
            .section-title { font-size: 26px; }
            .feature-card { padding: 30px 20px; }
            .cta-card h3 { font-size: 24px; }
            .cta-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-tasks"></i> Zentask
            </a>
            <div>
                <a href="{{ route('login') }}" class="nav-btn">Login</a>
                <a href="{{ route('register') }}" class="nav-btn">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Manage Tasks <span>Like a Pro</span></h1>
            <p>Zentask helps you organize, track, and complete your tasks efficiently.<br>Never miss a deadline again.</p>
            <div class="btn-group">
                <a href="{{ route('register') }}" class="btn-primary">Get Started →</a>
                <a href="{{ route('login') }}" class="btn-outline">Sign In</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Why Choose Zentask?</h2>
            <p class="section-subtitle">Everything you need to manage your tasks effectively</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4>Task Management</h4>
                        <p>Create, edit, and organize your tasks with ease. Set priorities and track progress in real-time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4>Calendar View</h4>
                        <p>Visualize your deadlines with an interactive calendar. Never miss important dates again.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Analytics Dashboard</h4>
                        <p>Track your productivity with beautiful charts and comprehensive statistics.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Tasks Completed</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Happy Users</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-card">
                <h3>Ready to Get Started?</h3>
                <p>Join thousands of users who trust Zentask for their task management.</p>
                <a href="{{ route('register') }}" class="cta-btn">Create Free Account →</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="#">About</a>
                <a href="#">Features</a>
                <a href="#">Pricing</a>
                <a href="#">Contact</a>
                <a href="#">Privacy</a>
            </div>
            <p>&copy; {{ date('Y') }} Zentask. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>