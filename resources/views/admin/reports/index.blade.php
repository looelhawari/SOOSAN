@extends('layouts.admin')

@section('title', __('reports.financial_reports'))

@push('styles')
<style>
    /* Reset and Base Styles */
    .modern-reports-container * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    .modern-reports-container {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding: 1rem;
        color: #1a202c;
        line-height: 1.6;
    }
    .dark-mode .modern-reports-container {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        color: #f7fafc;
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
    .modern-page-header h1 {
        font-weight: 700;
        font-size: clamp(1.5rem, 4vw, 2rem);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .modern-page-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    .header-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Date Filter Card */
    .date-filter-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .dark-mode .date-filter-card {
        background: rgba(45, 55, 72, 0.95);
        border-color: rgba(74, 85, 104, 0.3);
    }
    .date-filter-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .date-filter-card h5 {
        color: #1a202c;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .dark-mode .date-filter-card h5 {
        color: #f7fafc;
    }

    /* Filter Options */
    .filter-option {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin: 0.5rem 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        backdrop-filter: blur(5px);
        position: relative;
        overflow: hidden;
        margin-right: 20px;
    }
    .dark-mode .filter-option {
        background: rgba(45, 55, 72, 0.9);
        border-color: #4a5568;
        color: #f7fafc;
    }
    .filter-option::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transition: left 0.5s;
    }
    .filter-option:hover::before {
        left: 100%;
    }
    .filter-option:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }
    .dark-mode .filter-option:hover {
        background: rgba(102, 126, 234, 0.1);
        border-color: #667eea;
    }
    .filter-option.active {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    .filter-option span {
        font-weight: 600;
        font-size: 0.875rem;
    }
    .filter-option i {
        font-size: 1.125rem;
        transition: transform 0.3s ease;
    }
    .filter-option:hover i {
        transform: scale(1.1);
    }

    /* Custom Date Inputs */
    .custom-date-inputs {
        display: none;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        animation: fadeInUp 0.3s ease;
    }
    .dark-mode .custom-date-inputs {
        border-top-color: rgba(74, 85, 104, 0.8);
    }
    .custom-date-inputs.active {
        display: block;
    }
    .custom-date-inputs label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }
    .dark-mode .custom-date-inputs label {
        color: #f7fafc;
    }
    .custom-date-inputs .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(5px);
        margin-right: 20px;
        width: 90%;
    }
    .dark-mode .custom-date-inputs .form-control {
        background: rgba(45, 55, 72, 0.9);
        border-color: #4a5568;
        color: #f7fafc;
    }
    .custom-date-inputs .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
        background: rgba(255, 255, 255, 1);
    }
    .dark-mode .custom-date-inputs .form-control:focus {
        background: rgba(45, 55, 72, 1);
    }

    /* Report Cards */
    .report-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(20px);
        width: 95%;
    }
    .dark-mode .report-card {
        background: rgba(45, 55, 72, 0.95);
        border-color: rgba(74, 85, 104, 0.3);
    }
    .report-card:nth-child(1) { animation-delay: 0.1s; }
    .report-card:nth-child(2) { animation-delay: 0.2s; }
    .report-card:nth-child(3) { animation-delay: 0.3s; }
    .report-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--report-color, #667eea) 0%, var(--report-color-secondary, #764ba2) 100%);
        z-index: 1;
    }
    .report-card.comprehensive {
        --report-color: #667eea;
        --report-color-secondary: #764ba2;
    }
    .report-card.owners {
        --report-color: #48bb78;
        --report-color-secondary: #38a169;
    }
    .report-card.sales {
        --report-color: #ed8936;
        --report-color-secondary: #dd6b20;
    }
    .report-card.warranty {
        --report-color: #dc3545;
        --report-color-secondary: #c82333;
    }

    /* Report Icon */
    .report-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--report-color) 0%, var(--report-color-secondary) 100%);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .report-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .report-card:hover .report-icon::before {
        left: 100%;
    }
    .report-card:hover .report-icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* Report Content */
    .report-card h4 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1rem;
        line-height: 1.4;
    }
    .dark-mode .report-card h4 {
        color: #f7fafc;
    }
    .report-card p {
        color: #6b7280;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        line-height: 1.6;
    }
    .dark-mode .report-card p {
        color: #9ca3af;
    }

    /* Feature List */
    .feature-list {
        list-style: none;
        padding: 0;
        margin: 1rem 0 1.5rem;
    }
    .feature-list li {
        padding: 0.5rem 0;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    .dark-mode .feature-list li {
        color: #9ca3af;
    }
    .feature-list li:hover {
        color: var(--report-color);
        transform: translateX(4px);
    }
    .feature-list li:before {
        content: '✓';
        color: var(--report-color);
        font-weight: bold;
        font-size: 1.1rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: rgba(var(--report-color-rgb, 102, 126, 234), 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .feature-list li:hover:before {
        background: var(--report-color);
        color: white;
        transform: scale(1.1);
    }

    /* Stats Preview */
    .stats-preview {
        background: rgba(248, 250, 252, 0.8);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border: 1px solid rgba(226, 232, 240, 0.5);
        transition: all 0.3s ease;
    }
    .dark-mode .stats-preview {
        background: rgba(45, 55, 72, 0.8);
        border-color: rgba(74, 85, 104, 0.5);
    }
    .stats-preview:hover {
        background: rgba(248, 250, 252, 1);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .dark-mode .stats-preview:hover {
        background: rgba(45, 55, 72, 1);
    }
    .stat-item {
        text-align: center;
        transition: all 0.3s ease;
    }
    .stat-item:hover {
        transform: scale(1.05);
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--report-color);
        margin-bottom: 0.5rem;
        line-height: 1;
        transition: all 0.3s ease;
    }
    .stat-item:hover .stat-value {
        transform: scale(1.1);
    }
    .stat-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .dark-mode .stat-label {
        color: #9ca3af;
    }

    /* Download Button */
    .download-btn {
        background: linear-gradient(135deg, var(--report-color) 0%, var(--report-color-secondary) 100%);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .download-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .download-btn:hover::before {
        left: 100%;
    }
    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        color: white;
        text-decoration: none;
    }
    .download-btn i {
        transition: transform 0.3s ease;
    }
    .download-btn:hover i {
        transform: scale(1.1);
    }

    /* Information Alert */
    .modern-info-alert {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(102, 126, 234, 0.2);
        border-radius: 16px;
        padding: 2rem;
        margin-top: 2rem;
        transition: all 0.3s ease;
    }
    .dark-mode .modern-info-alert {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        border-color: rgba(102, 126, 234, 0.3);
    }
    .modern-info-alert:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }
    .modern-info-alert .alert-icon {
        color: #667eea;
        font-size: 2rem;
        margin-right: 1rem;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    .modern-info-alert:hover .alert-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .modern-info-alert h5 {
        color: #1a202c;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }
    .dark-mode .modern-info-alert h5 {
        color: #f7fafc;
    }
    .modern-info-alert p {
        color: #4a5568;
        margin-bottom: 1rem;
    }
    .dark-mode .modern-info-alert p {
        color: #a0aec0;
    }
    .modern-info-alert ul {
        color: #4a5568;
        margin-bottom: 0;
    }
    .dark-mode .modern-info-alert ul {
        color: #a0aec0;
    }
    .modern-info-alert li {
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    .modern-info-alert li:hover {
        color: #667eea;
        transform: translateX(4px);
    }

    /* Loading Modal */
    .modern-loading-modal .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
    .dark-mode .modern-loading-modal .modal-content {
        background: rgba(45, 55, 72, 0.95);
    }
    .modern-loading-modal .spinner-border {
        width: 3rem;
        height: 3rem;
        border-width: 0.3em;
        color: #667eea;
    }
    .modern-loading-modal h5 {
        color: #1a202c;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .dark-mode .modern-loading-modal h5 {
        color: #f7fafc;
    }
    .modern-loading-modal p {
        color: #6b7280;
        margin-bottom: 0;
    }
    .dark-mode .modern-loading-modal p {
        color: #9ca3af;
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

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .modern-reports-container {
            padding: 0.75rem;
        }
        .modern-page-header {
            margin: -0.75rem -0.75rem 1.5rem;
            padding: 1.5rem 1rem;
        }
        .date-filter-card {
            padding: 1.5rem;
        }
        .filter-option {
            padding: 0.875rem 1rem;
        }
    }

    @media (max-width: 768px) {
        .modern-page-header h1 {
            font-size: 1.25rem;
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
        .modern-page-header .d-flex {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        .date-filter-card {
            padding: 1rem;
        }
        .date-filter-card h5 {
            font-size: 1rem;
            text-align: center;
        }
        .filter-option {
            padding: 0.75rem;
            font-size: 0.875rem;
        }
        .filter-option span {
            font-size: 0.75rem;
        }
        .filter-option i {
            font-size: 1rem;
        }
        .report-card .card-body {
            padding: 1.5rem;
        }
        .report-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
        .report-card h4 {
            font-size: 1.125rem;
        }
        .feature-list li {
            font-size: 0.75rem;
            padding: 0.375rem 0;
        }
        .stat-value {
            font-size: 1.5rem;
        }
        .stat-label {
            font-size: 0.75rem;
        }
        .download-btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
        }
        .modern-info-alert {
            padding: 1.5rem;
        }
        .modern-info-alert .alert-icon {
            font-size: 1.5rem;
        }
        .modern-info-alert h5 {
            font-size: 1rem;
        }
        .modern-info-alert p,
        .modern-info-alert li {
            font-size: 0.875rem;
        }

        /* Mobile text/icon switching */
        .mobile-text {
            display: none;
        }
        .mobile-icon {
            display: inline;
        }
    }

    @media (max-width: 576px) {
        .modern-page-header {
            padding: 1rem 0.75rem;
        }
        .modern-page-header h1 {
            font-size: 1.125rem;
        }
        .date-filter-card {
            padding: 0.75rem;
        }
        .filter-option {
            padding: 0.625rem;
            margin: 0.25rem 0;
        }
        .report-card .card-body {
            padding: 1rem;
        }
        .report-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .stats-preview {
            padding: 1rem;
        }
        .stat-value {
            font-size: 1.25rem;
        }
        .download-btn {
            padding: 0.625rem 1rem;
        }
        .modern-info-alert {
            padding: 1rem;
        }
        .modern-info-alert .d-flex {
            flex-direction: column;
            text-align: center;
        }
        .modern-info-alert .alert-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }

    /* Large screens optimization */
    @media (min-width: 1200px) {
        .modern-reports-container {
            padding: 1.5rem;
        }
        .modern-page-header {
            margin: -1.5rem -1.5rem 2rem;
        }
    }

    /* Focus and accessibility */
    .filter-option:focus,
    .download-btn:focus,
    .custom-date-inputs .form-control:focus {
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
<div class="modern-reports-container">
    <!-- Page Header -->
    <div class="modern-page-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1>
                        <i class="fas fa-chart-line"></i>
                        <span class="mobile-text">{{ __('reports.financial_reports') }}</span>
                        <span class="mobile-icon d-none">Reports</span>
                    </h1>
                    <p class="mobile-text">{{ __('reports.comprehensive_analytics_description') }}</p>
                    <p class="mobile-icon d-none">Analytics & Insights</p>
                </div>
                <div class="text-end">
                    <span class="header-badge">
                        <i class="fas fa-shield-alt me-1"></i>
                        <span class="mobile-text">{{ __('reports.admin_only') }}</span>
                        <span class="mobile-icon d-none">Admin</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Filter Section -->
    <div class="date-filter-card">
        <h5>
            <i class="fas fa-calendar-alt text-primary me-2"></i>
            {{ __('reports.select_time_period') }}
        </h5>
        <div class="row g-3" id="dateFilterOptions">
            <div class="col-lg-4 col-md-6">
                <div class="filter-option active" data-period="last_30_days">
                    <span>{{ __('reports.last_30_days') }}</span>
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="filter-option" data-period="last_90_days">
                    <span>{{ __('reports.last_90_days') }}</span>
                    <i class="fas fa-calendar-week"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="filter-option" data-period="this_year">
                    <span>{{ __('reports.this_year') }}</span>
                    <i class="fas fa-calendar-year"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="filter-option" data-period="last_year">
                    <span>{{ __('reports.last_year') }}</span>
                    <i class="fas fa-history"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="filter-option" data-period="last_7_days">
                    <span>{{ __('reports.last_7_days') }}</span>
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="filter-option" data-period="custom">
                    <span>{{ __('reports.custom_range') }}</span>
                    <i class="fas fa-calendar-plus"></i>
                </div>
            </div>
        </div>

        <div class="custom-date-inputs" id="customDateInputs">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fas fa-calendar-day me-1"></i>
                        {{ __('reports.start_date') }}
                    </label>
                    <input type="date" class="form-control" id="startDate" value="{{ now()->subDays(30)->format('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fas fa-calendar-check me-1"></i>
                        {{ __('reports.end_date') }}
                    </label>
                    <input type="date" class="form-control" id="endDate" value="{{ now()->format('Y-m-d') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Grid -->
    <div class="row g-4">
        <!-- Comprehensive Report -->
        <!-- <div class="col-lg-4 col-md-6">
            <div class="report-card comprehensive">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <h4>{{ __('reports.comprehensive_report') }}</h4>
                    <p>{{ __('reports.comprehensive_description') }}</p>

                    <ul class="feature-list">
                        <li>{{ __('reports.financial_overview') }}</li>
                        <li>{{ __('reports.sales_analytics') }}</li>
                        <li>{{ __('reports.staff_performance') }}</li>
                        <li>{{ __('reports.growth_metrics') }}</li>
                        <li>{{ __('reports.regional_analysis') }}</li>
                        <li>{{ __('reports.trend_forecasting') }}</li>
                    </ul>

                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">${{ number_format($stats['comprehensive']['revenue'], 2) }}</div>
                                    <div class="stat-label">{{ __('reports.revenue_preview') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['comprehensive']['sales']) }}</div>
                                    <div class="stat-label">{{ __('reports.sales_preview') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="download-btn comprehensive-btn" onclick="downloadReport('comprehensive')">
                        <i class="fas fa-download"></i>
                        <span class="mobile-text">{{ __('reports.download_comprehensive') }}</span>
                        <span class="mobile-icon d-none">Download</span>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Owners Report -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card owners">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <h4>{{ __('reports.owners_report') }}</h4>
                    <p>{{ __('reports.owners_description') }}</p>

                    <ul class="feature-list">
                        <li>{{ __('reports.customer_demographics') }}</li>
                        <li>{{ __('reports.geographic_distribution') }}</li>
                        <li>{{ __('reports.purchase_behavior') }}</li>
                        <li>{{ __('reports.customer_lifetime_value') }}</li>
                        <li>{{ __('reports.acquisition_trends') }}</li>
                        <li>{{ __('reports.top_customers') }}</li>
                    </ul>

                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['owners']['total_owners']) }}</div>
                                    <div class="stat-label">{{ __('reports.total_owners') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['owners']['countries']) }}</div>
                                    <div class="stat-label">{{ __('reports.countries') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="download-btn owners-btn" style="background:#fff;color:#48bb78;border:1px solid #48bb78" onclick="downloadOwnersReportPDF()">
                        <i class="fas fa-file-pdf"></i>
                        <span class="mobile-text">Download as PDF (jsPDF)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sales Report -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card sales">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>

                    <h4>{{ __('reports.sales_report') }}</h4>
                    <p>{{ __('reports.sales_description') }}</p>

                    <ul class="feature-list">
                        <li>{{ __('reports.product_performance') }}</li>
                        <li>{{ __('reports.sales_by_period') }}</li>
                        <li>{{ __('reports.staff_sales_metrics') }}</li>
                        <li>{{ __('reports.inventory_turnover') }}</li>
                        <li>{{ __('reports.profit_margins') }}</li>
                        <li>{{ __('reports.recent_transactions') }}</li>
                    </ul>

                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['sales']['products_sold']) }}</div>
                                    <div class="stat-label">{{ __('reports.products_sold') }}</div>
                                </div>
                            </div>
                            <!-- <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">${{ number_format($stats['sales']['avg_sale'], 2) }}</div>
                                    <div class="stat-label">{{ __('reports.avg_sale') }}</div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <button class="download-btn sales-btn" style="background:#fff;color:#ed8936;border:1px solid #ed8936" onclick="downloadSalesReportPDF()">
                        <i class="fas fa-file-pdf"></i>
                        <span class="mobile-text">Download as PDF (jsPDF)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Warranty Report -->
        <div class="col-lg-4 col-md-6">
            <div class="report-card warranty">
                <div class="card-body p-4">
                    <div class="report-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <h4>{{ __('reports.warranty_coverage_report') }}</h4>
                    <p>{{ __('reports.warranty_description') }}</p>

                    <ul class="feature-list">
                        <li>{{ __('reports.active_warranty_coverage') }}</li>
                        <li>{{ __('reports.days_remaining_expiration') }}</li>
                        <li>{{ __('reports.product_model_breakdown') }}</li>
                        <li>{{ __('reports.owner_warranty_tracking') }}</li>
                        <li>{{ __('reports.expiration_notifications') }}</li>
                        <li>{{ __('reports.coverage_analytics') }}</li>
                    </ul>

                    <div class="stats-preview">
                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['warranty']['under_warranty'] ?? 0) }}</div>
                                    <div class="stat-label">{{ __('reports.under_warranty') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-value">{{ number_format($stats['warranty']['expired'] ?? 0) }}</div>
                                    <div class="stat-label">{{ __('reports.expired_warranties') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="download-btn warranty-btn" style="background:#dc3545;color:#fff" onclick="downloadWarrantyReportPDF()">
                        <i class="fas fa-file-pdf"></i>
                        <span class="mobile-text">{{ __('reports.download_warranty') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <!-- <div class="modern-info-alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-info-circle alert-icon"></i>
            <div>
                <h5>{{ __('reports.important_information') }}</h5>
                <p>{{ __('reports.report_generation_info') }}</p>
                <ul>
                    <li>{{ __('reports.pdf_format_info') }}</li>
                    <li>{{ __('reports.charts_included_info') }}</li>
                    <li>{{ __('reports.executive_summary_info') }}</li>
                    <li>{{ __('reports.confidential_data_info') }}</li>
                </ul>
            </div>
        </div>
    </div> -->
</div>

<!-- Loading Modal -->
<div class="modal fade modern-loading-modal" id="loadingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="spinner-border mb-3" role="status">
                    <span class="visually-hidden">{{ __('reports.generating') }}</span>
                </div>
                <h5>{{ __('reports.generating_report') }}</h5>
                <p>{{ __('reports.please_wait_message') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@if (isset($comprehensiveData) && isset($comprehensiveDateRange))
<script id="comprehensive-report-data" type="application/json">
@json(['data' => $comprehensiveData, 'dateRange' => $comprehensiveDateRange])
</script>
@endif

@push('scripts')
<!-- jsPDF CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- jsPDF autoTable plugin for table support -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for all scripts to load before enabling PDF functionality
    window.addEventListener('load', function() {
        // Check if jsPDF is available
        if (typeof window.jspdf !== 'undefined') {
            console.log('jsPDF loaded successfully');
        } else {
            console.error('jsPDF failed to load');
        }
    });

    // Date filter functionality
    const filterOptions = document.querySelectorAll('.filter-option');
    const customDateInputs = document.getElementById('customDateInputs');
    let selectedPeriod = 'last_30_days';

    filterOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            filterOptions.forEach(opt => opt.classList.remove('active'));

            // Add active class to clicked option
            this.classList.add('active');

            // Get selected period
            selectedPeriod = this.dataset.period;

            // Show/hide custom date inputs with animation
            if (selectedPeriod === 'custom') {
                customDateInputs.classList.add('active');
            } else {
                customDateInputs.classList.remove('active');
            }
        });
    });

    // Add loading animations to cards
    const reportCards = document.querySelectorAll('.report-card');
    reportCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100 + 300);
    });

    // Enhanced hover effects for feature lists
    const featureItems = document.querySelectorAll('.feature-list li');
    featureItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Smooth scroll for mobile
    if (window.innerWidth <= 768) {
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function() {
                setTimeout(() => {
                    this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            });
        });
    }
});

