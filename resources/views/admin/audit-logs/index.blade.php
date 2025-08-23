@extends('layouts.admin')

@section('title', __('audit-logs.header.title'))

@push('styles')
<style>
    /* Modern Container */
    .modern-audit-container {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding: 1rem;
        color: #1a202c;
        line-height: 1.6;
    }
    .dark-mode .modern-audit-container {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        color: #f7fafc;
    }

    /* Modern Page Header */
    .modern-audit-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        padding: 2rem 1.5rem;
        margin: -1rem -1rem 2rem;
        border-radius: 0 0 24px 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .modern-audit-header::before {
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
    .modern-audit-header .container-fluid {
        position: relative;
        z-index: 1;
    }
    .modern-audit-header h1 {
        font-weight: 700;
        font-size: clamp(1.5rem, 4vw, 2rem);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .modern-header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-items: center;
    }

    /* Modern Cards */
    .modern-audit-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .modern-audit-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .dark-mode .modern-audit-card {
        background: rgba(45, 55, 72, 0.95);
        border-color: rgba(74, 85, 104, 0.3);
    }

    /* Stats Cards */
    .modern-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .modern-stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .modern-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }
    .modern-stat-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .dark-mode .modern-stat-card {
        background: rgba(45, 55, 72, 0.95);
        border-color: rgba(74, 85, 104, 0.3);
    }
    .modern-stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ffffff;
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }
    .modern-stat-card:hover .modern-stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .modern-stat-content h4 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.25rem;
        line-height: 1;
    }
    .dark-mode .modern-stat-content h4 {
        color: #f7fafc;
    }
    .modern-stat-content .small {
        color: #718096;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .dark-mode .modern-stat-content .small {
        color: #a0aec0;
    }

    /* Modern Buttons */
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
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
        color: #ffffff;
        text-decoration: none;
    }
    .modern-btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    }
    .modern-btn-info:hover {
        box-shadow: 0 10px 25px -5px rgba(23, 162, 184, 0.4);
    }
    .modern-btn-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    }
    .modern-btn-success:hover {
        box-shadow: 0 10px 25px -5px rgba(40, 167, 69, 0.4);
    }
    .modern-btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    }
    .modern-btn-warning:hover {
        box-shadow: 0 10px 25px -5px rgba(255, 193, 7, 0.4);
    }
    .modern-btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
    }
    .modern-btn-secondary:hover {
        box-shadow: 0 10px 25px -5px rgba(108, 117, 125, 0.4);
    }

    /* Form Controls */
    .modern-form-control {
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
    .modern-form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
        background: rgba(255, 255, 255, 1);
    }
    .dark-mode .modern-form-control {
        background: rgba(45, 55, 72, 0.9);
        border-color: #4a5568;
        color: #f7fafc;
    }
    .dark-mode .modern-form-control:focus {
        border-color: #667eea;
        background: rgba(45, 55, 72, 1);
    }

    /* Table Enhancements */
    .modern-table-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .modern-table {
        margin-bottom: 0;
    }
    .modern-table thead th {
        background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
        color: #ffffff;
        border: none;
        padding: 1rem 0.75rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(226, 232, 240, 0.5);
    }
    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }
    .dark-mode .modern-table tbody tr {
        border-bottom-color: rgba(74, 85, 104, 0.5);
    }
    .dark-mode .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.1);
    }
    .modern-table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border: none;
    }

    /* Avatar Enhancements */
    .modern-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        margin-right: 0.75rem;
        transition: transform 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .modern-avatar:hover {
        transform: scale(1.1);
    }
    .modern-avatar.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
    }

    /* Badge Enhancements */
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
        transition: all 0.3s ease;
    }
    .modern-badge:hover {
        transform: scale(1.05);
    }
    .modern-badge.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
    }
    .modern-badge.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
    }
    .modern-badge.bg-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #ffffff;
    }
    .modern-badge.bg-info {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #ffffff;
    }
    .modern-badge.bg-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #ffffff;
    }

    /* Animations */
    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.3; }
    }
    .blink {
        animation: blink 1s infinite;
    }

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
    .fade-in-up {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .modern-stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .modern-header-actions {
            justify-content: center;
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .modern-audit-container {
            padding: 0.75rem;
        }
        .modern-audit-header {
            margin: -0.75rem -0.75rem 1.5rem;
            padding: 1.5rem 1rem;
        }
        .modern-audit-header h1 {
            font-size: 1.25rem;
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
        .modern-header-actions {
            flex-direction: column;
            width: 100%;
            gap: 0.5rem;
        }
        .modern-btn {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 1rem;
            font-size: 0.875rem;
        }
        .modern-stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .modern-stat-card {
            padding: 1rem;
        }
        .modern-stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }
        .modern-stat-content h4 {
            font-size: 1.5rem;
        }

        /* Mobile table responsiveness */
        .table-responsive {
            border-radius: 12px;
        }
        .modern-table thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.75rem;
        }
        .modern-table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }

        /* Hide text on mobile, show icons */
        .mobile-hide-text {
            display: none;
        }
        .mobile-show-icon {
            display: inline;
        }

        /* Stack user info vertically on mobile */
        .user-info-mobile {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .user-info-mobile .modern-avatar {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }

        /* Fix filter button sizing */
        .modern-btn.btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Make chevron icons smaller */
        .fas.fa-chevron-down,
        .fas.fa-chevron-up {
            font-size: 0.75rem !important;
        }
    }

    @media (max-width: 576px) {
        .modern-audit-header h1 {
            font-size: 1.125rem;
        }
        .modern-stat-content h4 {
            font-size: 1.25rem;
        }
        .modern-btn {
            padding: 0.75rem;
            font-size: 0.75rem;
        }

        /* Ultra mobile optimizations */
        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.5rem 0.25rem;
            font-size: 0.75rem;
        }

        /* Collapse some columns on very small screens */
        .mobile-collapse {
            display: none;
        }

        /* Even smaller chevron icons on mobile */
        .fas.fa-chevron-down,
        .fas.fa-chevron-up {
            font-size: 0.625rem !important;
        }

        /* Compact filter layout */
        .row.g-3 {
            gap: 0.5rem !important;
        }
        .col-md-2.col-sm-6 {
            margin-bottom: 0.5rem;
        }
    }

    /* Extra small screens */
    @media (max-width: 480px) {
        .modern-audit-header {
            padding: 1rem 0.75rem;
        }
        .modern-audit-header h1 {
            font-size: 1rem;
        }
        .modern-btn {
            padding: 0.625rem;
            font-size: 0.7rem;
        }
        .modern-stat-card {
            padding: 0.75rem;
        }
        .modern-stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        .modern-stat-content h4 {
            font-size: 1.125rem;
        }
        .modern-pagination-wrapper .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            min-width: 36px;
        }
        .modern-pagination-wrapper .pagination {
            gap: 0.25rem;
        }
        .pagination-info {
            font-size: 0.75rem;
        }

        /* Ultra compact filter layout */
        .card-body {
            padding: 1rem !important;
        }
        .form-label {
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
        }
        .modern-form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Smaller badges and buttons */
        .modern-badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.625rem;
        }
        .modern-btn.btn-sm {
            padding: 0.375rem 0.5rem;
            font-size: 0.625rem;
        }
    }

    /* Large screens optimization */
    @media (min-width: 1200px) {
        .modern-stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Modern Pagination */
    .modern-pagination-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
        margin: 2rem 0;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .dark-mode .modern-pagination-wrapper {
        background: rgba(45, 55, 72, 0.95);
        border-color: rgba(74, 85, 104, 0.3);
    }
    .modern-pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }
    .modern-pagination-wrapper .page-item {
        margin: 0;
        list-style: none;
    }
    .modern-pagination-wrapper .page-item.active .page-link {
        color: #ffffff;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        font-weight: 600;
    }
    .modern-pagination-wrapper .page-item.disabled .page-link {
        color: #9ca3af;
        pointer-events: none;
        background: rgba(248, 250, 252, 0.8);
        border-color: rgba(226, 232, 240, 0.8);
        opacity: 0.6;
        cursor: not-allowed;
    }
    .dark-mode .modern-pagination-wrapper .page-item.disabled .page-link {
        background: rgba(45, 55, 72, 0.8);
        border-color: rgba(74, 85, 104, 0.8);
        color: #6b7280;
    }
    .modern-pagination-wrapper .page-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #374151;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 44px;
        font-weight: 500;
        justify-content: center;
        backdrop-filter: blur(5px);
    }
    .dark-mode .modern-pagination-wrapper .page-link {
        background: rgba(45, 55, 72, 0.9);
        border-color: rgba(74, 85, 104, 0.8);
        color: #f7fafc;
    }
    .modern-pagination-wrapper .page-link:hover {
        color: #667eea;
        background: rgba(255, 255, 255, 1);
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }
    .dark-mode .modern-pagination-wrapper .page-link:hover {
        color: #667eea;
        background: rgba(45, 55, 72, 1);
        border-color: #667eea;
    }
    .pagination-info {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
        text-align: center;
    }
    .dark-mode .pagination-info {
        color: #9ca3af;
    }

    /* Chevron Icon Fixes */
    .fas.fa-chevron-down,
    .fas.fa-chevron-up {
        font-size: 0.875rem !important;
        transition: transform 0.3s ease;
    }
    .btn[data-bs-toggle="collapse"][aria-expanded="true"] .fas.fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Focus and accessibility */
    .modern-form-control:focus,
    .modern-btn:focus {
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
<div class="modern-audit-container">
    <!-- Modern Header -->
    <div class="modern-audit-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>
                        <i class="fas fa-eye"></i>
                        {{ __('audit-logs.header.title') }}
                    </h1>
                </div>
                <div class="col-lg-4">
                    <div class="modern-header-actions">
                        <a href="{{ route('admin.audit-logs.dashboard') }}" class="modern-btn modern-btn-info">
                            <i class="fas fa-chart-bar"></i>
                            <span class="mobile-text-full">{{ __('audit-logs.header.dashboard_btn') }}</span>
                        </a>
                        <button type="button" class="modern-btn modern-btn-success" onclick="exportLogs()">
                            <i class="fas fa-download"></i>
                            <span class="mobile-text-full">{{ __('audit-logs.header.export_btn') }}</span>
                        </button>
                        <button type="button" class="modern-btn modern-btn-warning" id="realTimeToggle">
                            <i class="fas fa-play"></i>
                            <span class="mobile-text-full">{{ __('audit-logs.header.realtime_btn') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Statistics Cards -->
    <div class="modern-stats-grid">
        <div class="modern-stat-card fade-in-up">
            <div class="modern-stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-list-alt"></i>
            </div>
            <div class="modern-stat-content">
                <h4>{{ number_format($stats['total_logs']) }}</h4>
                <div class="small">{{ __('audit-logs.stats.total_events') }}</div>
            </div>
        </div>

        <div class="modern-stat-card fade-in-up" style="animation-delay: 0.1s;">
            <div class="modern-stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="modern-stat-content">
                <h4>{{ number_format($stats['today_logs']) }}</h4>
                <div class="small">{{ __('audit-logs.stats.today') }}</div>
            </div>
        </div>

        <div class="modern-stat-card fade-in-up" style="animation-delay: 0.2s;">
            <div class="modern-stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="modern-stat-content">
                <h4>{{ number_format($stats['this_week_logs']) }}</h4>
                <div class="small">{{ __('audit-logs.stats.this_week') }}</div>
            </div>
        </div>

        <div class="modern-stat-card fade-in-up" style="animation-delay: 0.3s;">
            <div class="modern-stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="modern-stat-content">
                <h4>{{ number_format($stats['this_month_logs']) }}</h4>
                <div class="small">{{ __('audit-logs.stats.this_month') }}</div>
            </div>
        </div>
    </div>

    <!-- Modern Filters -->
    <div class="modern-audit-card">
        <div class="card-header" style="background: rgba(248, 250, 252, 0.8); border-bottom: 1px solid rgba(226, 232, 240, 0.5); padding: 1.5rem;">
            <h5 class="mb-0 d-flex align-items-center gap-2">
                <i class="fas fa-filter text-primary"></i>
                {{ __('audit-logs.filters.title') }}
                <button class="modern-btn modern-btn-secondary btn-sm ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">
                    <i class="fas fa-chevron-down" style="font-size: 0.75rem;"></i>
                    <span class="mobile-hide-text">{{ __('audit-logs.filters.toggle_btn') }}</span>
                </button>
            </h5>
        </div>
        <div class="collapse show" id="filtersCollapse">
            <div class="card-body" style="padding: 1.5rem;">
                <form method="GET" action="{{ route('admin.audit-logs.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-2 col-sm-6">
                            <label class="form-label fw-semibold">{{ __('audit-logs.filters.date_from') }}</label>
                            <input type="date" name="date_from" class="modern-form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="form-label fw-semibold">{{ __('audit-logs.filters.date_to') }}</label>
                            <input type="date" name="date_to" class="modern-form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="form-label fw-semibold">{{ __('audit-logs.filters.event_type') }}</label>
                            <select name="event" class="modern-form-control">
                                <option value="">{{ __('audit-logs.filters.all_events') }}</option>
                                @foreach($events as $event)
                                    <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                        {{ __('audit-logs.table.events.' . $event) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="form-label fw-semibold">{{ __('audit-logs.filters.model_type') }}</label>
                            <select name="model_type" class="modern-form-control">
                                <option value="">{{ __('audit-logs.filters.all_models') }}</option>
                                @foreach($modelTypes as $type)
                                    <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                        {{ class_basename($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="form-label fw-semibold">{{ __('audit-logs.filters.user') }}</label>
                            <select name="user_id" class="modern-form-control">
                                <option value="">{{ __('audit-logs.filters.all_users') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="form-label fw-semibold">{{ __('audit-logs.filters.search') }}</label>
                            <input type="text" name="search" class="modern-form-control" placeholder="{{ __('audit-logs.filters.search_placeholder') }}" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="modern-btn me-2">
                                <i class="fas fa-search"></i>
                                <span class="mobile-hide-text">{{ __('audit-logs.filters.apply_btn') }}</span>
                            </button>
                            <a href="{{ route('admin.audit-logs.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fas fa-times"></i>
                                <span class="mobile-hide-text">{{ __('audit-logs.filters.clear_btn') }}</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modern Audit Logs Table -->
    <div class="modern-audit-card">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: rgba(248, 250, 252, 0.8); border-bottom: 1px solid rgba(226, 232, 240, 0.5); padding: 1.5rem;">
            <h5 class="mb-0 d-flex align-items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                {{ __('audit-logs.table.title') }}
                <span class="modern-badge bg-secondary">{{ $auditLogs->total() }} {{ __('audit-logs.table.entries') }}</span>
            </h5>
            <div id="realTimeStatus" class="text-muted small" style="display: none;">
                <i class="fas fa-circle text-success blink"></i>
                <span class="mobile-hide-text">{{ __('audit-logs.table.live_monitoring') }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive modern-table-container">
                <table class="table modern-table" id="auditLogsTable">
                    <thead>
                        <tr>
                            <th>{{ __('audit-logs.table.columns.time') }}</th>
                            <th>{{ __('audit-logs.table.columns.user') }}</th>
                            <th>{{ __('audit-logs.table.columns.event') }}</th>
                            <th class="mobile-collapse">{{ __('audit-logs.table.columns.model') }}</th>
                            <th class="mobile-collapse">{{ __('audit-logs.table.columns.ip_address') }}</th>
                            <th>{{ __('audit-logs.table.columns.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr data-log-id="{{ $log->id }}">
                                <td>
                                    <span class="text-muted small">{{ $log->created_at->locale(app()->getLocale())->translatedFormat('M d, H:i:s') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $log->created_at->locale(app()->getLocale())->diffForHumans() }}</small>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div class="d-flex align-items-center user-info-mobile">
                                            @php $userImg = $log->user->image_url; @endphp
                                            @if($userImg)
                                                <img src="{{ asset($userImg) }}" alt="{{ $log->user->name }}" class="modern-avatar">
                                            @else
                                                <div class="modern-avatar bg-primary">
                                                    {{ substr($log->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $log->user->name }}</div>
                                                <small class="text-muted">{{ ucfirst($log->user->role) }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ __('audit-logs.table.system') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $eventColors = [
                                            'created' => 'success',
                                            'updated' => 'warning',
                                            'deleted' => 'danger',
                                            'restored' => 'info'
                                        ];
                                        $color = $eventColors[$log->event] ?? 'secondary';
                                    @endphp
                                    <span class="modern-badge bg-{{ $color }}">
                                        <i class="fas fa-{{ $log->event == 'created' ? 'plus' : ($log->event == 'updated' ? 'edit' : ($log->event == 'deleted' ? 'trash' : 'undo')) }}"></i>
                                        <span class="mobile-hide-text">{{ __('audit-logs.table.events.' . $log->event) }}</span>
                                    </span>
                                </td>
                                <td class="mobile-collapse">
                                    <div>
                                        <span class="fw-bold">{{ class_basename($log->auditable_type) }}</span>
                                        <small class="text-muted d-block">ID: {{ $log->auditable_id }}</small>
                                    </div>
                                </td>
                                <td class="mobile-collapse">
                                    <span class="font-monospace small">{{ $log->ip_address ?: __('audit-logs.table.z`na') }}</span>
                                    @if($log->url)
                                        <br><small class="text-muted">{{ Str::limit($log->url, 30) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.audit-logs.show', $log) }}" class="modern-btn btn-sm">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-search fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">{{ __('audit-logs.table.empty_state') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($auditLogs->hasPages())
            <div class="modern-pagination-wrapper">
                <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
                    {{-- Previous Page Link --}}
                    @if ($auditLogs->onFirstPage())
                        <span class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-{{ app()->getLocale() === 'ar' ? 'chevron-right' : 'chevron-left' }}"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $auditLogs->previousPageUrl() }}" class="page-item">
                            <span class="page-link">
                                <i class="fas fa-{{ app()->getLocale() === 'ar' ? 'chevron-right' : 'chevron-left' }}"></i>
                            </span>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = max($auditLogs->currentPage() - 2, 1);
                        $end = min($start + 4, $auditLogs->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    {{-- First page link --}}
                    @if($start > 1)
                        <a href="{{ $auditLogs->url(1) }}" class="page-item">
                            <span class="page-link">1</span>
                        </a>
                        @if($start > 2)
                            <span class="page-item disabled">
                                <span class="page-link">...</span>
                            </span>
                        @endif
                    @endif

                    {{-- Page links --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $auditLogs->currentPage())
                            <span class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $auditLogs->url($page) }}" class="page-item">
                                <span class="page-link">{{ $page }}</span>
                            </a>
                        @endif
                    @endfor

                    {{-- Last page link --}}
                    @if($end < $auditLogs->lastPage())
                        @if($end < $auditLogs->lastPage() - 1)
                            <span class="page-item disabled">
                                <span class="page-link">...</span>
                            </span>
                        @endif
                        <a href="{{ $auditLogs->url($auditLogs->lastPage()) }}" class="page-item">
                            <span class="page-link">{{ $auditLogs->lastPage() }}</span>
                        </a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($auditLogs->hasMorePages())
                        <a href="{{ $auditLogs->nextPageUrl() }}" class="page-item">
                            <span class="page-link">
                                <i class="fas fa-{{ app()->getLocale() === 'ar' ? 'chevron-left' : 'chevron-right' }}"></i>
                            </span>
                        </a>
                    @else
                        <span class="page-item disabled">
                            <span class="page-link">
                                <i class="fas fa-{{ app()->getLocale() === 'ar' ? 'chevron-left' : 'chevron-right' }}"></i>
                            </span>
                        </span>
                    @endif
                </nav>

                <div class="pagination-info">
                    {{ __('audit-logs.pagination.showing_results', ['first' => $auditLogs->firstItem(), 'last' => $auditLogs->lastItem(), 'total' => $auditLogs->total()]) }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Changes Modal -->
<div class="modal fade" id="changesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title">Change Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="changesContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
let realTimeEnabled = false;
let lastLogId = 0;
let realTimeInterval;

// Initialize last log ID
@if($auditLogs->count() > 0)
lastLogId = {{ $auditLogs->first()->id }};
@endif

document.getElementById('realTimeToggle').addEventListener('click', function() {
    realTimeEnabled = !realTimeEnabled;

    if (realTimeEnabled) {
        this.innerHTML = '<i class="fas fa-pause"></i> <span class="mobile-hide-text">Stop Real-time</span>';
        this.className = 'modern-btn modern-btn-danger';
        document.getElementById('realTimeStatus').style.display = 'block';
        startRealTimeMonitoring();
    } else {
        this.innerHTML = '<i class="fas fa-play"></i> <span class="mobile-hide-text">Real-time</span>';
        this.className = 'modern-btn modern-btn-warning';
        document.getElementById('realTimeStatus').style.display = 'none';
        stopRealTimeMonitoring();
    }
});

function startRealTimeMonitoring() {
    realTimeInterval = setInterval(fetchNewLogs, 3000);
}

function stopRealTimeMonitoring() {
    if (realTimeInterval) {
        clearInterval(realTimeInterval);
    }
}

function fetchNewLogs() {
    fetch(`{{ route('admin.audit-logs.realtime') }}?last_id=${lastLogId}`)
        .then(response => response.json())
        .then(data => {
            if (data.logs && data.logs.length > 0) {
                data.logs.forEach(log => {
                    addLogToTable(log);
                });
                lastLogId = data.last_id;
            }
        })
        .catch(error => {
            console.error('Error fetching real-time logs:', error);
        });
}

function addLogToTable(log) {
    const tbody = document.querySelector('#auditLogsTable tbody');
    const row = document.createElement('tr');
    row.className = 'table-warning';
    row.setAttribute('data-log-id', log.id);

    const eventColors = {
        'created': 'success',
        'updated': 'warning',
        'deleted': 'danger',
        'restored': 'info'
    };
    const color = eventColors[log.event] || 'secondary';

    const eventIcons = {
        'created': 'plus',
        'updated': 'edit',
        'deleted': 'trash',
        'restored': 'undo'
    };
    const icon = eventIcons[log.event] || 'question';

    row.innerHTML = `
        <td>
            <span class="text-muted small">${new Date(log.created_at).toLocaleString()}</span>
            <br>
            <small class="text-muted">Just now</small>
        </td>
        <td>
            ${log.user ? `
                <div class="d-flex align-items-center user-info-mobile">
                    <div class="modern-avatar bg-primary">
                        ${log.user.name.charAt(0)}
                    </div>
                    <div>
                        <div class="fw-bold">${log.user.name}</div>
                        <small class="text-muted">${log.user.role}</small>
                    </div>
                </div>
            ` : '<span class="text-muted">System</span>'}
        </td>
        <td>
            <span class="modern-badge bg-${color}">
                <i class="fas fa-${icon}"></i>
                <span class="mobile-hide-text">${log.event.charAt(0).toUpperCase() + log.event.slice(1)}</span>
            </span>
        </td>
        <td class="mobile-collapse">
            <div>
                <span class="fw-bold">${log.auditable_type.split('\\').pop()}</span>
                <small class="text-muted d-block">ID: ${log.auditable_id}</small>
            </div>
        </td>
        <td class="mobile-collapse">
            <span class="font-monospace small">${log.ip_address || 'N/A'}</span>
            ${log.url ? `<br><small class="text-muted">${log.url.substring(0, 30)}</small>` : ''}
        </td>
        <td class="mobile-collapse">
            ${log.new_values ? `
                <button class="modern-btn btn-sm" onclick="showChanges(${JSON.stringify(log.old_values)}, ${JSON.stringify(log.new_values)}, '${log.event}')">
                    <i class="fas fa-eye"></i>
                    <span class="mobile-hide-text">View Changes</span>
                </button>
            ` : '<span class="text-muted">No changes</span>'}
        </td>
        <td>
            <a href="/admin/audit-logs/${log.id}" class="modern-btn btn-sm">
                <i class="fas fa-search"></i>
            </a>
        </td>
    `;

    tbody.insertBefore(row, tbody.firstChild);

    setTimeout(() => {
        row.classList.remove('table-warning');
    }, 5000);
}

function showChanges(oldValues, newValues, event) {
    let content = '';

    if (event === 'created') {
        content = '<h6>New Record Created:</h6>';
        content += '<div class="row"><div class="col-12">';
        content += '<h6 class="text-success">New Values:</h6>';
        content += '<pre class="bg-light p-3 rounded" style="border-radius: 12px;">' + JSON.stringify(newValues, null, 2) + '</pre>';
        content += '</div></div>';
    } else if (event === 'updated') {
        content = '<h6>Record Updated:</h6>';
        content += '<div class="row">';
        content += '<div class="col-md-6">';
        content += '<h6 class="text-danger">Old Values:</h6>';
        content += '<pre class="bg-light p-3 rounded" style="border-radius: 12px;">' + JSON.stringify(oldValues, null, 2) + '</pre>';
        content += '</div>';
        content += '<div class="col-md-6">';
        content += '<h6 class="text-success">New Values:</h6>';
        content += '<pre class="bg-light p-3 rounded" style="border-radius: 12px;">' + JSON.stringify(newValues, null, 2) + '</pre>';
        content += '</div>';
        content += '</div>';
    } else if (event === 'deleted') {
        content = '<h6>Record Deleted:</h6>';
        content += '<div class="row"><div class="col-12">';
        content += '<h6 class="text-danger">Deleted Values:</h6>';
        content += '<pre class="bg-light p-3 rounded" style="border-radius: 12px;">' + JSON.stringify(oldValues, null, 2) + '</pre>';
        content += '</div></div>';
    }

    document.getElementById('changesContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('changesModal')).show();
}

function exportLogs() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    window.open(`{{ route('admin.audit-logs.export') }}?${params.toString()}`, '_blank');
}

// Auto-submit form on filter change
document.querySelectorAll('#filterForm select, #filterForm input[type="date"]').forEach(element => {
    element.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});

// Add loading states
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to table rows
    document.querySelectorAll('#auditLogsTable tbody tr').forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
@endsection
