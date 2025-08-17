<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo2.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo2.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo2.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/logo2.png') }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'SoosanEgypt Dashboard') }}</title>
    <meta name="description" content="@yield('description', 'SoosanEgypt Admin Dashboard - Manage drilling equipment, products, and business operations.')">
    <meta name="keywords" content="@yield('keywords', 'admin dashboard, drilling equipment management, SoosanEgypt, business operations')">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="SoosanEgypt">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Admin Styles -->
    <style>
        :root {
            /* SOOSAN EGYPT Brand Colors */
            --soosan-primary: #e63946;
            --soosan-secondary: #457b9d;
            --soosan-dark: #1d3557;
            --soosan-light: #f8f9fa;
            --soosan-accent: #ffb703;

            /* Keep original admin colors for backward compatibility */
            --admin-primary: var(--soosan-primary);
            --admin-secondary: var(--soosan-secondary);
            --admin-success: #10b981;
            --admin-danger: #ef4444;
            --admin-warning: #f59e0b;
            --admin-info: #06b6d4;
            --admin-dark: var(--soosan-dark);
            --admin-light: var(--soosan-light);
            --sidebar-width: 280px;

            /* Enhanced Design Variables */
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            --danger-gradient: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            --info-gradient: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
            --secondary-gradient: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            --border-radius: 1rem;
            --border-radius-sm: 0.5rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Enhanced Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--admin-dark) 0%, #2d3748 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: var(--transition);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            pointer-events: none;
        }

        .admin-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding-top: 80px;
            transition: var(--transition);
        }

        /* Enhanced Navbar */
        .admin-navbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
            backdrop-filter: blur(20px);
            color: var(--admin-dark);
            border: none;
            border-radius: 0;
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 0;
            min-height: 80px;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 1055;
            overflow: visible;
            transition: var(--transition);
        }

        .admin-navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .admin-navbar h5 {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            text-shadow: none;
        }

        /* Enhanced Sidebar Brand */
        .sidebar-brand {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .sidebar-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .sidebar-brand h4 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 700;
            font-size: 1.25rem;
        }

        /* Enhanced Sidebar Navigation */
        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border-radius: 0;
            margin: 0.25rem 1rem;
            border-radius: var(--border-radius-sm);
        }

        .sidebar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .sidebar-nav .nav-link:hover::before {
            left: 100%;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(102, 126, 234, 0.2);
            color: #ffffff;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .sidebar-nav .nav-link i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .submenu {
            padding-left: 1rem;
            background: rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius-sm);
            margin: 0.25rem 1rem;
            overflow: hidden;
        }

        .submenu-link {
            padding: 0.75rem 1rem !important;
            font-size: 0.9rem;
            border-left: 3px solid transparent;
            margin: 0 !important;
            border-radius: 0 !important;
        }

        .submenu-link.active {
            border-left-color: var(--admin-primary);
            background: rgba(230, 57, 70, 0.2);
        }

        .submenu-link:hover {
            background: rgba(230, 57, 70, 0.1);
        }

        /* Enhanced Cards */
        .admin-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--admin-dark);
            transition: var(--transition);
        }

        .admin-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        .stats-card {
            padding: 1.5rem;
            border-left: 4px solid var(--admin-primary);
        }

        /* Enhanced Buttons */
        .btn-admin-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-admin-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-admin-primary:hover::before {
            left: 100%;
        }

        .btn-admin-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Enhanced Alerts */
        .alert-custom {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .alert-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            background: currentColor;
        }

        /* Enhanced Tables */
        .table-admin {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            color: var(--admin-dark);
        }

        .table-admin th {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 2px solid #e5e7eb;
            font-weight: 600;
            color: var(--admin-dark);
            padding: 1rem;
        }

        .table-admin td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Enhanced User Elements */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* Enhanced Notifications */
        .notification-badge {
            min-width: 22px;
            height: 22px;
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 1;
            padding: 0.25rem 0.4rem;
            border: 2px solid white;
            animation: none;
            transition: var(--transition);
            background: var(--danger-gradient) !important;
        }

        .notification-badge.badge-visible {
            display: inline-block !important;
        }

        .notification-badge.badge-pulse {
            animation: pulse 1s ease-in-out;
        }

        .notification-badge.badge-new {
            animation: bounce 0.6s ease-in-out;
        }

        .notification-bell-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-bell-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .notification-dropdown-content {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }

        .notification-item {
            transition: var(--transition);
            border-left: 3px solid transparent;
            padding: 0.75rem 1rem;
        }

        .notification-item:hover {
            background: rgba(102, 126, 234, 0.05);
            border-left-color: var(--admin-primary);
        }

        .notification-item.unread {
            background: rgba(102, 126, 234, 0.1);
            border-left-color: var(--admin-primary);
        }

        /* Language Switcher */
        .language-switcher {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: var(--border-radius) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .language-switcher .dropdown-item {
            color: var(--admin-dark) !important;
            background: transparent !important;
            font-weight: 600;
            transition: var(--transition);
            padding: 0.75rem 1rem;
        }

        .language-switcher .dropdown-item.active,
        .language-switcher .dropdown-item.bg-light {
            background: var(--primary-gradient) !important;
            color: #fff !important;
            border-radius: var(--border-radius-sm);
        }

        .language-switcher .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1) !important;
            color: var(--admin-dark) !important;
        }

        /* Enhanced Dropdown Buttons */
        .dropdown-toggle {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: var(--border-radius-sm) !important;
            color: var(--admin-dark) !important;
            font-weight: 600;
            transition: var(--transition);
            padding: 0.5rem 1rem;
        }

        .dropdown-toggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 1) !important;
        }

        /* Mobile Responsiveness */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 260px;
            }

            .admin-navbar {
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
            }

            .admin-navbar h5 {
                font-size: 1.25rem !important;
            }
        }

        @media (max-width: 992px) {
            :root {
                --sidebar-width: 240px;
            }

            .admin-navbar {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .admin-content {
                margin-left: 0;
                padding-top: 70px;
            }

            .admin-navbar {
                left: 0;
                padding: 0.75rem 1rem;
                min-height: 70px;
                flex-direction: row;
                align-items: center;
            }

            .admin-navbar h5 {
                font-size: 1.1rem !important;
            }

            .admin-sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 50px rgba(0, 0, 0, 0.3);
            }

            .sidebar-brand {
                padding: 1.5rem 1rem;
            }

            .sidebar-brand h4 {
                font-size: 1.1rem;
            }

            .sidebar-nav .nav-link {
                padding: 0.75rem 1rem;
                margin: 0.125rem 0.5rem;
            }

            .sidebar-nav .nav-link i {
                width: 20px;
                margin-right: 0.5rem;
            }

            /* Mobile navbar adjustments */
            .admin-navbar .d-flex {
                gap: 0.5rem !important;
            }

            .dropdown-toggle {
                padding: 0.375rem 0.75rem !important;
                font-size: 0.875rem !important;
            }

            .notification-bell-btn {
                width: 36px;
                height: 36px;
            }

            .avatar-circle {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            /* Hide text on mobile, show icons */
            .mobile-hide {
                display: none !important;
            }

            .mobile-show {
                display: inline-block !important;
            }
        }

        @media (max-width: 576px) {
            .admin-navbar {
                padding: 0.5rem 0.75rem;
                min-height: 60px;
            }

            .admin-navbar h5 {
                font-size: 1rem !important;
            }

            .admin-content {
                padding-top: 60px;
            }

            .dropdown-toggle {
                padding: 0.25rem 0.5rem !important;
                font-size: 0.8rem !important;
            }

            .notification-bell-btn {
                width: 32px;
                height: 32px;
            }

            .avatar-circle {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .sidebar-brand {
                padding: 1rem 0.75rem;
            }

            .sidebar-nav .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 375px) {
            .admin-navbar {
                padding: 0.375rem 0.5rem;
            }

            .admin-navbar h5 {
                font-size: 0.9rem !important;
            }

            .dropdown-toggle span {
                display: none;
            }
        }

        /* Animations */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Toast Notifications */
        .toast-notification {
            position: fixed;
            top: 90px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: var(--border-radius);
            padding: 1rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            max-width: 350px;
            transform: translateX(100%);
            transition: var(--transition);
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        /* Ensure dropdowns render above everything */
        .dropdown-menu,
        .dropdown-menu.show {
            z-index: 2000 !important;
        }

        .dropdown-menu .dropdown-item {
            @if (app()->getLocale() === 'ar')
                text-align: right;

            @else
                text-align: left;
            @endif
        }

        .dropdown-menu .dropdown-item i {
            @if (app()->getLocale() === 'ar')
                margin-left: 10px;
            @else
                margin-right: 10px;
            @endif
        }

        .dropdown-menu .dropdown-item span {
            @if (app()->getLocale() === 'ar')
                margin-left: 10px;
            @else
                margin-right: 10px;
            @endif
        }

        .notification-dropdown-content {
            z-index: 2001 !important;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Logout button styling */
        .logout-btn {
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
            transform: translateX(5px);
        }

        /* Enhanced focus states */
        .dropdown-toggle:focus,
        .notification-bell-btn:focus,
        .nav-link:focus {
            outline: 2px solid rgba(102, 126, 234, 0.5);
            outline-offset: 2px;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .admin-sidebar {
                border-right: 2px solid #000;
            }

            .admin-navbar {
                border-bottom: 2px solid #000;
            }
        }
    </style>



    @stack('styles')
</head>

<body>
    @if (!request()->routeIs('admin.login'))
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h4 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    {{ __('admin.admin_panel') }}
                </h4>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    {{ __('admin.dashboard') }}
                </a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        {{ __('admin.users') }}
                    </a>
                @endif

                <!-- Products - employees can create new and edit existing (with approval) -->
                <a href="{{ route('admin.products.index') }}"
                    class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    {{ __('admin.products') }}
                </a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.product-categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        {{ __('admin.categories') }}
                    </a>
                @endif

                <!-- Owners - employees can create new and edit existing (with approval) -->
                <a href="{{ route('admin.owners.index') }}"
                    class="nav-link {{ request()->routeIs('admin.owners.*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i>
                    {{ __('admin.owners') }}
                </a>

                <!-- Sold Products - employees can create new and edit existing (with approval) -->
                <a href="{{ route('admin.sold-products.index') }}"
                    class="nav-link {{ request()->routeIs('admin.sold-products.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    {{ __('admin.sold_products') }}
                </a>

                <!-- Contact Messages - view only for employees -->
                <a href="{{ route('admin.contact-messages.index') }}"
                    class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    {{ __('admin.contact_messages') }}
                </a>

                @if (auth()->user()->isAdmin())
                    <!-- Pending Changes - admin only -->
                    <a href="{{ route('admin.pending-changes.index') }}"
                        class="nav-link {{ request()->routeIs('admin.pending-changes.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        {{ __('admin.pending_changes') }}
                        @php
                            $pendingCount = \App\Models\PendingChange::where('status', 'pending')->count();
                        @endphp
                        @if ($pendingCount > 0)
                            <span class="badge badge-warning ms-auto">{{ $pendingCount }}</span>
                        @endif
                    </a>

                    <!-- Audit Logs - admin only -->
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#auditLogsSubmenu"
                            aria-expanded="{{ request()->routeIs('admin.audit-logs.*') ? 'true' : 'false' }}">
                            <i class="fas fa-eye"></i>
                            {{ __('admin.system_monitor') }}
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.audit-logs.*') ? 'show' : '' }}"
                            id="auditLogsSubmenu">
                            <div class="submenu">
                                <a href="{{ route('admin.audit-logs.dashboard') }}"
                                    class="nav-link submenu-link {{ request()->routeIs('admin.audit-logs.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar"></i>
                                    {{ __('admin.dashboard') }}
                                </a>
                                <a href="{{ route('admin.audit-logs.index') }}"
                                    class="nav-link submenu-link {{ request()->routeIs('admin.audit-logs.index') ? 'active' : '' }}">
                                    <i class="fas fa-list"></i>
                                    {{ __('admin.activity_log') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Reports - admin/CEO only -->
                    @if (auth()->user()->canAccessReports())
                        <a href="{{ route('admin.reports.index') }}"
                            class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            {{ __('reports.reports') }}
                        </a>
                    @endif

                    <!-- Deleted Items Management -->
                    <a href="{{ route('admin.deleted-items.index') }}"
                        class="nav-link {{ request()->routeIs('admin.deleted-items.*') ? 'active' : '' }}">
                        <i class="fas fa-trash-restore"></i>
                        {{ __('admin.deleted_items') }}                 
                    </a>
                @endif

                <hr class="border-secondary mx-3 my-3">

                <a href="{{ route('homepage') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    {{ __('admin.view_website') }}
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link logout-btn"
                        style="width: 100%; text-align: left; border: none; background: none; color: rgba(255,255,255,0.8);">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('admin.logout') }}
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Top Navbar -->
            <nav class="admin-navbar">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link d-lg-none me-3 p-0" id="sidebarToggle"
                            style="color: var(--admin-dark);">
                            <i class="fas fa-bars fs-5"></i>
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <!-- Language Switcher -->
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe"></i>
                                <span class="mobile-hide">{{ app()->isLocale('ar') ? 'العربية' : 'English' }}</span>
                                <i class="fas fa-chevron-down fs-xs ms-1"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end language-switcher">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center {{ app()->isLocale('en') ? 'active bg-light' : '' }}"
                                        href="{{ url('/lang/en') }}">
                                        <span class="me-2" style="font-size:1.2em;">🇺🇸</span> English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center {{ app()->isLocale('ar') ? 'active bg-light' : '' }}"
                                        href="{{ url('/lang/ar') }}">
                                        <span class="me-2" style="font-size:1.2em;">🇪🇬</span> العربية
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Notifications -->
                        <div class="dropdown">
                            <button class="btn position-relative notific    ation-bell-btn" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell fs-5 text-secondary"></i>
                                <span
                                    class="notification-badge position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                    style="display: {{ auth()->user()->unreadNotifications->count() > 0 ? 'inline-block' : 'none' }};"
                                    data-initial-count="{{ auth()->user()->unreadNotifications->count() }}">
                                    {{ auth()->user()->unreadNotifications->count() > 0 ? auth()->user()->unreadNotifications->count() : '0' }}
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end notification-dropdown-content"
                                style="width: 350px; max-height: 400px; overflow-y: auto;">
                                <li class="py-2 px-3 bg-light border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-semibold">{{ __('admin.notifications') }}</h6>
                                        <a href="{{ route('notifications.index') }}"
                                            class="text-decoration-none small">{{ __('admin.view_all') }}</a>
                                    </div>
                                </li>
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    @php
                                        $redirectUrl = $notification->data['url'] ?? route('notifications.index');
                                    @endphp
                                    <li>
                                        <a class="dropdown-item notification-item {{ !$notification->read_at ? 'unread' : '' }}"
                                            href="{{ $redirectUrl }}"
                                            data-notification-id="{{ $notification->id }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="notification-icon bg-light text-{{ $notification->data['color'] ?? 'warning' }} rounded-circle p-2 text-center"
                                                        style="width: 36px; height: 36px;">
                                                        <i
                                                            class="{{ $notification->data['icon'] ?? 'fas fa-exclamation-triangle' }}"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="fw-bold text-truncate">
                                                        {{ $notification->data['title'] ?? __('admin.notifications') }}
                                                    </div>
                                                    <div class="text-muted small text-truncate">
                                                        {{ Str::limit($notification->data['message'] ?? '', 60) }}
                                                    </div>
                                                    @if (isset($notification->data['reason']) && $notification->data['reason'])
                                                        <div class="text-danger small text-truncate">
                                                            {{ Str::limit($notification->data['reason'], 80) }}
                                                        </div>
                                                    @endif
                                                    <div class="text-muted small">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li>
                                        <span class="dropdown-item-text py-3 text-center text-muted">
                                            {{ __('admin.no_notifications') }}
                                        </span>
                                    </li>
                                @endforelse
                                <li class="border-top">
                                    <a class="dropdown-item text-center py-2"
                                        href="{{ route('notifications.index') }}">
                                        {{ __('admin.view_all_notifications') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- User Menu -->
                        <div class="dropdown">
                            <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @php $userImg = auth()->user()->image_url; @endphp
                                @if ($userImg)
                                    <img src="{{ asset($userImg) }}" alt="{{ auth()->user()->name }}"
                                        class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="avatar-circle">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="d-none d-md-block text-start">
                                    <div class="fw-semibold text-dark">{{ auth()->user()->name }}</div>
                                    <div class="text-muted small">
                                        {{ auth()->user()->roles && auth()->user()->roles->first() ? auth()->user()->roles->first()->name : 'User' }}
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down ms-1 text-muted fs-xs mobile-hide"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: var(--border-radius);">
                                <li class="dropdown-header">
                                    <div class="text-muted small">{{ __('admin.signed_in_as') }}</div>
                                    <div class="fw-semibold">{{ auth()->user()->email }}</div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2 text-muted"></i>{{ __('admin.profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('notifications.index') }}">
                                        <i class="fas fa-bell me-2 text-muted"></i>{{ __('admin.notifications') }}
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('admin.logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-4">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-custom mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-custom mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-custom mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    @else
        @yield('content')
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced sidebar toggle for mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle && sidebar && sidebarOverlay) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });

                // Close sidebar when clicking overlay
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });

                // Close sidebar on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    if (alert.classList.contains('alert-success')) {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }
                });
            }, 5000);

            // Confirm delete actions
            document.querySelectorAll('[data-confirm]').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    if (!confirm(this.dataset.confirm)) {
                        e.preventDefault();
                    }
                });
            });

            // Enhanced Notification Badge Animation
            const notificationBadge = document.querySelector('.notification-badge');
            if (notificationBadge && parseInt(notificationBadge.textContent.trim()) > 0) {
                notificationBadge.classList.add('badge-new');
                setTimeout(() => {
                    notificationBadge.classList.remove('badge-new');
                }, 2000);
            }

            // Mark notifications as read when clicked
            document.querySelectorAll('.notification-item').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    const notificationId = this.dataset.notificationId;
                    if (notificationId) {
                        fetch(`/notifications/${notificationId}/mark-as-read`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.classList.remove('unread');
                                    updateNotificationBadge();
                                }
                            })
                            .catch(error => console.error('Error marking notification as read:',
                                error));
                    }
                });
            });

            // Function to update notification badge
            function updateNotificationBadge() {
                const badge = document.querySelector('.notification-badge');
                const currentCount = parseInt(badge.textContent.trim());
                if (currentCount > 1) {
                    badge.textContent = currentCount - 1;
                    badge.classList.add('badge-pulse');
                    setTimeout(() => {
                        badge.classList.remove('badge-pulse');
                    }, 1000);
                } else {
                    badge.style.display = 'none';
                }
            }

            // Enhanced dropdown interactions
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                });

                toggle.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Session Management and Security
        const SessionManager = {
            checkInterval: null,
            warningShown: false,
            
            init: function() {
                // Start session monitoring
                this.startSessionCheck();
                
                // Handle logout cleanup
                this.handleLogoutCleanup();
                
                // Handle browser close/refresh
                this.handleBeforeUnload();
                
                // Check for session warnings
                this.checkSessionWarnings();
            },
            
            startSessionCheck: function() {
                // Check session every 2 minutes
                this.checkInterval = setInterval(() => {
                    this.checkSession();
                }, 120000);
            },
            
            checkSession: function() {
                fetch('{{ route('admin.session.check') }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.authenticated) {
                        this.handleSessionExpired();
                    } else {
                        // Update session data in localStorage
                        this.updateSessionData(data);
                        
                        // Show warning if session is about to expire
                        if (data.session_remaining && data.session_remaining <= 5 && !this.warningShown) {
                            this.showSessionWarning(data.session_remaining);
                        }
                    }
                })
                .catch(error => {
                    console.error('Session check failed:', error);
                });
            },
            
            updateSessionData: function(data) {
                try {
                    localStorage.setItem('admin_session_data', JSON.stringify({
                        user: data.user,
                        last_check: new Date().getTime(),
                        session_remaining: data.session_remaining
                    }));
                } catch (e) {
                    console.log('Error updating session data:', e);
                }
            },
            
            showSessionWarning: function(minutesRemaining) {
                this.warningShown = true;
                
                const warningModal = document.createElement('div');
                warningModal.className = 'modal fade';
                warningModal.id = 'sessionWarningModal';
                warningModal.setAttribute('data-bs-backdrop', 'static');
                warningModal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Session Expiring Soon
                                </h5>
                            </div>
                            <div class="modal-body">
                                <p>Your session will expire in approximately <strong>${minutesRemaining} minutes</strong>.</p>
                                <p>Would you like to extend your session?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="SessionManager.logout()">
                                    Logout Now
                                </button>
                                <button type="button" class="btn btn-primary" onclick="SessionManager.extendSession()">
                                    Extend Session
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(warningModal);
                const modal = new bootstrap.Modal(warningModal);
                modal.show();
            },
            
            extendSession: function() {
                // Make a simple request to extend session
                fetch('{{ route('admin.dashboard') }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    credentials: 'same-origin'
                })
                .then(() => {
                    // Close modal and reset warning
                    const modal = bootstrap.Modal.getInstance(document.getElementById('sessionWarningModal'));
                    if (modal) {
                        modal.hide();
                    }
                    this.warningShown = false;
                    
                    // Show success message
                    this.showAlert('Session extended successfully!', 'success');
                })
                .catch(error => {
                    console.error('Failed to extend session:', error);
                    this.handleSessionExpired();
                });
            },
            
            handleSessionExpired: function() {
                // Clear intervals
                if (this.checkInterval) {
                    clearInterval(this.checkInterval);
                }
                
                // Clear local storage
                this.clearSessionData();
                
                // Show expiry message and redirect
                this.showAlert('Your session has expired. Please login again.', 'danger');
                
                setTimeout(() => {
                    window.location.href = '{{ route('admin.login') }}';
                }, 2000);
            },
            
            logout: function() {
                // Clear intervals
                if (this.checkInterval) {
                    clearInterval(this.checkInterval);
                }
                
                // Submit logout form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.logout') }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Mark for local storage cleanup
                sessionStorage.setItem('clear_local_storage', 'true');
                
                document.body.appendChild(form);
                form.submit();
            },
            
            clearSessionData: function() {
                try {
                    localStorage.removeItem('admin_session_data');
                    // Don't clear remember me preferences unless explicitly logging out
                } catch (e) {
                    console.log('Error clearing session data:', e);
                }
            },
            
            handleLogoutCleanup: function() {
                // Check for logout cleanup flags
                if (sessionStorage.getItem('clear_local_storage')) {
                    try {
                        localStorage.removeItem('admin_remember_me');
                        localStorage.removeItem('admin_email');
                        localStorage.removeItem('admin_language');
                        localStorage.removeItem('admin_session_data');
                        sessionStorage.removeItem('clear_local_storage');
                    } catch (e) {
                        console.log('Error during logout cleanup:', e);
                    }
                }
            },
            
            handleBeforeUnload: function() {
                window.addEventListener('beforeunload', () => {
                    // Update last activity time
                    try {
                        const sessionData = JSON.parse(localStorage.getItem('admin_session_data') || '{}');
                        sessionData.last_activity = new Date().getTime();
                        localStorage.setItem('admin_session_data', JSON.stringify(sessionData));
                    } catch (e) {
                        console.log('Error updating last activity:', e);
                    }
                });
            },
            
            checkSessionWarnings: function() {
                // Check for session warnings from server
                @if(session('session_warning'))
                    const remaining = {{ session('session_remaining', 5) }};
                    if (!this.warningShown) {
                        this.showSessionWarning(remaining);
                    }
                @endif
            },
            
            showAlert: function(message, type = 'info') {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alert.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(alert);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 5000);
            }
        };

        // Initialize session manager
        SessionManager.init();

        // Enhanced logout button handling
        document.querySelectorAll('form[action*="logout"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                sessionStorage.setItem('clear_local_storage', 'true');
            });
        });
    </script>

    <!-- Real-time notifications -->
    <script src="{{ asset('js/notifications.js') }}"></script>


    @stack('scripts')
</body>

</html>