function downloadReport(reportType) {
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();

    // Add loading animation to the clicked button
    const button = document.querySelector(`.${reportType}-btn`);
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span class="mobile-text">Generating...</span><span class="mobile-icon d-none">Loading</span>';
    button.disabled = true;

    // Get selected period
    const selectedPeriod = document.querySelector('.filter-option.active').dataset.period;

    // Build URL with parameters
    let url = `/admin/reports/${reportType}?period=${selectedPeriod}`;

    // Add custom dates if selected
    if (selectedPeriod === 'custom') {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        url += `&start_date=${startDate}&end_date=${endDate}`;
    }

    // Create a temporary link to trigger download
    const link = document.createElement('a');
    link.href = url;
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    // Hide loading modal and restore button after a delay
    setTimeout(() => {
        loadingModal.hide();
        button.innerHTML = originalContent;
        button.disabled = false;
    }, 2000);
}


// jsPDF Download Button Logic
window.downloadReportPDF = function(reportType) {
    // Gather report data from DOM (for demo, just use visible stats and features)
    let title = '';
    let period = document.querySelector('.filter-option.active span')?.innerText || '';
    let generatedAt = new Date().toLocaleString();
    let filename = reportType + '-report.pdf';
    let sections = [];
    let card = document.querySelector('.report-card.' + reportType);
    if (!card) return alert('Report card not found!');
    title = card.querySelector('h4')?.innerText || 'Report';
    // Features
    let features = Array.from(card.querySelectorAll('.feature-list li')).map(li => [li.innerText]);
    if (features.length) {
        sections.push({ title: 'Features', rows: features });
    }
    // Stats
    let stats = Array.from(card.querySelectorAll('.stat-item')).map(item => [
        item.querySelector('.stat-label')?.innerText || '',
        item.querySelector('.stat-value')?.innerText || ''
    ]);
    if (stats.length) {
        sections.push({ title: 'Stats', rows: stats });
    }
    // Call jsPDF logic
    if (window.generateReportPDF) {
        window.generateReportPDF(null, { title, period, generatedAt, filename, sections });
    } else {
        alert('jsPDF not loaded!');
    }
}

