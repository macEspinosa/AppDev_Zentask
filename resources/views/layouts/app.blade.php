<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zentask | @yield('title', 'Dashboard')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F2F2F2;
            color: #1A1A1A;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar - BLACK */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 280px;
            background: #000000;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 30px 24px;
            border-bottom: 1px solid #333333;
        }

        .sidebar-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #FFD700;
            margin: 0;
        }

        .sidebar-header p {
            font-size: 0.75rem;
            color: #888888;
            margin: 5px 0 0;
        }

        .sidebar-menu {
            padding: 20px 0 40px;
        }

        .sidebar-menu .menu-item {
            margin: 4px 16px;
            border-radius: 10px;
        }

        .sidebar-menu .menu-item a,
        .sidebar-menu .menu-item button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #888888;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-menu .menu-item:hover a,
        .sidebar-menu .menu-item:hover button {
            background: #333333;
            color: #FFFFFF;
        }

        .sidebar-menu .menu-item.active a,
        .sidebar-menu .menu-item.active button {
            background: #FFD700;
            color: #000000;
        }

        .sidebar-menu .menu-item i {
            width: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Navbar - WHITE */
        .top-navbar {
            background: #FFFFFF;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #E0E0E0;
            position: sticky;
            top: 0;
            z-index: 999;
            flex-shrink: 0;
        }

        .page-title h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1A1A1A;
            margin: 0;
        }

        .page-title p {
            font-size: 0.75rem;
            color: #666666;
            margin: 4px 0 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #FFD700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            cursor: pointer;
            color: #000000;
        }

        /* Content Wrapper */
        .content-wrapper {
            flex: 1;
            padding: 24px 32px;
        }

        /* Footer - GRAY */
        .app-footer {
            background: #FFFFFF;
            border-top: 1px solid #E0E0E0;
            padding: 16px 32px;
            text-align: center;
            font-size: 0.75rem;
            color: #888888;
            flex-shrink: 0;
        }

        /* Cards - WHITE with better shadows */
        .stat-card {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 24px 20px;
            border: none;
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }

        .stat-card-value {
            font-size: 36px;
            font-weight: 800;
            color: #8B4513;
            margin-bottom: 8px;
        }

        .stat-card-label {
            font-size: 13px;
            color: #666666;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .data-card {
            background: #FFFFFF;
            border-radius: 20px;
            border: none;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .data-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #F0F0F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .data-card-header h5 {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: #1A1A1A;
        }

        /* Buttons */
        .btn-primary-custom {
            background: #8B4513;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #FFFFFF;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: #6B3410;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139,69,19,0.3);
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid #CCCCCC;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #666666;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            background: #F5F5F5;
            border-color: #8B4513;
            color: #8B4513;
        }

        /* Form */
        .form-control-custom {
            border: 1px solid #E0E0E0;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.875rem;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control-custom:focus {
            border-color: #8B4513;
            outline: none;
            box-shadow: 0 0 0 3px rgba(139,69,19,0.15);
        }

        /* ============================================
           IMPROVED PRIORITY UI
        ============================================ */
        
        /* Priority Badges - with icons */
        .priority-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        
        .priority-high {
            background: #DC2626;
            color: #FFFFFF;
            box-shadow: 0 2px 4px rgba(220,38,38,0.25);
        }
        
        .priority-medium {
            background: #FFD700;
            color: #1A1A1A;
            box-shadow: 0 2px 4px rgba(255,215,0,0.25);
        }
        
        .priority-low {
            background: #22C55E;
            color: #FFFFFF;
            box-shadow: 0 2px 4px rgba(34,197,94,0.25);
        }
        
        .priority-badge i {
            font-size: 0.7rem;
        }
        
        /* Priority Selector - Visual Cards */
        .priority-selector {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        
        .priority-option {
            flex: 1;
            text-align: center;
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }
        
        .priority-option input {
            display: none;
        }
        
        .priority-option label {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            margin: 0;
        }
        
        .priority-option.high {
            background: #FEE2E2;
            color: #DC2626;
        }
        
        .priority-option.high.selected {
            background: #DC2626;
            color: white;
            border-color: #DC2626;
            box-shadow: 0 4px 12px rgba(220,38,38,0.3);
        }
        
        .priority-option.medium {
            background: #FEF3C7;
            color: #D97706;
        }
        
        .priority-option.medium.selected {
            background: #FFD700;
            color: #1A1A1A;
            border-color: #FFD700;
            box-shadow: 0 4px 12px rgba(255,215,0,0.3);
        }
        
        .priority-option.low {
            background: #D1FAE5;
            color: #059669;
        }
        
        .priority-option.low.selected {
            background: #22C55E;
            color: white;
            border-color: #22C55E;
            box-shadow: 0 4px 12px rgba(34,197,94,0.3);
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        
        .status-pending { background: #FFD700; color: #1A1A1A; }
        .status-progress { background: #8B4513; color: #FFFFFF; }
        .status-completed { background: #22C55E; color: #FFFFFF; }

        /* Tables */
        .data-table {
            width: 100%;
        }
        .data-table thead th {
            background: #FAFAFA;
            padding: 14px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #666666;
            border-bottom: 1px solid #F0F0F0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table tbody td {
            padding: 16px;
            font-size: 0.875rem;
            border-bottom: 1px solid #F5F5F5;
            vertical-align: middle;
        }
        
        .data-table tbody tr:hover {
            background: #FAFAFA;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
            .toggle-sidebar { display: block !important; }
            .content-wrapper { padding: 16px; }
        }

        .toggle-sidebar { display: none; font-size: 1.25rem; cursor: pointer; color: #1A1A1A; }

        .fade-in { animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Modal Styles */
        .modal-custom .modal-content {
            border-radius: 20px;
            border: none;
        }
        
        .modal-custom .modal-header {
            background: #8B4513;
            color: #FFFFFF;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            padding: 18px 24px;
        }
        
        .modal-custom .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Alert */
        .alert-success {
            background: #22C55E;
            border: none;
            color: #FFFFFF;
            border-radius: 12px;
            padding: 14px 20px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar - BLACK -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-tasks"></i> Zentask</h3>
            <p>Professional Task Management</p>
        </div>
        <div class="sidebar-menu">
            <div class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fas fa-chart-line"></i><span>Dashboard</span></a>
            </div>
            <div class="menu-item {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                <a href="{{ route('tasks.index') }}"><i class="fas fa-tasks"></i><span>All Tasks</span></a>
            </div>
            <div class="menu-item {{ request()->routeIs('tasks.calendar') ? 'active' : '' }}">
                <a href="{{ route('tasks.calendar') }}"><i class="fas fa-calendar"></i><span>Calendar</span></a>
            </div>
            <div class="menu-item {{ request()->routeIs('tasks.trashed') ? 'active' : '' }}">
                <a href="{{ route('tasks.trashed') }}"><i class="fas fa-archive"></i><span>Archive</span></a>
            </div>
            <div style="margin: 16px; border-top: 1px solid #333333;"></div>
            <div class="menu-item {{ request()->routeIs('about') ? 'active' : '' }}">
                <a href="{{ route('about') }}"><i class="fas fa-info-circle"></i><span>About</span></a>
            </div>
            <div class="menu-item {{ request()->routeIs('service') ? 'active' : '' }}">
                <a href="{{ route('service') }}"><i class="fas fa-cogs"></i><span>Services</span></a>
            </div>
            <div class="menu-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                <a href="{{ route('contact') }}"><i class="fas fa-envelope"></i><span>Contact</span></a>
            </div>
            <div class="menu-item">
                <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i><span>Profile</span></a>
            </div>
            <div class="menu-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt"></i><span>Logout</span></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-navbar">
            <div class="toggle-sidebar" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <i class="fas fa-bars"></i>
            </div>
            <div class="page-title">
                <h4>@yield('page-title', 'Dashboard')</h4>
                <p>@yield('page-subtitle', 'Welcome back, ' . Auth::user()->name)</p>
            </div>
            <div class="user-info">
                <div class="user-avatar dropdown-toggle" data-bs-toggle="dropdown">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>

        <div class="app-footer">
            <p>&copy; {{ date('Y') }} Zentask - Professional Task Management System</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>