@extends('layouts.admin')

@section('title', __('sold-products.edit_sale'))
@section('page-title', __('sold-products.edit_sale'))

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

    .modern-form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .modern-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        transition: var(--transition-fast);
    }

    .modern-input, .modern-select {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        background: #fff;
        transition: var(--transition);
        font-size: 1rem;
        position: relative;
    }

    .modern-input:focus, .modern-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-1px);
    }

    .modern-input:hover, .modern-select:hover {
        border-color: #ced4da;
        transform: translateY(-1px);
    }

    .modern-input.is-invalid, .modern-select.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
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

    .sale-icon-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--success-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 15px 40px rgba(40, 167, 69, 0.3);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .sale-icon-large::before {
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

    .sale-icon-large:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: 0 20px 50px rgba(40, 167, 69, 0.4);
    }

    .sale-icon-large:hover::before {
        animation: shimmer 1.5s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        animation: fadeInUp 0.3s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-floating-effect {
        position: relative;
    }

    .form-floating-effect .modern-input:focus + .modern-label,
    .form-floating-effect .modern-input:not(:placeholder-shown) + .modern-label {
        transform: translateY(-1.5rem) scale(0.85);
        color: #667eea;
    }

    /* Loading states */
    .loading {
        opacity: 0.7;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }

    /* Progress indicator */
    .form-progress {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-progress-bar {
        height: 100%;
        background: var(--primary-gradient);
        border-radius: 2px;
        transition: width 0.3s ease;
        width: 0%;
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

        .sale-icon-large {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .modern-card .card-body,
        .modern-card .card-header {
            padding: 1rem;
        }

        .modern-input, .modern-select {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
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

        .modern-form-group {
            margin-bottom: 1.25rem;
        }

        .modern-label {
            font-size: 0.8rem;
        }

        /* Mobile form layout */
        .row.g-4 > div {
            margin-bottom: 1rem;
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

        .sale-icon-large {
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

        .modern-input, .modern-select {
            padding: 0.625rem 0.875rem;
            font-size: 0.85rem;
        }

        .modern-btn {
            padding: 0.625rem 1rem;
            font-size: 0.85rem;
        }

        .modern-label {
            font-size: 0.75rem;
        }

        .modern-form-group {
            margin-bottom: 1rem;
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

        .sale-icon-large {
            width: 70px;
            height: 70px;
            font-size: 1.75rem;
        }

        .modern-input, .modern-select {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }

        .modern-btn {
            padding: 0.5rem 0.875rem;
            font-size: 0.8rem;
        }

        .modern-label {
            font-size: 0.7rem;
        }
    }

    /* Tablet Optimizations */
    @media (min-width: 768px) and (max-width: 1024px) {
        .modern-page-header {
            padding: 2.5rem 0;
        }

        .sale-icon-large {
            width: 110px;
            height: 110px;
            font-size: 2.75rem;
        }

        .modern-input, .modern-select {
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
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
        .modern-input:hover,
        .modern-select:hover,
        .sale-icon-large:hover {
            transform: none;
        }

        .modern-btn:active {
            transform: scale(0.95);
        }

        .modern-input:focus,
        .modern-select:focus {
            transform: none;
        }

        .sale-icon-large:active {
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

        .modern-input,
        .modern-select {
            border: 2px solid #000;
        }
    }

    /* Focus indicators for accessibility */
    .modern-btn:focus-visible,
    .modern-input:focus-visible,
    .modern-select:focus-visible {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Success state animations */
    .success-pulse {
        animation: successPulse 0.6s ease-out;
    }

    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Error state animations */
    .error-shake {
        animation: errorShake 0.5s ease-in-out;
    }

    @keyframes errorShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
</style>

<!-- Page Header -->
<div class="modern-page-header animate-fade-in-up">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">{{ __('sold-products.edit_sale') }}</h1>
                <p class="mb-0 opacity-75">{{ __('sold-products.update_information') }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="btn-group">
                    <a href="{{ route('admin.sold-products.show', $soldProduct) }}" class="modern-btn modern-btn-warning">
                        <i class="fas fa-eye me-2 mobile-icon-show"></i>
                        <span class="mobile-text-hide">{{ __('sold-products.view_sale') }}</span>
                        <span class="d-md-none">{{ __('sold-products.view_sale') }}</span>
                    </a>
                    <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left me-2 mobile-icon-show"></i>
                        <span class="mobile-text-hide">{{ __('sold-products.back_to_sales') }}</span>
                        <span class="d-md-none">{{ __('sold-products.back_to_sales') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="modern-card animate-stagger">
            <div class="card-header bg-white border-bottom p-4">
                <div class="text-center">
                    <div class="sale-icon-large">
                        @if($soldProduct->product && $soldProduct->product->image_url)
                            <img src="{{ $soldProduct->product->image_url }}" alt="{{ $soldProduct->product->model_name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <i class="fas fa-shopping-cart"></i>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ __('sold-products.sale_number', ['id' => $soldProduct->id]) }}</h4>
                    <p class="text-muted">{{ $soldProduct->product->model_name ?? __('sold-products.na') }} - {{ $soldProduct->owner->name ?? __('sold-products.na') }}</p>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Progress Bar -->
                <div class="form-progress">
                    <div class="form-progress-bar" id="formProgress"></div>
                </div>

                <form action="{{ route('admin.sold-products.update', $soldProduct) }}" method="POST" id="editSaleForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Product Selection -->
                        <div class="col-md-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="product_id" class="modern-label">
                                    <i class="fas fa-box mobile-icon"></i>
                                    Product <span class="text-danger">*</span>
                                </label>
                                <select class="modern-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id', $soldProduct->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->model_name }} - {{ $product->category->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Owner Selection -->
                        <div class="col-md-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="owner_id" class="modern-label">
                                    <i class="fas fa-user mobile-icon"></i>
                                    {{ __('sold-products.owner') }} <span class="text-danger">*</span>
                                </label>
                                <select class="modern-select @error('owner_id') is-invalid @enderror" id="owner_id" name="owner_id" required>
                                    <option value="">{{ __('sold-products.select_owner') }}</option>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ old('owner_id', $soldProduct->owner_id) == $owner->id ? 'selected' : '' }}>
                                            {{ $owner->name }} - {{ $owner->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('owner_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Employee Selection -->
                        <div class="col-md-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="user_id" class="modern-label">
                                    <i class="fas fa-user-tie mobile-icon"></i>
                                    {{ __('sold-products.employee') }} <span class="text-danger">*</span>
                                </label>
                                @php $currentUser = Auth::user(); @endphp
                                @if ($currentUser->isEmployee())
                                    <select class="modern-select" id="user_id" name="user_id" disabled>
                                        <option value="{{ $currentUser->id }}" selected>{{ $currentUser->name }} ({{ __('admin.' . $currentUser->role) }})</option>
                                    </select>
                                    <input type="hidden" name="user_id" value="{{ $currentUser->id }}">
                                @else
                                    <select class="modern-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        <option value="">{{ __('sold-products.select_employee') }}</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('user_id', $soldProduct->user_id) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} ({{ __('admin.' . $employee->role) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div class="col-md-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="serial_number" class="modern-label">
                                    <i class="fas fa-barcode mobile-icon"></i>
                                    {{ __('sold-products.serial_number') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="modern-input @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number', $soldProduct->serial_number) }}" placeholder="{{ __('sold-products.enter_serial_number') }}" required>
                                @error('serial_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sale Date -->
                        <div class="col-md-4 col-sm-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="sale_date" class="modern-label">
                                    <i class="fas fa-calendar mobile-icon"></i>
                                    {{ __('sold-products.sale_date') }} <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="modern-input @error('sale_date') is-invalid @enderror" id="sale_date" name="sale_date" value="{{ old('sale_date', $soldProduct->sale_date ? $soldProduct->sale_date->format('Y-m-d') : '') }}" required>
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Warranty Start Date -->
                        <div class="col-md-4 col-sm-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="warranty_start_date" class="modern-label">
                                    <i class="fas fa-calendar-check mobile-icon"></i>
                                    {{ __('sold-products.warranty_start') }} <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="modern-input @error('warranty_start_date') is-invalid @enderror" id="warranty_start_date" name="warranty_start_date" value="{{ old('warranty_start_date', $soldProduct->warranty_start_date ? $soldProduct->warranty_start_date->format('Y-m-d') : '') }}" required>
                                @error('warranty_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Warranty End Date -->
                        <div class="col-md-4 col-sm-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="warranty_end_date" class="modern-label">
                                    <i class="fas fa-calendar-times mobile-icon"></i>
                                    {{ __('sold-products.warranty_end') }} <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="modern-input @error('warranty_end_date') is-invalid @enderror" id="warranty_end_date" name="warranty_end_date" value="{{ old('warranty_end_date', $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('Y-m-d') : '') }}" required>
                                @error('warranty_end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Purchase Price -->
                        <div class="col-md-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="purchase_price" class="modern-label">
                                    <i class="fas fa-dollar-sign mobile-icon"></i>
                                    {{ __('sold-products.purchase_price') }}
                                </label>
                                <input type="number" step="0.01" min="0" class="modern-input @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $soldProduct->purchase_price) }}" placeholder="0.00">
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6">
                            <div class="modern-form-group animate-stagger">
                                <label for="quantity" class="modern-label">
                                    <i class="fas fa-sort-numeric-up mobile-icon"></i>
                                    {{ __('sold-products.quantity') }}
                                </label>
                                <input type="number" min="1" class="modern-input @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $soldProduct->quantity ?? 1) }}" placeholder="1">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <div class="modern-form-group animate-stagger">
                                <label for="notes" class="modern-label">
                                    <i class="fas fa-sticky-note mobile-icon"></i>
                                    {{ __('sold-products.notes') }}
                                </label>
                                <textarea class="modern-input @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" placeholder="{{ __('sold-products.additional_notes_placeholder') }}">{{ old('notes', $soldProduct->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            <span class="mobile-text-hide">{{ __('sold-products.cancel') }}</span>
                            <span class="d-md-none">{{ __('sold-products.cancel') }}</span>
                        </a>
                        <button type="submit" class="modern-btn" id="submitBtn">
                            <i class="fas fa-save me-2"></i>
                            <span class="mobile-text-hide">{{ __('sold-products.update_sale') }}</span>
                            <span class="d-md-none">{{ __('sold-products.update_sale') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate warranty end date when warranty start date changes
    const warrantyStartInput = document.getElementById('warranty_start_date');
    const warrantyEndInput = document.getElementById('warranty_end_date');
    const editSaleForm = document.getElementById('editSaleForm');
    const submitBtn = document.getElementById('submitBtn');
    const formProgress = document.getElementById('formProgress');

    warrantyStartInput.addEventListener('change', function() {
        if (this.value && !warrantyEndInput.value) {
            // Default to 1 year warranty
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setFullYear(endDate.getFullYear() + 1);
            warrantyEndInput.value = endDate.toISOString().split('T')[0];

            // Visual feedback
            warrantyEndInput.style.borderColor = '#28a745';
            warrantyEndInput.classList.add('success-pulse');
            setTimeout(() => {
                warrantyEndInput.style.borderColor = '#e9ecef';
                warrantyEndInput.classList.remove('success-pulse');
            }, 1000);
        }
    });

    // Form validation and progress tracking
    const requiredFields = ['product_id', 'owner_id', 'user_id', 'serial_number', 'sale_date', 'warranty_start_date', 'warranty_end_date'];

    function updateProgress() {
        const filledFields = requiredFields.filter(field => {
            const element = document.getElementById(field);
            return element && element.value.trim() !== '';
        });

        const progress = (filledFields.length / requiredFields.length) * 100;
        formProgress.style.width = progress + '%';

        if (progress === 100) {
            formProgress.style.background = 'var(--success-gradient)';
        } else {
            formProgress.style.background = 'var(--primary-gradient)';
        }
    }

    function validateField(field) {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            element.classList.add('is-invalid');
            element.classList.add('error-shake');
            setTimeout(() => element.classList.remove('error-shake'), 500);
            return false;
        } else {
            element.classList.remove('is-invalid');
            element.classList.add('success-pulse');
            setTimeout(() => element.classList.remove('success-pulse'), 600);
            return true;
        }
    }

    function validateForm() {
        let isValid = true;
        requiredFields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });
        return isValid;
    }

    // Real-time validation and progress updates
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.addEventListener('input', function() {
                updateProgress();
                if (this.classList.contains('is-invalid')) {
                    validateField(field);
                }
            });

            element.addEventListener('blur', function() {
                validateField(field);
            });
        }
    });

    // Date validation
    function validateDates() {
        const saleDate = new Date(document.getElementById('sale_date').value);
        const warrantyStart = new Date(warrantyStartInput.value);
        const warrantyEnd = new Date(warrantyEndInput.value);

        if (warrantyStart && warrantyEnd && warrantyStart >= warrantyEnd) {
            warrantyEndInput.setCustomValidity('Warranty end date must be after start date');
            warrantyEndInput.classList.add('is-invalid');
            return false;
        } else {
            warrantyEndInput.setCustomValidity('');
            warrantyEndInput.classList.remove('is-invalid');
            return true;
        }
    }

    [document.getElementById('sale_date'), warrantyStartInput, warrantyEndInput].forEach(input => {
        if (input) {
            input.addEventListener('change', validateDates);
        }
    });

    // Form submission handling
    editSaleForm.addEventListener('submit', function(e) {
        if (!validateForm() || !validateDates()) {
            e.preventDefault();

            // Scroll to first invalid field
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }

            // Show error notification
            showNotification('Please correct the errors below', 'error');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><span class="mobile-text-hide">Updating...</span><span class="d-md-none">Updating...</span>';
        editSaleForm.classList.add('loading');
    });

    // Enhanced input interactions
    document.querySelectorAll('.modern-input, .modern-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.modern-form-group').style.transform = 'translateY(-1px)';
            this.style.borderColor = '#667eea';
        });

        input.addEventListener('blur', function() {
            this.closest('.modern-form-group').style.transform = 'translateY(0)';
            if (!this.classList.contains('is-invalid')) {
                this.style.borderColor = '#e9ecef';
            }
        });
    });

    // Initialize progress
    updateProgress();

    // Animate form elements on load
    const formGroups = document.querySelectorAll('.modern-form-group');
    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(20px)';

        setTimeout(() => {
            group.style.transition = 'all 0.6s ease';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
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

    // Auto-save to localStorage (for form recovery)
    const formInputs = document.querySelectorAll('input, select, textarea');

    formInputs.forEach(input => {
        // Load saved data
        const savedValue = localStorage.getItem(`editSaleForm_${input.name}`);
        if (savedValue && !input.value && input.name !== '_token') {
            input.value = savedValue;
        }

        // Save data on change
        input.addEventListener('change', function() {
            if (this.name !== '_token') {
                localStorage.setItem(`editSaleForm_${this.name}`, this.value);
            }
        });
    });

    // Clear saved data on successful submission
    editSaleForm.addEventListener('submit', function() {
        setTimeout(() => {
            formInputs.forEach(input => {
                if (input.name !== '_token') {
                    localStorage.removeItem(`editSaleForm_${input.name}`);
                }
            });
        }, 1000);
    });

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        `;
        notification.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            if (e.key === 's') {
                e.preventDefault();
                editSaleForm.dispatchEvent(new Event('submit'));
            }
        }
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

    // Observe form groups for scroll animations
    document.querySelectorAll('.animate-stagger').forEach(element => {
        observer.observe(element);
    });
});
</script>
@endsection
