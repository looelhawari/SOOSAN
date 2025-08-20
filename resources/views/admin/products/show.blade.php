@extends('layouts.admin')

@section('title', __('products.product_details'))
@section('page-title', __('products.product_details'))

@section('content')
<style>
    :root {
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
        --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --card-shadow-hover: 0 15px 40px rgba(0,0,0,0.15);
    }

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
    }

    .modern-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: var(--transition);
    }

    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
    }

    .modern-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        position: relative;
    }

    .modern-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .modern-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #495057;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card-body {
        padding: 1.5rem;
    }

    .modern-btn {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-width: fit-content;
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
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .modern-btn:active {
        transform: translateY(-1px);
    }

    .modern-btn-secondary {
        background: var(--secondary-gradient);
    }

    .modern-btn-secondary:hover {
        box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
    }

    .modern-btn-warning {
        background: var(--warning-gradient);
    }

    .modern-btn-warning:hover {
        box-shadow: 0 10px 25px rgba(255, 193, 7, 0.3);
    }

    .modern-btn-success {
        background: var(--success-gradient);
    }

    .modern-btn-success:hover {
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
    }

    .product-icon-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--info-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 15px 40px rgba(23, 162, 184, 0.3);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .product-icon-large::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        transition: var(--transition);
    }

    .product-icon-large:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 20px 50px rgba(23, 162, 184, 0.4);
    }

    .product-icon-large:hover::before {
        animation: shimmer 1.5s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
        transition: var(--transition);
    }

    .spec-item:hover {
        background: rgba(102, 126, 234, 0.05);
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        border-radius: var(--border-radius-sm);
    }

    .spec-item:last-child {
        border-bottom: none;
    }

    .spec-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .spec-value {
        color: #495057;
        font-weight: 600;
        text-align: right;
        font-size: 0.95rem;
    }

    .status-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .status-badge.active {
        background: var(--success-gradient);
        color: white;
    }

    .status-badge.inactive {
        background: var(--danger-gradient);
        color: white;
    }

    .status-badge.featured {
        background: var(--warning-gradient);
        color: white;
    }

    .status-badge.normal {
        background: var(--secondary-gradient);
        color: white;
    }

    .product-image-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        opacity: 0;
        transition: var(--transition);
    }

    .product-image-container:hover::before {
        opacity: 1;
    }

    .product-image-container:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
        border-color: #667eea;
    }

    .product-image-container img {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        transition: var(--transition);
        border-radius: var(--border-radius-sm);
    }

    .product-image-container:hover img {
        transform: scale(1.05);
    }

    .no-image-placeholder {
        color: #6c757d;
        font-size: 1.125rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .no-image-placeholder i {
        font-size: 4rem;
        opacity: 0.3;
    }

    .metadata-section {
        background: #f8f9fa;
        border-radius: var(--border-radius-sm);
        padding: 1rem;
        margin-top: 1.5rem;
        border-left: 4px solid #667eea;
    }

    .metadata-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        font-size: 0.875rem;
    }

    .metadata-label {
        color: #6c757d;
        font-weight: 500;
    }

    .metadata-value {
        color: #495057;
        font-weight: 600;
    }

    /* Mobile Optimizations */
    @media (max-width: 768px) {
        .modern-page-header {
            padding: 2rem 0;
            margin: -1rem -1rem 1.5rem;
        }

        .modern-page-header .row > div {
            text-align: center;
            margin-bottom: 1rem;
        }

        .modern-page-header .col-md-4 {
            text-align: center !important;
        }

        .modern-page-header h1 {
            font-size: 1.5rem;
        }

        .modern-page-header p {
            font-size: 0.9rem;
        }

        .product-icon-large {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .modern-card .card-body,
        .modern-card .card-header {
            padding: 1rem;
        }

        .modern-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }

        .btn-group .modern-btn {
            margin-bottom: 0;
        }

        .specs-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .spec-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .spec-value {
            text-align: left;
            font-size: 1rem;
        }

        .status-badges {
            flex-direction: column;
            gap: 0.5rem;
        }

        .status-badge {
            text-align: center;
            padding: 0.75rem 1rem;
        }

        .d-flex.justify-content-between {
            gap: 1rem;
        }

        .d-flex.justify-content-between .modern-btn {
            margin-bottom: 0;
        }

        /* Mobile icons in labels */
        .mobile-icon {
            display: inline-block;
            width: 16px;
            text-align: center;
        }

        /* Hide text on mobile, show icons */
        .mobile-text-hide {
            display: none;
        }

        .mobile-icon-show {
            display: inline-block;
        }
    }

    @media (max-width: 576px) {
        .modern-page-header {
            margin: -0.5rem -0.5rem 1rem;
            padding: 1.5rem 0;
        }

        .product-icon-large {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .modern-card {
            margin-bottom: 1rem;
        }

        .modern-card .card-body,
        .modern-card .card-header {
            padding: 0.75rem;
        }

        .modern-btn {
            padding: 0.625rem 1rem;
            font-size: 0.85rem;
        }

        .modern-card-title {
            font-size: 1rem;
        }

        .spec-label {
            font-size: 0.75rem;
        }

        .spec-value {
            font-size: 0.9rem;
        }

        .product-image-container {
            padding: 1rem;
            min-height: 200px;
        }

        .product-image-container img {
            max-height: 150px;
        }

        /* Very small screens - compact layout */
        .col-md-4 {
            margin-bottom: 0.75rem;
        }
    }

    @media (max-width: 375px) {
        .modern-page-header {
            padding: 1rem 0;
        }

        .product-icon-large {
            width: 70px;
            height: 70px;
            font-size: 1.75rem;
        }

    .modern-btn {
            padding: 0.5rem 0.875rem;
            font-size: 0.8rem;
        }

        .modern-card-title {
        font-size: 0.9rem;
    }
    }

    /* Tablet Optimizations */
    @media (min-width: 768px) and (max-width: 1024px) {
        .modern-page-header {
            padding: 2.5rem 0;
        }

        .product-icon-large {
            width: 110px;
            height: 110px;
            font-size: 2.75rem;
        }

        .modern-btn {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    /* Animation Classes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-stagger {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-stagger:nth-child(1) { animation-delay: 0.1s; }
    .animate-stagger:nth-child(2) { animation-delay: 0.2s; }
    .animate-stagger:nth-child(3) { animation-delay: 0.3s; }
    .animate-stagger:nth-child(4) { animation-delay: 0.4s; }
    .animate-stagger:nth-child(5) { animation-delay: 0.5s; }

    /* Touch device optimizations */
    @media (hover: none) and (pointer: coarse) {
        .modern-btn:hover,
        .modern-card:hover,
        .spec-item:hover,
        .product-icon-large:hover,
        .product-image-container:hover {
            transform: none;
        }

        .modern-btn:active {
            transform: scale(0.95);
        }

        .product-icon-large:active {
            transform: scale(0.95);
        }
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
        .modern-card {
            border: 2px solid #000;
        }
    }

    /* Focus indicators for accessibility */
    .modern-btn:focus-visible {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }
</style>

<!-- Page Header -->
<div class="modern-page-header animate-fade-in-up">
    <div class="container-fluid position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                <h1 class="h2 mb-2">{{ $product->model_name }}</h1>
                <p class="mb-0 opacity-75">{{ __('products.product_details_and_specifications') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                <div class="btn-group">
                        <a href="{{ route('admin.products.edit', $product) }}" class="modern-btn modern-btn-warning">
                            <i class="fas fa-edit me-2 mobile-icon-show"></i>
                            <span class="mobile-text-hide">{{ __('products.edit_product') }}</span>
                            <span class="d-md-none">{{ __('products.mobile_edit') }}</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-arrow-left me-2 mobile-icon-show"></i>
                            <span class="mobile-text-hide">{{ __('products.back_to_products') }}</span>
                            <span class="d-md-none">{{ __('products.mobile_back') }}</span>
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Product Image & Basic Info -->
    <div class="col-lg-4 col-md-6">
        <div class="modern-card animate-stagger">
            <div class="modern-card-header">
                <div class="text-center">
                    <div class="product-icon-large">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <i class="fas fa-cube"></i>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ $product->model_name }}</h4>
                    <p class="text-muted">{{ $product->category->name ?? __('products.no_category') }}</p>
                </div>
            </div>
            <div class="modern-card-body">
                <!-- Status Badges -->
                <div class="status-badges">
                    <span class="status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                        {{ $product->is_active ? __('products.active') : __('products.inactive') }}
                    </span>
                    <span class="status-badge {{ $product->is_featured ? 'featured' : 'normal' }}">
                        {{ $product->is_featured ? __('products.featured') : __('products.normal') }}
                    </span>
                </div>

                <!-- Product Image -->
                <div class="product-image-container">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image"></i>
                            <p>{{ __('products.no_image_available') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Metadata -->
                <div class="metadata-section">
                    <div class="metadata-item">
                        <span class="metadata-label">{{ __('products.created_at') }}</span>
                        <span class="metadata-value"></span>
                    </div>
                    <div class="metadata-item">
                        <span class="metadata-label">{{ __('products.updated_at') }}</span>
                        <span class="metadata-value"></span>
                    </div>
                    @if($product->price)
                    <div class="metadata-item">
                        <span class="metadata-label">{{ __('products.price') }}</span>
                        <span class="metadata-value">${{ number_format($product->price, 2) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Product Specifications -->
    <div class="col-lg-8 col-md-6">
        <div class="modern-card animate-stagger">
                <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fas fa-cogs"></i>
                    {{ __('products.technical_specifications') }}
                </h3>
                </div>
                <div class="modern-card-body">
                @php
                    function nf1($v) {
                        return is_numeric($v) ? number_format($v, 1, '.', ',') : $v;
                    }

                    function nf0($v) {
                        return is_numeric($v) ? number_format($v, 0, '.', ',') : $v;
                    }

                    function spec_row($val, $factor, $si_unit, $imp_unit, $si_decimals = 0) {
                        if ($val === null || $val === '' || $val === '-') {
                            return '- ' . $si_unit;
                        }
                        if (preg_match('/^([\d.]+)~([\d.]+)/', $val, $m)) {
                            $si_min = number_format($m[1] * $factor, $si_decimals, '.', ',');
                            $si_max = number_format($m[2] * $factor, $si_decimals, '.', ',');
                            return "$si_min ~ $si_max $si_unit";
                        }
                        if (preg_match('/^(\d+)\/(\d+)$/', trim($val), $m)) {
                            $dec = $m[1] / $m[2];
                            return number_format($dec * $factor, $si_decimals, '.', ',') . " $si_unit";
                        }
                        if (is_numeric($val)) {
                            return number_format($val * $factor, $si_decimals, '.', ',') . " $si_unit";
                        }
                        return $val . " $si_unit";
                    }

                    function bpm_row($val) {
                        $dash = '- BPM';
                        if ($val === null || $val === '' || $val === '-') return $dash;
                        if (preg_match('/^([\d.]+)~([\d.]+)/', $val, $m)) {
                            return nf0($m[1]) . ' ~ ' . nf0($m[2]) . ' BPM';
                        }
                        if (is_numeric($val)) return nf0($val) . ' BPM';
                        return $val . ' BPM';
                    }

                    function hose_row($val) {
                        if ($val === null || $val === '' || $val === '-') return '- in';
                        return "$val in";
                    }

                    function op_row($val) {
                        $si_unit = 'kgf/cm²';
                        if ($val === null || $val === '' || $val === '-') return '- ' . $si_unit;
                        if (preg_match('/^([\d.,]+)~([\d.,]+)/', $val, $m)) {
                            $si_min = nf0(floatval(str_replace([','], [''], $m[1])) * 0.070307);
                            $si_max = nf0(floatval(str_replace([','], [''], $m[2])) * 0.070307);
                            return "$si_min ~ $si_max $si_unit";
                        }
                        if (is_numeric(str_replace([','], [''], $val))) {
                            $si = nf0(floatval(str_replace([','], [''], $val)) * 0.070307);
                            return "$si $si_unit";
                        }
                        return $val . ' ' . $si_unit;
                    }

                    // Convert to SI units
                    $bw_si = spec_row($product->body_weight, 0.45359237, 'kg', 'lb', 0);
                    $ow_si = spec_row($product->operating_weight, 0.45359237, 'kg', 'lb', 0);
                    $ol_si = spec_row($product->overall_length, 25.4, 'mm', 'in', 0);
                    $owd_si = spec_row($product->overall_width, 25.4, 'mm', 'in', 0);
                    $oh_si = spec_row($product->overall_height, 25.4, 'mm', 'in', 0);
                    $rof_si = spec_row($product->required_oil_flow, 3.785411784, 'l/min', 'gal/min', 0);
                    $op_si = op_row($product->operating_pressure);
                    $ir_si = bpm_row($product->impact_rate);
                    $ac_si = spec_row($product->applicable_carrier, 0.00045359237, 'ton', 'lb', 1);
                @endphp
                <div class="specs-grid">
                    <div class="spec-column">
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.model_name') }}</span>
                            <span class="spec-value">{{ $product->model_name }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.line') }}</span>
                            <span class="spec-value">{{ $product->line ?? __('products.n_a') }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.type') }}</span>
                            <span class="spec-value">{{ $product->type ?? __('products.n_a') }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.category') }}</span>
                            <span class="spec-value">{{ $product->category->name ?? __('products.n_a') }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.body_weight') }}</span>
                            <span class="spec-value">{{ $bw_si }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.operating_weight') }}</span>
                            <span class="spec-value">{{ $ow_si }}</span>
                            </div>
                            </div>
                    <div class="spec-column">
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.overall_length') }}</span>
                            <span class="spec-value">{{ $ol_si }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.overall_width') }}</span>
                            <span class="spec-value">{{ $owd_si }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.overall_height') }}</span>
                            <span class="spec-value">{{ $oh_si }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.required_oil_flow') }}</span>
                            <span class="spec-value">{{ $rof_si }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.operating_pressure') }}</span>
                            <span class="spec-value">{{ $op_si }}</span>
                            </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.impact_rate') }}</span>
                            <span class="spec-value">{{ $ir_si }}</span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Additional Specifications -->
        <div class="modern-card animate-stagger">
                <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fas fa-wrench"></i>
                    {{ __('products.additional_specifications') }}
                </h3>
                </div>
                <div class="modern-card-body">
                @php
                    $irsr_si = bpm_row($product->impact_rate_soft_rock);
                    $hd_si = hose_row($product->hose_diameter);
                    $rd_si = spec_row($product->rod_diameter, 25.4, 'mm', 'in', 0);
                @endphp
                <div class="specs-grid">
                    <div class="spec-column">
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.impact_rate_soft_rock') }}</span>
                            <span class="spec-value">{{ $irsr_si }}</span>
                    </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.hose_diameter') }}</span>
                            <span class="spec-value">{{ $hd_si }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.rod_diameter') }}</span>
                            <span class="spec-value">{{ $rd_si }}</span>
                        </div>
                    </div>
                    <div class="spec-column">
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.applicable_carrier') }}</span>
                            <span class="spec-value">{{ $ac_si }}</span>
                            </div>
                        @if($product->price)
                        <div class="spec-item">
                            <span class="spec-label">{{ __('products.price') }}</span>
                            <span class="spec-value">${{ number_format($product->price, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mt-4">
    <div class="col-12">
        <div class="modern-card animate-stagger">
            <div class="modern-card-body">
                <div class="d-flex justify-content-between flex-wrap gap-3">
                    <div class="btn-group">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="modern-btn modern-btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        <span class="mobile-text-hide">{{ __('products.edit_product') }}</span>
                        <span class="d-md-none">{{ __('products.mobile_edit') }}</span>
                    </a>
                        @can('delete', $product)
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('products.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                                                <button type="submit" class="modern-btn" style="background: var(--danger-gradient);">
                        <i class="fas fa-trash me-2"></i>
                        <span class="mobile-text-hide">{{ __('products.delete_product') }}</span>
                        <span class="d-md-none">{{ __('products.mobile_delete') }}</span>
                    </button>
                        </form>
                        @endcan
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('products.show', $product) }}" class="modern-btn modern-btn-success" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>
                            <span class="mobile-text-hide">{{ __('products.view_public') }}</span>
                            <span class="d-md-none">{{ __('products.mobile_view') }}</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            <span class="mobile-text-hide">{{ __('products.back_to_products') }}</span>
                            <span class="d-md-none">{{ __('products.mobile_back') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on load
    const animatedElements = document.querySelectorAll('.animate-stagger');
    animatedElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';

        setTimeout(() => {
            element.style.transition = 'all 0.6s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Touch device optimizations
    if ('ontouchstart' in window) {
        document.querySelectorAll('.modern-btn').forEach(btn => {
            btn.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
            });

            btn.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });
    }

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

    // Observe cards for scroll animations
    document.querySelectorAll('.modern-card').forEach(card => {
        observer.observe(card);
    });

    // Enhanced hover effects for spec items
    document.querySelectorAll('.spec-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(102, 126, 234, 0.05)';
            this.style.paddingLeft = '0.5rem';
            this.style.paddingRight = '0.5rem';
            this.style.borderRadius = '0.5rem';
        });

        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.paddingLeft = '';
            this.style.paddingRight = '';
            this.style.borderRadius = '';
        });
    });
});
</script>
@endsection