// Enhanced Sales Report PDF function with Comprehensive Analysis
window.downloadSalesReportPDF = function() {
    try {
        // Check if jsPDF is loaded
        if (typeof window.jspdf === 'undefined') {
            alert('jsPDF library is not loaded. Please refresh the page and try again.');
            return;
        }

        console.log('Starting Sales PDF generation...');

        // Test basic PDF creation first
        const { jsPDF } = window.jspdf;
        const testDoc = new jsPDF();
        testDoc.text('Test PDF', 20, 20);

        // If this works, we know jsPDF is functioning
        console.log('jsPDF basic test successful');

        const doc = new jsPDF('l', 'pt', 'a4'); // Landscape mode for better table fit
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();

        // Clean Header with SoosanEgypt Branding
        doc.setFillColor(237, 137, 54); // Sales orange background
        doc.rect(0, 0, pageWidth, 120); // Header height

        // Company branding
        doc.setFontSize(32);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(255, 255, 255);
        doc.text('SoosanEgypt', 40, 40);

        doc.setFontSize(24);
        doc.setFont('helvetica', 'bold');
        doc.text('Comprehensive Sales Performance Report', 40, 70);

        // Enhanced date and branding
        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.text('Generated on: ' + new Date().toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }), 40, 95);

        // Load transparent logo and continue with PDF generation
        const logoImg = new Image();
        logoImg.crossOrigin = 'anonymous';

        let logoLoaded = false;
        const logoTimeout = setTimeout(() => {
            if (!logoLoaded) {
                console.log('Logo timeout, continuing without logo');
                continueWithPDFGeneration();
            }
        }, 3000);

        logoImg.onload = function() {
            logoLoaded = true;
            clearTimeout(logoTimeout);
            try {
                // Add transparent logo to top right corner
                doc.addImage(logoImg, 'PNG', pageWidth - 180, 10, 130, 60);
                console.log('Logo added successfully');
            } catch (e) {
                console.log('Logo loading failed:', e);
            }
            continueWithPDFGeneration();
        };

        logoImg.onerror = function() {
            logoLoaded = true;
            clearTimeout(logoTimeout);
            console.log('Logo failed to load, continuing without logo');
            continueWithPDFGeneration();
        };

        logoImg.src = '/images/logo2.png';

        function continueWithPDFGeneration() {
            let y = 140; // Start content after header

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
            }

            // Get selected time period for filtering
            const selectedPeriod = document.querySelector('.filter-option.active').dataset.period;
            let url = `/admin/reports/sales-data?period=${selectedPeriod}`;

            console.log('Fetching data from:', url);
            console.log('Selected period:', selectedPeriod);

            // Add custom date range if selected
            if (selectedPeriod === 'custom') {
                const startDate = document.getElementById('customStartDate').value;
                const endDate = document.getElementById('customEndDate').value;
                if (startDate && endDate) {
                    url += `&start_date=${startDate}&end_date=${endDate}`;
                }
            }

            // Fetch real sales data from the server with time filtering
            fetch(url, {
                method: 'GET',
                headers: headers
            }).then(response => {
                console.log('Response received:', response.status);
                if (!response.ok) {
                    throw new Error(`Failed to fetch sales data: ${response.status} - ${response.statusText}`);
                }
                return response.json();
            }).then(data => {
                try {
                    console.log('Sales data received:', data);

                    // Check if data is valid
                    if (!data || typeof data !== 'object') {
                        throw new Error('Invalid data received from server');
                    }

                    // Executive Summary
                doc.setFontSize(16);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(237, 137, 54);
                doc.text('EXECUTIVE SUMMARY', 40, y);
                y += 30;

                // Summary stats
                const summary = data.summary || {};
                doc.setFontSize(11);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(60, 60, 60);

                doc.text(`Total Sales: ${(Number(summary.total_sales) || 0).toLocaleString()} transactions`, 40, y);
                doc.text(`Total Revenue: $${(Number(summary.total_revenue) || 0).toLocaleString()}`, 300, y);
                y += 20;
                doc.text(`Total Units Sold: ${(Number(summary.total_quantity) || 0).toLocaleString()} units`, 40, y);
                doc.text(`Report Period: ${summary.period_label || 'N/A'}`, 300, y);
                y += 40;

                // ALL SOLD PRODUCTS TABLE - Most important section
                const allProducts = data.all_sold_products || [];
                console.log(`Found ${allProducts.length} products`);

                if (allProducts.length > 0) {
                    doc.setFontSize(16);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(237, 137, 54);
                    doc.text('ALL SOLD PRODUCTS', 40, y);
                    y += 30;

                    const allProductsData = [];
                    allProducts.forEach(product => {
                        allProductsData.push([
                            product.model_name || 'N/A',
                            product.serial_number || 'N/A',
                            product.quantity || 1,
                            product.purchase_date || 'N/A',
                            product.owner_name || 'N/A',
                            product.warranty_status || 'N/A',
                            `$${(Number(product.purchase_price) || 0).toFixed(2)}`, // Unit price
                            `$${(Number(product.total_price) || 0).toFixed(2)}` // Total price
                        ]);
                    });

                    doc.autoTable({
                        startY: y,
                        head: [['Model Name', 'Serial Number', 'Qty', 'Purchase Date', 'Owner', 'Status', 'Unit Price', 'Total Price']],
                        body: allProductsData,
                        theme: 'striped',
                        headStyles: {
                            fillColor: [237, 137, 54],
                            textColor: [255, 255, 255],
                            fontStyle: 'bold',
                            fontSize: 10,
                            halign: 'center'
                        },
                        styles: {
                            font: 'helvetica',
                            fontSize: 9,
                            cellPadding: 4,
                            halign: 'center',
                            valign: 'middle'
                        },
                        alternateRowStyles: {
                            fillColor: [255, 248, 240]
                        },
                        columnStyles: {
                            0: { cellWidth: 100 },  // Model Name
                            1: { cellWidth: 90 },   // Serial Number
                            2: { cellWidth: 40 },   // Qty
                            3: { cellWidth: 80 },   // Purchase Date
                            4: { cellWidth: 100 },  // Owner
                            5: { cellWidth: 60 },   // Status
                            6: { cellWidth: 70 },   // Unit Price
                            7: { cellWidth: 80 }    // Total Price
                        },
                        margin: { left: 30, right: 30 }
                    });

                    y = doc.lastAutoTable.finalY + 30;
                } else {
                    // No products found message
                    doc.setFontSize(14);
                    doc.setFont('helvetica', 'italic');
                    doc.setTextColor(150, 150, 150);
                    doc.text('No sales data available for the selected period.', 40, y);
                    y += 40;
                }

                // Add new page for analysis
                if (y > pageHeight - 200) {
                    doc.addPage();
                    y = 40;
                }

                // MOST SOLD PRODUCTS ANALYSIS
                const mostSoldProducts = data.most_sold_products || [];
                if (mostSoldProducts.length > 0) {
                    doc.setFontSize(16);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(237, 137, 54);
                    doc.text('MOST SOLD PRODUCTS ANALYSIS', 40, y);
                    y += 30;

                    const mostSoldData = [];
                    mostSoldProducts.slice(0, 10).forEach(product => {
                        mostSoldData.push([
                            product.model_name || 'N/A',
                            product.category || 'N/A',
                            product.quantity_sold || 0,
                            `$${(Number(product.revenue) || 0).toLocaleString()}`,
                            `$${(Number(product.avg_unit_price) || 0).toFixed(2)}`, // Unit price
                            `$${(Number(product.total_price) || 0).toLocaleString()}` // Total price (same as revenue)
                        ]);
                    });

                        doc.autoTable({
                            startY: y,
                            head: [['Model', 'Category', 'Quantity Sold', 'Revenue', 'Unit Price', 'Total Price']],
                            body: mostSoldData,
                            theme: 'striped',
                            headStyles: {
                                fillColor: [237, 137, 54],
                                textColor: [255, 255, 255],
                                fontStyle: 'bold',
                                fontSize: 10,
                                halign: 'center'
                            },
                            styles: {
                                font: 'helvetica',
                                fontSize: 9,
                                cellPadding: 4,
                                halign: 'center'
                            },
                            columnStyles: {
                                0: { cellWidth: 120 },
                                1: { cellWidth: 100 },
                                2: { cellWidth: 80 },
                                3: { cellWidth: 100 },
                                4: { cellWidth: 80 },
                                5: { cellWidth: 100 }
                            },
                            margin: { left: 30, right: 30 }
                        });
                        y = doc.lastAutoTable.finalY + 30;
                }

                // Add new page if needed
                if (y > pageHeight - 200) {
                    doc.addPage();
                    y = 40;
                }

                // REVENUE ANALYSIS BY CATEGORY
                if (data.revenue_analysis && data.revenue_analysis.by_category && data.revenue_analysis.by_category.length > 0) {
                    doc.setFontSize(16);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(237, 137, 54);
                    doc.text('REVENUE ANALYSIS BY CATEGORY', 40, y);
                    y += 30;

                    const categoryData = [];
                    data.revenue_analysis.by_category.forEach(category => {
                        categoryData.push([
                            category.category || 'N/A',
                            category.quantity || 0,
                            `$${(Number(category.revenue) || 0).toLocaleString()}`,
                            `$${(Number(category.avg_price) || 0).toFixed(2)}`,
                            category.products_count || 0
                        ]);
                    });

                    doc.autoTable({
                        startY: y,
                        head: [['Category', 'Quantity', 'Revenue', 'Avg Price', 'Products']],
                        body: categoryData,
                        theme: 'striped',
                        headStyles: {
                            fillColor: [237, 137, 54],
                            textColor: [255, 255, 255],
                            fontStyle: 'bold',
                            fontSize: 10,
                            halign: 'center'
                        },
                        styles: {
                            font: 'helvetica',
                            fontSize: 9,
                            cellPadding: 4,
                            halign: 'center'
                        },
                        columnStyles: {
                            0: { cellWidth: 140 },
                            1: { cellWidth: 100 },
                            2: { cellWidth: 120 },
                            3: { cellWidth: 120 },
                            4: { cellWidth: 100 }
                        },
                        margin: { left: 30, right: 30 }
                    });

                    y = doc.lastAutoTable.finalY + 30;
                }

                // Top Customers Analysis
                if (data.top_analysis && data.top_analysis.top_customers_by_spending && data.top_analysis.top_customers_by_spending.length > 0) {
                    // Add new page if needed
                    if (y > pageHeight - 200) {
                        doc.addPage();
                        y = 40;
                    }

                    doc.setFontSize(16);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(237, 137, 54);
                    doc.text('TOP CUSTOMERS BY SPENDING', 40, y);
                    y += 30;

                    const customerData = [];
                    data.top_analysis.top_customers_by_spending.slice(0, 10).forEach(customer => {
                        customerData.push([
                            customer.owner_name || 'N/A',
                            customer.company || 'Individual',
                            customer.location || 'N/A',
                            customer.total_purchases || 0,
                            `$${(Number(customer.total_spent) || 0).toLocaleString()}`,
                            `$${(Number(customer.avg_purchase) || 0).toFixed(2)}`
                        ]);
                    });

                    doc.autoTable({
                        startY: y,
                        head: [['Customer', 'Company', 'Location', 'Purchases', 'Total Spent', 'Avg Purchase']],
                        body: customerData,
                        theme: 'striped',
                        headStyles: {
                            fillColor: [237, 137, 54],
                            textColor: [255, 255, 255],
                            fontStyle: 'bold',
                            fontSize: 10,
                            halign: 'center'
                        },
                        styles: {
                            font: 'helvetica',
                            fontSize: 9,
                            cellPadding: 4,
                            halign: 'center'
                        },
                        columnStyles: {
                            0: { cellWidth: 120 },
                            1: { cellWidth: 100 },
                            2: { cellWidth: 110 },
                            3: { cellWidth: 80 },
                            4: { cellWidth: 100 },
                            5: { cellWidth: 110 }
                        },
                        margin: { left: 30, right: 30 }
                    });

                    y = doc.lastAutoTable.finalY + 30;
                }

                // Footer
                const pageCount = doc.internal.getNumberOfPages();
                for (let i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.setFontSize(8);
                    doc.setTextColor(150, 150, 150);
                    doc.text('SoosanEgypt - Sales Performance Report', 40, pageHeight - 20);
                    doc.text(`Page ${i} of ${pageCount}`, pageWidth - 60, pageHeight - 20);
                }

                // Save the PDF
                console.log('Saving PDF...');
                const fileName = `soosan-sales-performance-report-${new Date().toISOString().split('T')[0]}.pdf`;
                doc.save(fileName);

            } catch (error) {
                alert('Error generating PDF: ' + error.message);
            }
        })
        .catch(error => {
            console.error('Error fetching sales data:', error);
            alert('Error fetching sales data: ' + error.message + '. Generating basic PDF instead...');

            // Generate a basic PDF as fallback
            try {
                const { jsPDF } = window.jspdf;
                const fallbackDoc = new jsPDF();
                fallbackDoc.setFontSize(20);
                fallbackDoc.text('SoosanEgypt Sales Report', 20, 30);
                fallbackDoc.setFontSize(12);
                fallbackDoc.text('Error occurred while fetching data from server.', 20, 50);
                fallbackDoc.text('Please try again or contact support.', 20, 70);
                fallbackDoc.text('Error details: ' + error.message, 20, 90);
                fallbackDoc.save('soosan-sales-report-error.pdf');
                console.log('Fallback PDF generated');
            } catch (fallbackError) {
                console.error('Even fallback PDF failed:', fallbackError);
                alert('Critical PDF generation error. Please refresh the page and try again.');
            }
        });
        }

    } catch (error) {
        console.error('Error in downloadSalesReportPDF:', error);
        alert('Critical error in PDF generation: ' + error.message);
    }
};


