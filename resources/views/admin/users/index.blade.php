@extends('layouts.admin')

@section('title', __('users.staff_management'))

@push('styles')
<style>
    /* Reset and Base Styles */
    .modern-container * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .modern-container {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding: 1rem;
        color: #1a202c;
        line-height: 1.6;
    }

    /* Page Header */
    .modern-page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        padding: 2rem 1.5rem;
        margin: -1rem -1rem 2rem;
        border-radius: 0 0 24px 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modern-page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        z-index: 0;
    }

    .modern-page-header .container-fluid {
        position: relative;
        z-index: 1;
    }

    .page-title {
        font-weight: 700;
        font-size: clamp(1.5rem, 4vw, 2rem);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .stat-card.success::before { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .stat-card.warning::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-card.danger::before { background: linear-gradient(90deg, #ef4444, #dc2626); }

    .stat-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ffffff;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0 auto 1rem;
        transition: transform 0.3s ease;
    }

    .stat-card.success .stat-icon { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
    .stat-card.warning .stat-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-card.danger .stat-icon { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        color: #718096;
        font-size: 0.875rem;
        font-weight: 500;
        margin: 0;
    }

    /* Modern Card */
    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modern-card .card-body {
        padding: 1.5rem;
    }

    /* Filter Form */
    .filter-form .row {
        gap: 1rem 0;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modern-input,
    .modern-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        font-size: 0.875rem;
        color: #1a202c;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(5px);
    }

    .modern-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em 1.25em;
        padding-right: 2.5rem;
    }

    .modern-input:focus,
    .modern-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
        background: rgba(255, 255, 255, 1);
    }

    .modern-input::placeholder {
        color: #9ca3af;
    }

    /* User Cards Grid */
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .user-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .user-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .user-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .user-info {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .user-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.2);
        transition: transform 0.3s ease;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .user-card:hover .user-avatar {
        transform: scale(1.1);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .user-details h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.25rem;
    }

    .user-email {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .user-created {
        font-size: 0.75rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Badges */
    .badge-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .modern-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    }

    .badge-primary { background: #e0e7ff; color: #3730a3; }
    .badge-success { background: #bbf7d0; color: #166534; }
    .badge-warning { background: #fde68a; color: #92400e; }
    .badge-danger { background: #fecaca; color: #991b1b; }

    /* Action Buttons */
    .actions-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        font-size: 0.875rem;
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transition: left 0.5s;
    }

    .action-btn:hover::before {
        left: 100%;
    }

    .action-btn:hover {
        transform: scale(1.1);
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }

    .action-btn i {
        position: relative;
        z-index: 1;
    }

    .btn-info { border-color: #667eea; color: #667eea; }
    .btn-warning { border-color: #f59e0b; color: #f59e0b; }
    .btn-success { border-color: #22c55e; color: #22c55e; }
    .btn-secondary { border-color: #a0aec0; color: #a0aec0; }
    .btn-danger { border-color: #ef4444; color: #ef4444; }

    /* Modern Button */
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        min-height: 44px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modern-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .modern-btn:hover::before {
        left: 100%;
    }

    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
    }

    .modern-btn-secondary {
        background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
    }

    .modern-btn-secondary:hover {
        box-shadow: 0 10px 25px -5px rgba(113, 128, 150, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 2rem;
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
    }

    .empty-title {
        color: #1a202c;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .empty-description {
        color: #6b7280;
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }

    /* Alert Styles */
    .modern-alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: #bbf7d0;
        color: #166534;
        border-left: 4px solid #22c55e;
    }

    /* Pagination */
    .pagination-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1.5rem;
        text-align: center;
    }

    /* Loading States */
    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }

    .animate-stagger {
        animation: fadeInUp 0.6s ease-out both;
    }

    .animate-stagger:nth-child(1) { animation-delay: 0.1s; }
    .animate-stagger:nth-child(2) { animation-delay: 0.2s; }
    .animate-stagger:nth-child(3) { animation-delay: 0.3s; }
    .animate-stagger:nth-child(4) { animation-delay: 0.4s; }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .users-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .modern-container {
            padding: 0.75rem;
        }
        .modern-page-header {
            margin: -0.75rem -0.75rem 1.5rem;
            padding: 1.5rem 1rem;
        }
        .modern-page-header .row {
            flex-direction: column;
            gap: 1rem;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .stat-card {
            padding: 1rem;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }
        .stat-value {
            font-size: 1.5rem;
        }
        .users-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .user-card {
            padding: 1rem;
        }
        .modern-card .card-body {
            padding: 1rem;
        }
        .actions-container {
            gap: 0.75rem;
        }
        .action-btn {
            width: 44px;
            height: 44px;
        }
    }

    @media (max-width: 576px) {
        .modern-page-header h1 {
            font-size: 1.25rem;
        }
        .modern-page-header p {
            font-size: 0.875rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .stat-card {
            padding: 1rem;
        }
        .stat-value {
            font-size: 1.25rem;
        }
        .user-card {
            padding: 0.75rem;
        }
        .user-info {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }
        .user-avatar {
            align-self: center;
        }
        .modern-card .card-body {
            padding: 0.75rem;
        }
        .filter-form .row > * {
            margin-bottom: 0.75rem;
        }
    }

    @media (max-width: 375px) {
        .page-title {
            font-size: 1rem;
        }
        .stat-value {
            font-size: 1rem;
        }
        .action-btn {
            width: 36px;
            height: 36px;
            font-size: 0.75rem;
        }
    }

    /* Focus and accessibility */
    .modern-input:focus,
    .modern-select:focus,
    .modern-btn:focus,
    .action-btn:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>
@endpush

@section('content')
<div class="staff-management-container">
    <!-- Page Header -->
    <div class="modern-page-header animate-fade-in-up">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">
                        <i class="fas fa-users"></i>
                        {{ __('users.staff_management') }}
                    </h1>
                    <p class="page-subtitle">{{ __('users.manage_staff') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('admin.users.create') }}" class="modern-btn">
                        <i class="fas fa-plus"></i>
                        <span class="d-none d-md-inline">{{ __('users.add_user') }}</span>
                        <span class="d-md-none">{{ __('users.add') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="modern-alert alert-success animate-slide-in-left" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card animate-stagger">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-label">{{ __('users.total_staff') }}</div>
        </div>

        <div class="stat-card success animate-stagger">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">{{ $users->where('is_verified', true)->count() }}</div>
            <div class="stat-label">{{ __('users.verified') }} {{ __('users.staff') }}</div>
        </div>

        <div class="stat-card danger animate-stagger">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-value">{{ $users->where('role', 'admin')->count() }}</div>
            <div class="stat-label">{{ __('users.admin') }} {{ __('users.staff') }}</div>
        </div>

        <div class="stat-card warning animate-stagger">
            <div class="stat-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="stat-value">{{ $users->where('role', 'employee')->count() }}</div>
            <div class="stat-label">{{ __('users.employee') }} {{ __('users.staff') }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="modern-card animate-stagger">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" id="filterForm" class="filter-form">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <label for="search" class="form-label">
                            <i class="fas fa-search"></i>
                            {{ __('users.search_staff') }}
                        </label>
                        <input
                            type="text"
                            class="modern-input"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('users.search_placeholder') }}"
                        >
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="role" class="form-label">
                            <i class="fas fa-user-tag"></i>
                            {{ __('users.role') }}
                        </label>
                        <select class="modern-select" id="role" name="role">
                            <option value="">{{ __('users.all_roles') }}</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>{{ __('users.admin') }}</option>
                            <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>{{ __('users.employee') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="verified" class="form-label">
                            <i class="fas fa-check-circle"></i>
                            {{ __('users.status') }}
                        </label>
                        <select class="modern-select" id="verified" name="verified">
                            <option value="">{{ __('users.all_statuses') }}</option>
                            <option value="verified" {{ request('verified') === 'verified' ? 'selected' : '' }}>{{ __('users.verified') }}</option>
                            <option value="unverified" {{ request('verified') === 'unverified' ? 'selected' : '' }}>{{ __('users.unverified') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="modern-btn w-100">
                            <i class="fas fa-search"></i>
                            <span class="d-none d-lg-inline">{{ __('users.filter') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Grid -->
    @if($users->count() > 0)
        <div class="users-grid">
            @foreach($users as $index => $user)
                <div class="user-card animate-stagger" style="animation-delay: {{ ($index % 6) * 0.1 }}s">
                    <div class="user-info">
                        <div class="user-avatar">
                            @if($user->image_url)
                                <img src="{{ asset($user->image_url) }}"
                                     alt="{{ $user->name }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display: none; width: 100%; height: 100%; border-radius: 50%; background: var(--gradient-primary); align-items: center; justify-content: center; color: white; font-weight: 700; font-size: var(--font-size-xl);">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @else
                                {{ substr($user->name, 0, 1) }}
                            @endif
                        </div>

                        <div class="user-details flex-grow-1">
                            <h5>{{ $user->name }}</h5>
                            <p class="user-email">
                                <i class="fas fa-envelope"></i>
                                {{ $user->email }}
                            </p>
                            <p class="user-created">
                                <i class="fas fa-calendar"></i>
                                {{ __('users.created') }} {{ $user->created_at ? $user->created_at->diffForHumans() : __('users.na') }}
                            </p>
                        </div>
                    </div>

                    <div class="badge-container">
                        <span class="modern-badge {{ $user->role === 'admin' ? 'badge-danger' : 'badge-primary' }}">
                            <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : 'user' }}"></i>
                            {{ $user->role === 'admin' ? __('users.admin') : __('users.employee') }}
                        </span>

                        @if($user->is_verified)
                            <span class="modern-badge badge-success">
                                <i class="fas fa-check"></i>
                                {{ __('users.verified') }}
                            </span>
                        @else
                            <span class="modern-badge badge-warning">
                                <i class="fas fa-clock"></i>
                                {{ __('users.unverified') }}
                            </span>
                        @endif
                    </div>

                    <div class="actions-container">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="action-btn btn-info"
                           title="{{ __('users.view') }}"
                           aria-label="{{ __('users.view') }} {{ $user->name }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="action-btn btn-warning"
                           title="{{ __('users.edit') }}"
                           aria-label="{{ __('users.edit') }} {{ $user->name }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="action-btn {{ $user->is_verified ? 'btn-secondary' : 'btn-success' }}"
                                        title="{{ $user->is_verified ? __('users.unverify') : __('users.verify') }}"
                                        aria-label="{{ $user->is_verified ? __('users.unverify') : __('users.verify') }} {{ $user->name }}">
                                    <i class="fas fa-{{ $user->is_verified ? 'times' : 'check' }}"></i>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="action-btn btn-danger"
                                        title="{{ __('users.delete') }}"
                                        aria-label="{{ __('users.delete') }} {{ $user->name }}"
                                        onclick="return confirm('{{ __('users.confirm_delete') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <span class="action-btn btn-secondary"
                                  title="{{ __('users.cannot_modify_own_account') }}"
                                  aria-label="{{ __('users.cannot_modify_own_account') }}">
                                <i class="fas fa-lock"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state animate-fade-in-up">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h4 class="empty-title">{{ __('users.no_staff_found') }}</h4>
            <p class="empty-description">{{ __('users.no_staff_match_filters') }}</p>
            @if(request()->hasAny(['search', 'role', 'verified']))
                <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-times"></i>
                    {{ __('users.clear_filters') }}
                </a>
            @endif
        </div>
    @endif

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="pagination-container animate-fade-in-up">
            {{ $users->withQueryString()->links() }}
        </div>
    @endif

    <!-- Summary -->
    @if($users->total() > 0)
        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('users.showing') }} {{ $users->firstItem() ?? 0 }} {{ __('users.to') }} {{ $users->lastItem() ?? 0 }} {{ __('users.of') }} {{ $users->total() }} {{ __('users.staff') }}
            </small>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initializeFilters();
    initializeAnimations();
    initializeAccessibility();
    initializeTouch();

    // Filter functionality
    function initializeFilters() {
        const filterForm = document.getElementById('filterForm');
        const filterInputs = filterForm?.querySelectorAll('select');
        const searchInput = document.getElementById('search');
        let searchTimeout;

        // Auto-submit on select change
        filterInputs?.forEach(input => {
            input.addEventListener('change', function() {
                showLoadingState();
                setTimeout(() => filterForm.submit(), 200);
            });
        });

        // Debounced search
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 2 || this.value.length === 0) {
                        showLoadingState();
                        filterForm.submit();
                    }
                }, 500);
            });
        }
    }

    // Animation system
    function initializeAnimations() {
        // Staggered animations for cards
        const animatedElements = document.querySelectorAll('.animate-stagger');
        animatedElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';

            setTimeout(() => {
                element.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.user-card').forEach(card => {
            observer.observe(card);
        });
    }

    // Accessibility enhancements
    function initializeAccessibility() {
        // Keyboard navigation for cards
        document.querySelectorAll('.user-card').forEach((card, index) => {
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'article');
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const viewLink = this.querySelector('.action-btn[title*="view"]');
                    if (viewLink) {
                        viewLink.click();
                    }
                }
            });
        });

        // Enhanced focus management
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('focus', function() {
                this.style.outline = '2px solid var(--primary-500)';
                this.style.outlineOffset = '2px';
            });

            btn.addEventListener('blur', function() {
                this.style.outline = '';
                this.style.outlineOffset = '';
            });
        });
    }

    // Touch device optimizations
    function initializeTouch() {
        if ('ontouchstart' in window) {
            document.querySelectorAll('.user-card, .stat-card').forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.transform = this.style.transform + ' scale(0.98)';
                }, { passive: true });

                element.addEventListener('touchend', function() {
                    this.style.transform = this.style.transform.replace(' scale(0.98)', '');
                }, { passive: true });
            });
        }
    }

    // Loading states
    function showLoadingState() {
        const submitButtons = document.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(btn => {
            if (!btn.dataset.noLoading) {
                const originalContent = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = `
                    <span class="loading-spinner"></span>
                    <span class="ms-2 d-none d-md-inline">{{ __('users.processing') }}</span>
                `;

                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                }, 5000);
            }
        });
    }

    // Form submission handling
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.dataset.noLoading) {
                showLoadingState();
            }
        });
    });

    // Enhanced hover effects
    document.querySelectorAll('.user-card').forEach(card => {
        let hoverTimeout;

        card.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            hoverTimeout = setTimeout(() => {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = 'var(--shadow-2xl)';
            }, 50);
        });

        card.addEventListener('mouseleave', function() {
            clearTimeout(hoverTimeout);
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'var(--shadow-lg)';
        });
    });

    // Performance optimizations
    let ticking = false;

    function updateOnScroll() {
        // Add scroll-based enhancements here if needed
        ticking = false;
    }

    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateOnScroll);
            ticking = true;
        }
    }, { passive: true });

    // Error handling for images
    document.querySelectorAll('.user-avatar img').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const fallback = this.nextElementSibling;
            if (fallback) {
                fallback.style.display = 'flex';
            }
        });
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        // Clean up any running animations or timeouts
        document.querySelectorAll('*').forEach(el => {
            el.style.transition = 'none';
        });
    });
});

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Global error handler for AJAX requests
window.addEventListener('unhandledrejection', function(event) {
    console.error('Unhandled promise rejection:', event.reason);
    // Could show user-friendly error message here
});
</script>
@endpush
