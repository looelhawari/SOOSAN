@extends('layouts.admin')

@section('title', __('products.create_product'))
@section('page-title', __('products.create_product'))

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

    .modern-input, .modern-select, .modern-textarea {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius-sm);
        background: #fff;
        transition: var(--transition);
        font-size: 1rem;
        position: relative;
    }

    .modern-input:focus, .modern-select:focus, .modern-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-1px);
    }

    .modern-input:hover, .modern-select:hover, .modern-textarea:hover {
        border-color: #ced4da;
        transform: translateY(-1px);
    }

    .modern-input.is-invalid, .modern-select.is-invalid, .modern-textarea.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .modern-textarea {
        min-height: 120px;
        resize: vertical;
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
        box-shadow: 0 20px 50px rgba(40, 167, 69, 0.4);
    }

    .product-icon-large:hover::before {
        animation: shimmer 1.5s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .form-group-full {
        grid-column: 1 / -1;
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

    .required {
        color: #dc3545;
        font-weight: 700;
    }

    /* File Upload Styles */
    .file-upload-container {
        position: relative;
        border: 2px dashed #e9ecef;
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        transition: var(--transition);
        cursor: pointer;
    }

    .file-upload-container:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.02);
    }

    .file-upload-container.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
        transform: scale(1.02);
    }

    .file-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--info-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
        box-shadow: 0 8px 20px rgba(23, 162, 184, 0.3);
    }

    .file-upload-text h4 {
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .file-upload-text p {
        color: #6c757d;
        margin: 0;
        font-size: 0.875rem;
    }

    /* Image Preview Styles */
    .image-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .image-preview-item {
        position: relative;
        border-radius: var(--border-radius-sm);
        overflow: hidden;
        background: #f8f9fa;
        aspect-ratio: 1;
        border: 2px solid #e9ecef;
        transition: var(--transition);
    }

    .image-preview-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
        border-color: #667eea;
    }

    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .image-remove-btn:hover {
        background: #dc3545;
        transform: scale(1.1);
    }

    /* Checkbox Styles */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .checkbox-container {
        position: relative;
        width: 24px;
        height: 24px;
    }

    .checkbox-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .checkbox-custom {
        width: 24px;
        height: 24px;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .checkbox-input:checked + .checkbox-custom {
        background: var(--success-gradient);
        border-color: #28a745;
    }

    .checkbox-custom::after {
        content: '✓';
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        opacity: 0;
        transition: var(--transition);
    }

    .checkbox-input:checked + .checkbox-custom::after {
        opacity: 1;
    }

    .checkbox-label {
        font-weight: 600;
        color: #495057;
        cursor: pointer;
        user-select: none;
    }

    /* Loading States */
    .loading {
        opacity: 0.7;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Progress Indicator */
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

    /* Alert Styles */
    .modern-alert {
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius-sm);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        animation: fadeInUp 0.6s ease-out;
    }

    .modern-alert.success {
        background: rgba(40, 167, 69, 0.1);
        color: #155724;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .modern-alert.error {
        background: rgba(220, 53, 69, 0.1);
        color: #721c24;
        border: 1px solid rgba(220, 53, 69, 0.3);
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

        .modern-input, .modern-select, .modern-textarea {
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

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-grid-3 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .modern-form-group {
            margin-bottom: 1.25rem;
        }

        .modern-label {
            font-size: 0.8rem;
        }

        .file-upload-container {
            padding: 1.5rem 1rem;
        }

        .file-upload-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .image-preview-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 0.75rem;
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

        .modern-input, .modern-select, .modern-textarea {
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

        .file-upload-container {
            padding: 1rem 0.75rem;
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

        .modern-input, .modern-select, .modern-textarea {
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

        .product-icon-large {
            width: 110px;
            height: 110px;
            font-size: 2.75rem;
        }

        .modern-input, .modern-select, .modern-textarea {
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
        .modern-textarea:hover,
        .product-icon-large:hover,
        .file-upload-container:hover,
        .image-preview-item:hover {
            transform: none;
        }

        .modern-btn:active {
            transform: scale(0.95);
        }

        .modern-input:focus,
        .modern-select:focus,
        .modern-textarea:focus {
            transform: none;
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

        .modern-input,
        .modern-select,
        .modern-textarea {
            border: 2px solid #000;
        }
    }

    /* Focus indicators for accessibility */
    .modern-btn:focus-visible,
    .modern-input:focus-visible,
    .modern-select:focus-visible,
    .modern-textarea:focus-visible {
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
                <h1 class="h2 mb-2">{{ __('products.create_new_product') }}</h1>
                <p class="mb-0 opacity-75">{{ __('products.add_new_product_to_catalog') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                <div class="btn-group">
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

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="modern-alert success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="modern-alert error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="modern-card animate-stagger">
            <div class="modern-card-header">
                <div class="text-center">
                    <div class="product-icon-large">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h4 class="mb-1">{{ __('products.create_new_product') }}</h4>
                    <p class="text-muted">{{ __('products.fill_product_details') }}</p>
                </div>
            </div>
            <div class="modern-card-body">
                <!-- Progress Bar -->
                <div class="form-progress">
                    <div class="form-progress-bar" id="formProgress"></div>
                </div>

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createProductForm">
            @csrf

            <!-- Basic Information Section -->
                    <div class="modern-card animate-stagger">
                        <div class="modern-card-header">
                            <h3 class="modern-card-title">
                        <i class="fas fa-info-circle"></i>
                                {{ __('products.basic_information') }}
                            </h3>
                    </div>
                        <div class="modern-card-body">
                            <div class="form-grid">
                    <div class="modern-form-group">
                        <label for="model_name" class="modern-label">
                                        <i class="fas fa-tag mobile-icon"></i>
                                        {{ __('products.model_name') }} <span class="required">*</span>
                        </label>
                        <input type="text"
                                class="modern-input @error('model_name') is-invalid @enderror"
                               id="model_name"
                               name="model_name"
                               value="{{ old('model_name') }}"
                                placeholder="{{ __('products.enter_model_name') }}"
                               required>
                        @error('model_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="category_id" class="modern-label">
                            <i class="fas fa-folder mobile-icon"></i>
                            {{ __('products.category') }} <span class="required">*</span>
                        </label>
                        <select class="modern-select @error('category_id') is-invalid @enderror"
                                id="category_id"
                                name="category_id"
                                required>
                            <option value="">{{ __('products.select_category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="line" class="modern-label">
                            <i class="fas fa-stream mobile-icon"></i>
                            {{ __('products.line') }}
                        </label>
                        <select
                            class="modern-select @error('line') is-invalid @enderror"
                            id="line"
                            name="line"
                            required
                        >
                            <option value="">{{ __('products.line_placeholder') }}</option>
                            <option value="ET-II Line" {{ old('line') == 'ET-II Line' ? 'selected' : '' }}>ET-II Line</option>
                            <option value="SB Line" {{ old('line') == 'SB Line' ? 'selected' : '' }}>SB Line</option>
                            <option value="SB-E Line" {{ old('line') == 'SB-E Line' ? 'selected' : '' }}>SB-E Line</option>
                            <option value="SQ Line" {{ old('line') == 'SQ Line' ? 'selected' : '' }}>SQ Line</option>
                        </select>
                        @error('line')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="type" class="modern-label">
                            <i class="fas fa-shapes mobile-icon"></i>
                            {{ __('products.type') }}
                        </label>
                        <select
                            class="modern-select @error('type') is-invalid @enderror"
                            id="type"
                            name="type"
                            required
                        >
                            <option value="">{{ __('products.type_placeholder') }}</option>
                            <option value="Side" {{ old('type') == 'Side' ? 'selected' : '' }}>Side</option>
                            <option value="Side Silenced" {{ old('type') == 'Side Silenced' ? 'selected' : '' }}>Side Silenced</option>
                            <option value="Top Direct" {{ old('type') == 'Top Direct' ? 'selected' : '' }}>Top Direct</option>
                            <option value="Top Cap" {{ old('type') == 'Top Cap' ? 'selected' : '' }}>Top Cap</option>
                            <option value="TR-F" {{ old('type') == 'TR-F' ? 'selected' : '' }}>TR-F</option>
                            <option value="TS-P" {{ old('type') == 'TS-P' ? 'selected' : '' }}>TS-P</option>
                            <option value="SQ Easylube" {{ old('type') == 'SQ Easylube' ? 'selected' : '' }}>SQ Easylube</option>
                            <option value="Backhoe" {{ old('type') == 'Backhoe' ? 'selected' : '' }}>Backhoe</option>
                            <option value="Backhoe Silenced" {{ old('type') == 'Backhoe Silenced' ? 'selected' : '' }}>Backhoe Silenced</option>
                            <option value="Skid Steer Loader" {{ old('type') == 'Skid Steer Loader' ? 'selected' : '' }}>Skid Steer Loader</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

                    <!-- Technical Specifications Section -->
                    <div class="modern-card animate-stagger">
                        <div class="modern-card-header">
                            <h3 class="modern-card-title">
                                <i class="fas fa-cogs"></i>
                                {{ __('products.technical_specifications') }}
                            </h3>
                    </div>
                        <div class="modern-card-body">
                            <div class="form-grid-3">
                    <div class="modern-form-group">
                        <label for="body_weight" class="modern-label">
                            <i class="fas fa-weight mobile-icon"></i>
                            {{ __('products.body_weight') }}
                        </label>
                        <input type="text"
                                class="modern-input @error('body_weight') is-invalid @enderror"
                               id="body_weight"
                               name="body_weight"
                               value="{{ old('body_weight') }}"
                               placeholder="{{ __('products.body_weight_placeholder') }}">
                        @error('body_weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="operating_weight" class="modern-label">
                                        <i class="fas fa-weight-hanging mobile-icon"></i>
                            {{ __('products.operating_weight') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('operating_weight') is-invalid @enderror"
                               id="operating_weight"
                               name="operating_weight"
                               value="{{ old('operating_weight') }}"
                               placeholder="{{ __('products.operating_weight_placeholder') }}">
                        @error('operating_weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="overall_length" class="modern-label">
                                        <i class="fas fa-ruler-horizontal mobile-icon"></i>
                            {{ __('products.overall_length') }}
                        </label>
                        <input type="text"
                                class="modern-input @error('overall_length') is-invalid @enderror"
                               id="overall_length"
                               name="overall_length"
                               value="{{ old('overall_length') }}"
                               placeholder="{{ __('products.overall_length_placeholder') }}">
                        @error('overall_length')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="overall_width" class="modern-label">
                                        <i class="fas fa-arrows-alt-h mobile-icon"></i>
                            {{ __('products.overall_width') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('overall_width') is-invalid @enderror"
                               id="overall_width"
                               name="overall_width"
                               value="{{ old('overall_width') }}"
                               placeholder="{{ __('products.overall_width_placeholder') }}">
                        @error('overall_width')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="overall_height" class="modern-label">
                                        <i class="fas fa-arrows-alt-v mobile-icon"></i>
                            {{ __('products.overall_height') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('overall_height') is-invalid @enderror"
                               id="overall_height"
                               name="overall_height"
                               value="{{ old('overall_height') }}"
                               placeholder="{{ __('products.overall_height_placeholder') }}">
                        @error('overall_height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="required_oil_flow" class="modern-label">
                                        <i class="fas fa-tint mobile-icon"></i>
                            {{ __('products.required_oil_flow') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('required_oil_flow') is-invalid @enderror"
                               id="required_oil_flow"
                               name="required_oil_flow"
                               value="{{ old('required_oil_flow') }}"
                               placeholder="{{ __('products.required_oil_flow_placeholder') }}">
                        @error('required_oil_flow')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="operating_pressure" class="modern-label">
                                        <i class="fas fa-gauge-high mobile-icon"></i>
                            {{ __('products.operating_pressure') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('operating_pressure') is-invalid @enderror"
                               id="operating_pressure"
                               name="operating_pressure"
                               value="{{ old('operating_pressure') }}"
                               placeholder="{{ __('products.operating_pressure_placeholder') }}">
                        @error('operating_pressure')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="impact_rate" class="modern-label">
                                        <i class="fas fa-bolt mobile-icon"></i>
                            {{ __('products.impact_rate') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('impact_rate') is-invalid @enderror"
                               id="impact_rate"
                               name="impact_rate"
                               value="{{ old('impact_rate') }}"
                               placeholder="{{ __('products.impact_rate_placeholder') }}">
                        @error('impact_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="impact_rate_soft_rock" class="modern-label">
                                        <i class="fas fa-mountain mobile-icon"></i>
                            {{ __('products.impact_rate_soft_rock') }}
                        </label>
                        <input type="text"
                                           class="modern-input @error('impact_rate_soft_rock') is-invalid @enderror"
                               id="impact_rate_soft_rock"
                               name="impact_rate_soft_rock"
                               value="{{ old('impact_rate_soft_rock') }}"
                               placeholder="{{ __('products.impact_rate_soft_rock_placeholder') }}">
                        @error('impact_rate_soft_rock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="hose_diameter" class="modern-label">
                                        <i class="fas fa-circle mobile-icon"></i>
                            {{ __('products.hose_diameter') }}
                        </label>
                        <input type="text"
                                class="modern-input @error('hose_diameter') is-invalid @enderror"
                               id="hose_diameter"
                               name="hose_diameter"
                               value="{{ old('hose_diameter') }}"
                               placeholder="{{ __('products.hose_diameter_placeholder') }}">
                        @error('hose_diameter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="rod_diameter" class="modern-label">
                            <i class="fas fa-minus mobile-icon"></i>
                            {{ __('products.rod_diameter') }}
                        </label>
                        <input type="text"
                               class="modern-input @error('rod_diameter') is-invalid @enderror"
                               id="rod_diameter"
                               name="rod_diameter"
                               value="{{ old('rod_diameter') }}"
                               placeholder="{{ __('products.rod_diameter_placeholder') }}">
                        @error('rod_diameter')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modern-form-group">
                        <label for="applicable_carrier" class="modern-label">
                            <i class="fas fa-truck mobile-icon"></i>
                            {{ __('products.applicable_carrier') }}
                        </label>
                        <input type="text"
                                class="modern-input @error('applicable_carrier') is-invalid @enderror"
                               id="applicable_carrier"
                               name="applicable_carrier"
                               value="{{ old('applicable_carrier') }}"
                               placeholder="{{ __('products.applicable_carrier_placeholder') }}">
                        @error('applicable_carrier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

                    <!-- Product Image Section -->
                    <div class="modern-card animate-stagger">
                        <div class="modern-card-header">
                            <h3 class="modern-card-title">
                        <i class="fas fa-images"></i>
                                {{ __('products.product_image') }}
                            </h3>
                    </div>
                        <div class="modern-card-body">
                            <div class="modern-form-group form-group-full">
                        <label for="product_image" class="modern-label">
                                    <i class="fas fa-upload mobile-icon"></i>
                            {{ __('products.product_image') }}
                        </label>
                                <div class="file-upload-container" id="fileUpload">
                            <input type="file"
                                   id="product_image"
                                   name="product_image"
                                           class="file-input @error('product_image') is-invalid @enderror"
                                   accept="image/*">
                                    <div class="file-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                    <div class="file-upload-text">
                                        <h4>{{ __('products.click_to_upload') }}</h4>
                                        <p>{{ __('products.drag_drop_or_click') }}</p>
                                </div>
                                    <div class="image-preview-grid" id="imagePreview"></div>
                        </div>
                        @error('product_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

                    <!-- Product Options Section -->
                    <div class="modern-card animate-stagger">
                        <div class="modern-card-header">
                            <h3 class="modern-card-title">
                        <i class="fas fa-toggle-on"></i>
                                {{ __('products.product_options') }}
                            </h3>
                    </div>
                        <div class="modern-card-body">
                            <div class="form-grid">
                    <div class="modern-form-group">
                                    <div class="checkbox-group">
                            <input type="hidden" name="is_active" value="0">
                                        <div class="checkbox-container">
                                <input type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                                   class="checkbox-input"
                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                            <div class="checkbox-custom"></div>
                                        </div>
                                        <label for="is_active" class="checkbox-label">
                                {{ __('products.active_product') }}
                            </label>
                        </div>
                    </div>
                    <div class="modern-form-group">
                                    <div class="checkbox-group">
                            <input type="hidden" name="is_featured" value="0">
                                        <div class="checkbox-container">
                                <input type="checkbox"
                                       id="is_featured"
                                       name="is_featured"
                                       value="1"
                                                   class="checkbox-input"
                                       {{ old('is_featured') ? 'checked' : '' }}>
                                            <div class="checkbox-custom"></div>
                                        </div>
                                        <label for="is_featured" class="checkbox-label">
                                {{ __('products.featured_product') }}
                            </label>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.products.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            <span class="mobile-text-hide">{{ __('products.cancel') }}</span>
                            <span class="d-md-none">{{ __('products.mobile_cancel') }}</span>
                        </a>
                        <button type="submit" class="modern-btn" id="submitBtn">
                            <i class="fas fa-save me-2"></i>
                            <span class="mobile-text-hide">{{ __('products.create_product') }}</span>
                            <span class="d-md-none">{{ __('products.mobile_save') }}</span>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form elements
    const createProductForm = document.getElementById('createProductForm');
    const submitBtn = document.getElementById('submitBtn');
    const formProgress = document.getElementById('formProgress');

    // File upload elements
    const fileInput = document.getElementById('product_image');
    const fileUpload = document.getElementById('fileUpload');
    const imagePreview = document.getElementById('imagePreview');

    // Required fields for progress tracking
    const requiredFields = ['model_name', 'category_id'];

    // Progress tracking
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

    // File upload functionality
    if (fileInput && fileUpload && imagePreview) {
        fileUpload.addEventListener('click', function(e) {
            if (e.target === fileInput) return;
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            handleFileSelect(this.files[0]);
        });

        fileUpload.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileUpload.classList.add('dragover');
        });

        fileUpload.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileUpload.classList.remove('dragover');
        });

        fileUpload.addEventListener('drop', function(e) {
            e.preventDefault();
            fileUpload.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0]);
            }
        });

        function handleFileSelect(file) {
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('{{ __('products.invalid_file_type') }}');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('{{ __('products.file_too_large') }}');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <div class="image-preview-item">
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="image-remove-btn" onclick="removeImage()">×</button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    }

    // Form submission handling
    createProductForm.addEventListener('submit', function(e) {
        if (!validateForm()) {
                e.preventDefault();

            // Scroll to first invalid field
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }

            // Show error notification
            showNotification('{{ __('products.please_correct_errors') }}', 'error');
                return;
            }

        // Perform SI to Imperial conversion before submission
        convertSIToImperial();

        // Show loading state
                submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><span class="mobile-text-hide">{{ __('products.saving') }}</span><span class="d-md-none">{{ __('products.saving') }}</span>';
        createProductForm.classList.add('loading');

        // Show conversion notification
        showNotification('Converting SI units to Imperial and saving...', 'info');
    });

    // Enhanced input interactions
    document.querySelectorAll('.modern-input, .modern-select, .modern-textarea').forEach(input => {
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
        }, index * 50);
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
        const savedValue = localStorage.getItem(`createProductForm_${input.name}`);
        if (savedValue && !input.value && input.name !== '_token') {
            input.value = savedValue;
        }

        // Save data on change
        input.addEventListener('change', function() {
            if (this.name !== '_token') {
                localStorage.setItem(`createProductForm_${this.name}`, this.value);
            }
        });
    });

    // Clear saved data on successful submission
    createProductForm.addEventListener('submit', function() {
        setTimeout(() => {
            formInputs.forEach(input => {
                if (input.name !== '_token') {
                    localStorage.removeItem(`createProductForm_${input.name}`);
                }
            });
        }, 1000);
    });

    // SI to Imperial Unit Conversion Functions (Exact factors from show.blade.php)
    function convertSIToImperial() {
        // Conversion factors matching exactly those used in show.blade.php
        const conversions = {
            // Weight: kg to lb (factor: 1/0.45359237)
            body_weight: { factor: 2.204622621849, siUnit: 'kg', impUnit: 'lb' },
            operating_weight: { factor: 2.204622621849, siUnit: 'kg', impUnit: 'lb' },

            // Length: mm to inches (factor: 1/25.4)
            overall_length: { factor: 0.03937007874, siUnit: 'mm', impUnit: 'in' },
            overall_width: { factor: 0.03937007874, siUnit: 'mm', impUnit: 'in' },
            overall_height: { factor: 0.03937007874, siUnit: 'mm', impUnit: 'in' },
            rod_diameter: { factor: 0.03937007874, siUnit: 'mm', impUnit: 'in' },

            // Oil flow: l/min to gal/min (factor: 1/3.785411784)
            required_oil_flow: { factor: 0.264172052358, siUnit: 'l/min', impUnit: 'gal/min' },

            // Pressure: kgf/cm² to psi (factor: 1/0.0703069578296)
            operating_pressure: { factor: 14.223343307087, siUnit: 'kgf/cm²', impUnit: 'psi' },

            // Applicable carrier: ton to lb (factor: 1/0.00045359237)
            applicable_carrier: { factor: 2204.622621849, siUnit: 'ton', impUnit: 'lb' }

            // Note: impact_rate and hose_diameter remain unchanged (BPM and inches respectively)
        };

        Object.keys(conversions).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && field.value.trim()) {
                const conversion = conversions[fieldName];
                const siValue = field.value.trim();

                // Handle range values (e.g., "20~40", "20-40", or "20 - 40")
                if (siValue.includes('~') || siValue.includes('-')) {
                    const separator = siValue.includes('~') ? '~' : '-';
                    const parts = siValue.split(separator).map(part => part.trim());

                    if (parts.length === 2) {
                        const min = parseFloat(parts[0]);
                        const max = parseFloat(parts[1]);

                        if (!isNaN(min) && !isNaN(max)) {
                            let minImperial, maxImperial;

                            // Special formatting for different units
                            if (fieldName === 'operating_pressure') {
                                // Pressure: format as whole numbers with commas for thousands
                                minImperial = Math.round(min * conversion.factor).toLocaleString();
                                maxImperial = Math.round(max * conversion.factor).toLocaleString();
                            } else if (fieldName === 'applicable_carrier') {
                                // Carrier: format as whole numbers with commas
                                minImperial = Math.round(min * conversion.factor).toLocaleString();
                                maxImperial = Math.round(max * conversion.factor).toLocaleString();
                            } else {
                                // Other units: 1 decimal place
                                minImperial = (min * conversion.factor).toFixed(1);
                                maxImperial = (max * conversion.factor).toFixed(1);
                            }

                            field.value = `${minImperial} ${separator} ${maxImperial}`;
                        }
                    }
                }
                // Handle single numeric values
                else if (!isNaN(parseFloat(siValue))) {
                    const numericValue = parseFloat(siValue);
                    let imperialValue;

                    // Special formatting for different units
                    if (fieldName === 'operating_pressure') {
                        // Pressure: format as whole numbers with commas
                        imperialValue = Math.round(numericValue * conversion.factor).toLocaleString();
                    } else if (fieldName === 'applicable_carrier') {
                        // Carrier: format as whole numbers with commas
                        imperialValue = Math.round(numericValue * conversion.factor).toLocaleString();
                    } else {
                        // Other units: 1 decimal place
                        imperialValue = (numericValue * conversion.factor).toFixed(1);
                    }

                    field.value = imperialValue;
                }
                // Non-numeric values remain unchanged
            }
        });
    }

    // Add unit labels and conversion info to help users
    function addUnitLabels() {
        // const unitLabels = {
        //     body_weight: 'Enter in kg ',
        //     operating_weight: 'Enter in kg ',
        //     overall_length: 'Enter in mm ',
        //     overall_width: 'Enter in mm ',
        //     overall_height: 'Enter in mm ',
        //     rod_diameter: 'Enter in mm ',
        //     required_oil_flow: 'Enter in l/min ',
        //     operating_pressure: 'Enter in kgf/cm² ',
        //     applicable_carrier: 'Enter in ton ',
        //     impact_rate: 'Enter in BPM ',
        //     impact_rate_soft_rock: 'Enter in ',
        //     hose_diameter: 'Enter in inches'
        // };

        Object.keys(unitLabels).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                // Update placeholder to show SI unit input expected
                const currentPlaceholder = field.getAttribute('placeholder');
                field.setAttribute('data-original-placeholder', currentPlaceholder);

                // Add unit info to placeholder based on exact format from screenshots
                if (fieldName === 'body_weight') {
                    field.setAttribute('placeholder', 'e.g., 54 kg');
                } else if (fieldName === 'operating_weight') {
                    field.setAttribute('placeholder', 'e.g., 104 kg');
                } else if (fieldName === 'overall_length') {
                    field.setAttribute('placeholder', 'e.g., 1135 mm');
                } else if (fieldName === 'overall_width') {
                    field.setAttribute('placeholder', 'e.g., 264 mm');
                } else if (fieldName === 'overall_height') {
                    field.setAttribute('placeholder', 'e.g., 296 mm');
                } else if (fieldName === 'rod_diameter') {
                    field.setAttribute('placeholder', 'e.g., 40 mm');
                } else if (fieldName === 'required_oil_flow') {
                    field.setAttribute('placeholder', 'e.g., 15 - 35 l/min');
                } else if (fieldName === 'operating_pressure') {
                    field.setAttribute('placeholder', 'e.g., 90 ~ 120 kgf/cm²');
                } else if (fieldName === 'applicable_carrier') {
                    field.setAttribute('placeholder', 'e.g., 0.8 ~ 2.5 ton');
                } else if (fieldName === 'impact_rate') {
                    field.setAttribute('placeholder', 'e.g., 800 ~ 1530 BPM');
                } else if (fieldName === 'impact_rate_soft_rock') {
                    field.setAttribute('placeholder', 'e.g., 800 ~ 1200 BPM');
                } else if (fieldName === 'hose_diameter') {
                    field.setAttribute('placeholder', 'e.g., 3/8, 1/2 in');
                }

                // Add title attribute for additional guidance
                field.setAttribute('title', unitLabels[fieldName]);

                // Add a small helper text below the field
                const helpText = document.createElement('small');
                helpText.className = 'form-text text-muted mt-1';
                helpText.textContent = unitLabels[fieldName];
                helpText.style.fontSize = '0.75rem';
                helpText.style.fontStyle = 'italic';

                // Insert after the field
                field.parentNode.insertBefore(helpText, field.nextSibling);
            }
        });
    }

    // Initialize unit labels
    addUnitLabels();

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
                createProductForm.dispatchEvent(new Event('submit'));
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

    // Observe form sections for scroll animations
    document.querySelectorAll('.animate-stagger').forEach(element => {
        observer.observe(element);
    });
});

// Function to remove image preview
function removeImage() {
    document.getElementById('product_image').value = '';
    document.getElementById('imagePreview').innerHTML = '';
}
</script>
@endsection