// Enhanced Warranty Report PDF function with Two Separate Tables - FIXED VERSION
window.downloadWarrantyReportPDF = function() {
    try {
        // Check if jsPDF is loaded
        if (typeof window.jspdf === 'undefined') {
            alert('jsPDF library is not loaded. Please refresh the page and try again.');
            return;
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'pt', 'a4'); // Landscape mode for better table fit
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();

        // Clean Header with SoosanEgypt Branding
        doc.setFillColor(220, 53, 69); // Warranty red background
        doc.rect(0, 0, pageWidth, 120); // Header height

        // Company branding
        doc.setFontSize(32);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(255, 255, 255);
        doc.text('SoosanEgypt', 40, 40);

        doc.setFontSize(24);
        doc.setFont('helvetica', 'bold');
        doc.text('Comprehensive Warranty Analysis Report', 40, 70);

        // Enhanced date and branding
        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        doc.text('Generated on: ' + new Date().toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }), 40, 95);

        // Load transparent logo and continue with PDF generation
        const logoImg = new Image();
        logoImg.crossOrigin = 'anonymous';

        let logoLoaded = false;
        const logoTimeout = setTimeout(() => {
            if (!logoLoaded) {
                console.log('Logo timeout, continuing without logo');
                continueWithPDFGeneration();
            }
        }, 3000);

        logoImg.onload = function() {
            logoLoaded = true;
            clearTimeout(logoTimeout);
            try {
                // Add transparent logo to top right corner
                doc.addImage(logoImg, 'PNG', pageWidth - 180, 10, 130, 60);
            } catch (e) {
                console.log('Logo loading failed:', e);
            }
            continueWithPDFGeneration();
        };        logoImg.onerror = function() {
            logoLoaded = true;
            clearTimeout(logoTimeout);
            console.log('Logo failed to load, continuing without logo');
            continueWithPDFGeneration();
        };

        logoImg.src = '/images/logo2.png';

        function continueWithPDFGeneration() {
            let y = 100; // Start tables closer to header

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
            }

            // Fetch real warranty data from the server
            // Get selected time period for filtering
            const selectedPeriod = document.querySelector('.filter-option.active').dataset.period;
            let url = `/admin/reports/warranty-data?period=${selectedPeriod}`;

            // Add custom date range if selected
            if (selectedPeriod === 'custom') {
                const startDate = document.getElementById('customStartDate').value;
                const endDate = document.getElementById('customEndDate').value;
                if (startDate && endDate) {
                    url += `&start_date=${startDate}&end_date=${endDate}`;
                }
            }

            // Fetch real warranty data from the server with time filtering
            fetch(url, {
                headers: headers
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Warranty data received:', data);
                generateWarrantyTables(data);
            })
            .catch(error => {
                alert('Failed to fetch warranty data. Please check your connection and try again.');
                return;
            });

            function generateWarrantyTables(data) {
                try {
            // Table column headers - Reordered as requested
            const tableHeaders = ['Model Name', 'Serial Number', 'Purchase Price', 'Purchase Date', 'Warranty Start', 'Warranty End', 'Days Left', 'Status', 'Owner', 'Created By'];

            // FIRST TABLE: Products Under Warranty (Active) - ENHANCED
            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(40, 167, 69); // Green for active
            doc.text('PRODUCTS UNDER WARRANTY (ACTIVE)', 40, y);
            y += 20;

            const underWarrantyData = [];
            if (data.under_warranty && Array.isArray(data.under_warranty)) {
                data.under_warranty.forEach(item => {
                underWarrantyData.push([
                    String(item.model_name || 'N/A'),
                    String(item.serial_number || 'N/A'),
                    item.purchase_price ? `$${Number(item.purchase_price).toLocaleString()}` : 'N/A',
                    String(item.purchase_date || 'N/A'),
                    String(item.warranty_start_date || 'N/A'),
                    String(item.warranty_end_date || 'N/A'),
                    item.days_left ? `${Math.round(Number(item.days_left))} days` : 'N/A',
                    String(item.status || 'Active'),
                    String(item.owner_name || 'N/A'),
                    String(item.created_by || 'N/A')
                ]);
                });
            }

            if (underWarrantyData.length > 0) {
                doc.autoTable({
                startY: y,
                head: [tableHeaders],
                body: underWarrantyData,
                theme: 'striped',
                headStyles: {
                    fillColor: [40, 167, 69], // Green for active warranties
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    fontSize: 10,
                    halign: 'center'
                },
                styles: {
                    font: 'helvetica',
                    fontSize: 8,
                    cellPadding: 4,
                    halign: 'center',
                    valign: 'middle'
                },
                alternateRowStyles: {
                    fillColor: [240, 248, 240] // Light green alternating rows
                },
                columnStyles: {
                    0: { cellWidth: 70 },   // Model Name
                    1: { cellWidth: 80 },   // Serial Number
                    2: { cellWidth: 70 },   // Purchase Price
                    3: { cellWidth: 70 },   // Purchase Date
                    4: { cellWidth: 80 },   // Warranty Start
                    5: { cellWidth: 80 },   // Warranty End
                    6: { cellWidth: 60 },   // Days Left
                    7: { cellWidth: 60 },   // Status
                    8: { cellWidth: 100 },  // Owner
                    9: { cellWidth: 70 }    // Created By
                },
                margin: { left: 40, right: 40 },
                didParseCell: function(data) {
                    // Color code based on status and days left
                    if (data.column.index === 6 && data.section === 'body') { // Days Left column
                    const cellText = data.cell.text[0];
                    if (cellText && cellText.includes('days')) {
                        const days = parseInt(cellText);
                        if (days <= 30 && days > 0) {
                        data.cell.styles.textColor = [255, 193, 7]; // Orange for expiring soon
                        data.cell.styles.fontStyle = 'bold';
                        } else if (days > 90) {
                        data.cell.styles.textColor = [40, 167, 69]; // Green for good
                        data.cell.styles.fontStyle = 'bold';
                        }
                    }
                    }
                    if (data.column.index === 7 && data.section === 'body') { // Status column
                    data.cell.styles.textColor = [40, 167, 69]; // Green for active
                    data.cell.styles.fontStyle = 'bold';
                    }
                }
                });
                y = doc.lastAutoTable.finalY + 50;
            } else {
                doc.setFontSize(12);
                doc.setFont('helvetica', 'italic');
                doc.setTextColor(100, 100, 100);
                doc.text('No products currently under warranty.', 40, y + 20);
                y += 70;
            }

            // Add new page if needed
            if (y > pageHeight - 200) {
                doc.addPage();
                y = 40;
            }

            // SECOND TABLE: Expired Warranties - ENHANCED
            doc.setFontSize(18);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(220, 53, 69); // Red for expired
            doc.text('EXPIRED WARRANTY PRODUCTS', 40, y);
            y += 20;

            const expiredWarrantyData = [];
            if (data.expired && Array.isArray(data.expired)) {
                data.expired.forEach(item => {
                expiredWarrantyData.push([
                    String(item.model_name || 'N/A'),
                    String(item.serial_number || 'N/A'),
                    item.purchase_price ? `$${Number(item.purchase_price).toLocaleString()}` : 'N/A',
                    String(item.purchase_date || 'N/A'),
                    String(item.warranty_start_date || 'N/A'),
                    String(item.warranty_end_date || 'N/A'),
                    'Expired',
                    String(item.status || 'Expired'),
                    String(item.owner_name || 'N/A'),
                    String(item.created_by || 'N/A')
                ]);
                });
            }

            if (expiredWarrantyData.length > 0) {
                doc.autoTable({
                startY: y,
                head: [tableHeaders],
                body: expiredWarrantyData,
                theme: 'striped',
                headStyles: {
                    fillColor: [220, 53, 69], // Red for expired warranties
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    fontSize: 10,
                    halign: 'center'
                },
                styles: {
                    font: 'helvetica',
                    fontSize: 8,
                    cellPadding: 4,
                    halign: 'center',
                    valign: 'middle'
                },
                alternateRowStyles: {
                    fillColor: [253, 242, 242] // Light red alternating rows
                },
                columnStyles: {
                    0: { cellWidth: 70 },   // Model Name
                    1: { cellWidth: 80 },   // Serial Number
                    2: { cellWidth: 70 },   // Purchase Price
                    3: { cellWidth: 70 },   // Purchase Date
                    4: { cellWidth: 80 },   // Warranty Start
                    5: { cellWidth: 80 },   // Warranty End
                    6: { cellWidth: 60 },   // Days Left
                    7: { cellWidth: 60 },   // Status
                    8: { cellWidth: 100 },  // Owner
                    9: { cellWidth: 70 }    // Created By
                },
                margin: { left: 40, right: 40 },
                didParseCell: function(data) {
                    // Color code expired products
                    if (data.column.index === 6 && data.section === 'body') { // Days Left column
                    data.cell.styles.textColor = [220, 53, 69]; // Red for expired
                    data.cell.styles.fontStyle = 'bold';
                    }
                    if (data.column.index === 7 && data.section === 'body') { // Status column
                    data.cell.styles.textColor = [220, 53, 69]; // Red for expired
                    data.cell.styles.fontStyle = 'bold';
                    }
                }
                });
                y = doc.lastAutoTable.finalY + 50;
            } else {
                doc.setFontSize(12);
                doc.setFont('helvetica', 'italic');
                doc.setTextColor(100, 100, 100);
                doc.text('No expired warranty products found.', 40, y + 20);
                y += 70;
            }

            // Summary Statistics Section - ENHANCED
            if (y > pageHeight - 150) {
                doc.addPage();
                y = 40;
            }

            doc.setFontSize(16);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(0, 0, 0);
            doc.text('WARRANTY ANALYSIS SUMMARY', 40, y);
            y += 20;

            const activeCount = data.under_warranty ? data.under_warranty.length : 0;
            const expiredCount = data.expired ? data.expired.length : 0;
            const totalProducts = activeCount + expiredCount;

            const summaryData = [
                ['Metric', 'Count', 'Percentage'],
                ['Products Under Warranty', String(activeCount), totalProducts > 0 ? `${Math.round((activeCount/totalProducts)*100)}%` : '0%'],
                ['Expired Warranties', String(expiredCount), totalProducts > 0 ? `${Math.round((expiredCount/totalProducts)*100)}%` : '0%'],
                ['Total Products Tracked', String(totalProducts), '100%']
            ];

            doc.autoTable({
                startY: y,
                head: [summaryData[0]],
                body: summaryData.slice(1),
                theme: 'striped',
                headStyles: {
                fillColor: [102, 126, 234], // Professional blue
                textColor: [255, 255, 255],
                fontStyle: 'bold',
                fontSize: 12,
                halign: 'center'
                },
                styles: {
                font: 'helvetica',
                fontSize: 11,
                cellPadding: 8,
                halign: 'center'
                },
                columnStyles: {
                0: { cellWidth: 200, halign: 'left' },
                1: { cellWidth: 100 },
                2: { cellWidth: 100 }
                },
                margin: { left: 40, right: 40 }
            });

            // Save the PDF with enhanced filename
            const fileName = `SOOSANEG-Warranty-Report${new Date().toISOString().split('T')[0]}.pdf`;
            doc.save(fileName);

            } catch (tableError) {
                console.error('Error generating warranty tables:', tableError);
                alert('Error generating warranty PDF tables. Please try again.');
            }
        } // End of generateWarrantyTables function

        } // End of continueWithPDFGeneration function

    } catch (error) {
        console.error('Error in warranty PDF function:', error);
        alert('Error generating warranty PDF. Please check that jsPDF is loaded correctly.');
    }
};

// Enhanced mobile interactions
if ('ontouchstart' in window) {
    document.querySelectorAll('.report-card').forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });
        card.addEventListener('touchend', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// Owners Report PDF function with individual owner sections
window.downloadOwnersReportPDF = function() {
    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4'); // Portrait orientation
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 40;
        const contentWidth = pageWidth - (margin * 2);

        // Modern color scheme
        const primaryColor = [72, 187, 120]; // Green
        const secondaryColor = [45, 55, 72]; // Dark gray
        const lightGray = [247, 250, 252];
        const borderColor = [226, 232, 240];

        // Header function
        function addHeader() {
            // Header background
            doc.setFillColor(...primaryColor);
            doc.rect(0, 0, pageWidth, 80, 'F');

            // Company name
            doc.setFontSize(24);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(255, 255, 255);
            doc.text('SOOSAN EGYPT', margin, 35);

            // Report title
            doc.setFontSize(16);
            doc.setFont('helvetica', 'normal');
            doc.text('Owners & Products Report', margin, 55);

            // Date
            doc.setFontSize(10);
            const currentDate = new Date().toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            doc.text(`Generated: ${currentDate}`, pageWidth - 150, 35);
        }

        let currentY = 100; // Start below header

        // Get owners data
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };

        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
        }

        // Get selected time period for filtering
        const selectedPeriod = document.querySelector('.filter-option.active').dataset.period;
        let url = `/admin/reports/owners-data?period=${selectedPeriod}`;

        // Add custom date range if selected
        if (selectedPeriod === 'custom') {
            const startDate = document.getElementById('customStartDate').value;
            const endDate = document.getElementById('customEndDate').value;
            if (startDate && endDate) {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }
        }

        fetch(url, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Owners data received:', data);
            generateOwnersReport(data);
        })
        .catch(error => {
            console.error('Failed to fetch owners data:', error);
            alert('Failed to fetch owners data. Please check your connection and try again.');
        });

        function generateOwnersReport(data) {
            addHeader();

            const owners = data.owners || [];

            if (owners.length === 0) {
                doc.setFontSize(14);
                doc.setTextColor(...secondaryColor);
                doc.text('No owners data available for the selected period.', margin, currentY);
                doc.save('owners-report.pdf');
                return;
            }

            // Summary section
            doc.setFillColor(...lightGray);
            doc.rect(margin, currentY, contentWidth, 60, 'F');

            doc.setFontSize(14);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(...secondaryColor);
            doc.text('Summary Overview', margin + 15, currentY + 25);

            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            const analysis = data.analysis || {};
            doc.text(`Total Owners: ${owners.length}`, margin + 15, currentY + 45);
            doc.text(`Total Revenue: $${(Number(analysis.total_revenue) || 0).toLocaleString()}`, margin + 150, currentY + 45);
            doc.text(`Avg Revenue/Owner: $${(Number(analysis.average_revenue_per_owner) || 0).toFixed(2)}`, margin + 300, currentY + 45);

            currentY += 80;

            // Process each owner
            owners.forEach((owner, index) => {
                // Check if we need a new page
                if (currentY > pageHeight - 200) {
                    doc.addPage();
                    addHeader();
                    currentY = 100;
                }

                // Owner information card
                const cardHeight = 80;

                // Card background
                doc.setFillColor(255, 255, 255);
                doc.rect(margin, currentY, contentWidth, cardHeight, 'F');
                doc.setDrawColor(...borderColor);
                doc.setLineWidth(1);
                doc.rect(margin, currentY, contentWidth, cardHeight, 'S');

                // Owner details
                doc.setFontSize(14);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...primaryColor);
                doc.text(`${index + 1}. ${owner.name}`, margin + 15, currentY + 25);

                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...secondaryColor);

                // Left column
                doc.text(`Email: ${owner.email}`, margin + 15, currentY + 45);
                doc.text(`Phone: ${owner.phone}`, margin + 15, currentY + 60);

                // Right column
                if (owner.company && owner.company !== 'Individual') {
                    doc.text(`Company: ${owner.company}`, margin + 250, currentY + 45);
                }
                doc.text(`Location: ${owner.city}, ${owner.country}`, margin + 250, currentY + 60);

                currentY += cardHeight + 10;

                // Products table for this owner
                if (owner.items_owned && owner.items_owned.length > 0) {
                    const tableData = owner.items_owned.map(item => [
                        item.product || 'N/A',
                        item.serial || 'N/A',
                        item.purchase_date || 'N/A',
                        `$${(Number(item.price) || 0).toLocaleString()}`
                    ]);

                    doc.autoTable({
                        startY: currentY,
                        head: [['Product Model', 'Serial Number', 'Purchase Date', 'Price']],
                        body: tableData,
                        theme: 'grid',
                        headStyles: {
                            fillColor: primaryColor,
                            textColor: [255, 255, 255],
                            fontStyle: 'bold',
                            fontSize: 10,
                            halign: 'center'
                        },
                        styles: {
                            font: 'helvetica',
                            fontSize: 9,
                            cellPadding: 6,
                            halign: 'left',
                            valign: 'middle'
                        },
                        alternateRowStyles: {
                            fillColor: [249, 250, 251]
                        },
                        columnStyles: {
                            0: { cellWidth: 140 },  // Product Model
                            1: { cellWidth: 120 },  // Serial Number
                            2: { cellWidth: 100 },  // Purchase Date
                            3: { cellWidth: 80, halign: 'right' }   // Price
                        },
                        margin: { left: margin, right: margin },
                        tableLineColor: borderColor,
                        tableLineWidth: 0.5
                    });

                    currentY = doc.lastAutoTable.finalY + 20;

                    // Total for this owner
                    doc.setFillColor(...lightGray);
                    doc.rect(margin, currentY, contentWidth, 25, 'F');
                    doc.setFontSize(11);
                    doc.setFont('helvetica', 'bold');
                    doc.setTextColor(...secondaryColor);
                    doc.text(`Total Purchases: ${owner.total_purchases} items`, margin + 15, currentY + 16);
                    doc.text(`Total Spent: $${(Number(owner.total_spent) || 0).toLocaleString()}`, margin + 300, currentY + 16);

                    currentY += 40;
                } else {
                    // No products message
                    doc.setFillColor([255, 251, 235]);
                    doc.rect(margin, currentY, contentWidth, 30, 'F');
                    doc.setFontSize(10);
                    doc.setFont('helvetica', 'italic');
                    doc.setTextColor([180, 83, 9]);
                    doc.text('No products purchased yet', margin + 15, currentY + 20);
                    currentY += 45;
                }
            });

            // Add page numbers
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(150, 150, 150);
                doc.text(`Page ${i} of ${pageCount}`, pageWidth - 60, pageHeight - 20);
                doc.text('SOOSAN EGYPT - Confidential', margin, pageHeight - 20);
            }

            // Save the PDF
            doc.save(`owners-report-${new Date().toISOString().split('T')[0]}.pdf`);
        }

    } catch (error) {
        console.error('Error in downloadOwnersReportPDF:', error);
        alert('An error occurred while generating the PDF. Please try again.');
    }
};

// Keyboard navigation support
document.addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
        document.querySelectorAll('.filter-option, .download-btn').forEach(element => {
            element.addEventListener('focus', function() {
                this.style.outline = '2px solid #667eea';
                this.style.outlineOffset = '2px';
            });
            element.addEventListener('blur', function() {
                this.style.outline = 'none';
            });
        });
    }
});
</script>
@endpush
