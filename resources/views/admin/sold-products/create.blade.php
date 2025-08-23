@extends('layouts.admin')

@section('title', __('sold-products.create_sale'))
@section('page-title', __('sold-products.add_new_sale'))

@section('content')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            --warning-gradient: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            --danger-gradient: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            --secondary-gradient: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            --border-radius: 1rem;
            --border-radius-sm: 0.5rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
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
        }

        .modern-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .modern-input,
        .modern-select {
            width: 100%;
            padding: 0.875rem 1.125rem;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius-sm);
            background: #fff;
            transition: var(--transition);
            font-size: 1rem;
        }

        .modern-input:focus,
        .modern-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .modern-input:hover,
        .modern-select:hover {
            border-color: #ced4da;
        }

        .modern-input.is-invalid,
        .modern-select.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
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

        .modern-btn-danger {
            background: var(--danger-gradient);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
            padding: 1rem 1.5rem;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
        }

        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .modern-page-header {
                padding: 2rem 0;
                margin: -1rem -1rem 1.5rem;
            }

            .modern-page-header .row>div {
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

            .modern-card .card-body,
            .modern-card .card-header {
                padding: 1rem;
            }

            .modern-input,
            .modern-select {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .modern-btn {
                width: 100%;
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .modern-form-group {
                margin-bottom: 1.25rem;
            }

            .modern-label {
                font-size: 0.8rem;
            }

            /* Mobile form layout */
            .row.g-4>div {
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
        }

        @media (max-width: 576px) {
            .modern-page-header {
                margin: -0.5rem -0.5rem 1rem;
                padding: 1.5rem 0;
            }

            .modern-card {
                margin-bottom: 1rem;
            }

            .modern-card .card-body,
            .modern-card .card-header {
                padding: 0.75rem;
            }

            .modern-input,
            .modern-select {
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
            .alert {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 375px) {
            .modern-page-header {
                padding: 1rem 0;
            }

            .modern-input,
            .modern-select {
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

            .modern-input,
            .modern-select {
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

        .animate-stagger:nth-child(1) {
            animation-delay: 0.1s;
        }

        .animate-stagger:nth-child(2) {
            animation-delay: 0.2s;
        }

        .animate-stagger:nth-child(3) {
            animation-delay: 0.3s;
        }

        .animate-stagger:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* Loading states */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {

            .modern-btn:hover,
            .modern-card:hover,
            .modern-input:hover,
            .modern-select:hover {
                transform: none;
            }

            .modern-btn:active {
                transform: scale(0.95);
            }

            .modern-input:focus,
            .modern-select:focus {
                transform: none;
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
    </style>

    <!-- Page Header -->
    <div class="modern-page-header animate-fade-in-up">
        <div class="container-fluid position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 mb-2">{{ __('sold-products.add_new_sale') }}</h1>
                    <p class="mb-0 opacity-75">{{ __('sold-products.update_information') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        <span class="d-none d-sm-inline">{{ __('sold-products.back_to_sales') }}</span>
                        <span class="d-sm-none">{{ __('sold-products.back_to_sales') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modern-card animate-stagger">
        <div class="card-header bg-white border-bottom p-4">
            <h5 class="mb-0">
                <i class="fas fa-shopping-cart me-2"></i>
                {{ __('sold-products.sale_information') }}
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.sold-products.store') }}" method="POST" id="saleForm">
                @csrf

                <div class="row g-4">

                    <!-- Employee Owner Check Notice -->
                    <div class="col-12 mb-3">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>{{ __('sold-products.create_employee_note_title') }}</strong>
                            {{ __('sold-products.create_employee_note_body') }}
                            <a href="{{ route('admin.owners.create') }}"
                                class="text-primary text-decoration-underline">{{ __('sold-products.create_employee_note_link') }}</a>.
                            {{ __('sold-products.create_employee_note_footer') }}
                        </div>
                    </div>

                    <!-- Product Selection -->
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label for="product_id" class="modern-label">
                                <i class="fas fa-box mobile-icon"></i>
                                {{ __('sold-products.product') }} <span class="text-danger">*</span>
                            </label>
                            <select class="modern-select @error('product_id') is-invalid @enderror" id="product_id"
                                name="product_id" required>
                                <option value="">{{ __('sold-products.select_product') }}</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
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
                        <div class="modern-form-group">
                            <label for="owner_id" class="modern-label">
                                <i class="fas fa-user mobile-icon"></i>
                                {{ __('sold-products.owner') }} <span class="text-danger">*</span>
                            </label>
                            <select class="modern-select @error('owner_id') is-invalid @enderror" id="owner_id"
                                name="owner_id" required>
                                <option value="">{{ __('sold-products.select_owner') }}</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}"
                                        {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }} - {{ $owner->phone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('owner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sale Information Notice -->
                    <div class="col-12 mb-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>{{ __('sold-products.sale_recored_by') }}</strong> {{ auth()->user()->name }}
                            ({{ ucfirst(auth()->user()->role) }})
                        </div>
                    </div>

                    <!-- Serial Number -->
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label for="serial_number" class="modern-label">
                                <i class="fas fa-barcode mobile-icon"></i>
                                {{ __('sold-products.serial_number') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="modern-input @error('serial_number') is-invalid @enderror"
                                id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                                placeholder="{{ __('sold-products.enter_serial_number') }}" required>
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sale Date -->
                    <div class="col-md-4 col-sm-6">
                        <div class="modern-form-group">
                            <label for="sale_date" class="modern-label">
                                <i class="fas fa-calendar mobile-icon"></i>
                                {{ __('sold-products.sale_date') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="modern-input @error('sale_date') is-invalid @enderror"
                                id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                            @error('sale_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Warranty Start Date -->
                    <div class="col-md-4 col-sm-6">
                        <div class="modern-form-group">
                            <label for="warranty_start_date" class="modern-label">
                                <i class="fas fa-calendar-check mobile-icon"></i>
                                {{ __('sold-products.warranty_start') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="modern-input @error('warranty_start_date') is-invalid @enderror"
                                id="warranty_start_date" name="warranty_start_date"
                                value="{{ old('warranty_start_date', date('Y-m-d')) }}" required>
                            @error('warranty_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Warranty End Date -->
                    <div class="col-md-4 col-sm-6">
                        <div class="modern-form-group">
                            <label for="warranty_end_date" class="modern-label">
                                <i class="fas fa-calendar-times mobile-icon"></i>
                                {{ __('sold-products.warranty_end') }} <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="modern-input @error('warranty_end_date') is-invalid @enderror"
                                id="warranty_end_date" name="warranty_end_date" value="{{ old('warranty_end_date') }}"
                                required>
                            @error('warranty_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Purchase Price -->
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label for="purchase_price" class="modern-label">
                                <i class="fas fa-dollar-sign mobile-icon"></i>
                                {{ __('sold-products.purchase_price') }}
                            </label>
                            <input type="number" step="0.01" min="0"
                                class="modern-input @error('purchase_price') is-invalid @enderror" id="purchase_price"
                                name="purchase_price" value="{{ old('purchase_price') }}" placeholder="0.00">
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="col-md-6">
                        <div class="modern-form-group">
                            <label for="quantity" class="modern-label">
                                <i class="fas fa-sort-numeric-up mobile-icon"></i>
                                {{ __('sold-products.quantity') }}
                            </label>
                            <input type="number" min="1"
                                class="modern-input @error('quantity') is-invalid @enderror" id="quantity"
                                name="quantity" value="{{ old('quantity', 1) }}" placeholder="1">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <div class="modern-form-group">
                            <label for="notes" class="modern-label">
                                <i class="fas fa-sticky-note mobile-icon"></i>
                                {{ __('sold-products.notes') }}
                            </label>
                            <textarea class="modern-input @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                placeholder="{{ __('sold-products.additional_notes_placeholder') }}">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.sold-products.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times me-2"></i>
                        {{ __('sold-products.cancel') }}
                    </a>
                    <button type="submit" class="modern-btn" id="submitBtn">
                        <i class="fas fa-save me-2"></i>
                        <span class="d-none d-sm-inline">{{ __('sold-products.create_sale') }}</span>
                        <span class="d-sm-none">{{ __('sold-products.create_sale') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-calculate warranty end date when warranty start date changes
            const warrantyStartInput = document.getElementById('warranty_start_date');
            const warrantyEndInput = document.getElementById('warranty_end_date');
            const saleForm = document.getElementById('saleForm');
            const submitBtn = document.getElementById('submitBtn');

            warrantyStartInput.addEventListener('change', function() {
                if (this.value && !warrantyEndInput.value) {
                    // Default to 1 year warranty
                    const startDate = new Date(this.value);
                    const endDate = new Date(startDate);
                    endDate.setFullYear(endDate.getFullYear() + 1);
                    warrantyEndInput.value = endDate.toISOString().split('T')[0];

                    // Visual feedback
                    warrantyEndInput.style.borderColor = '#28a745';
                    setTimeout(() => {
                        warrantyEndInput.style.borderColor = '#e9ecef';
                    }, 1000);
                }
            });

            // Form validation enhancements
            const requiredFields = ['product_id', 'owner_id', 'serial_number', 'sale_date', 'warranty_start_date',
                'warranty_end_date'
            ];

            function validateField(field) {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    element.classList.add('is-invalid');
                    return false;
                } else {
                    element.classList.remove('is-invalid');
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

            // Real-time validation
            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.addEventListener('blur', function() {
                        validateField(field);
                    });

                    element.addEventListener('input', function() {
                        if (this.classList.contains('is-invalid')) {
                            validateField(field);
                        }
                    });
                }
            });

            // Date validation
            const saleDateInput = document.getElementById('sale_date');

            function validateDates() {
                const saleDate = new Date(saleDateInput.value);
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

            [saleDateInput, warrantyStartInput, warrantyEndInput].forEach(input => {
                if (input) {
                    input.addEventListener('change', validateDates);
                }
            });

            // Form submission handling
            saleForm.addEventListener('submit', function(e) {
                if (!validateForm() || !validateDates()) {
                    e.preventDefault();

                    // Scroll to first invalid field
                    const firstInvalid = document.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstInvalid.focus();
                    }

                    // Show error message
                    showNotification('Please correct the errors below', 'error');
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
                saleForm.classList.add('loading');
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
            const formData = {};

            formInputs.forEach(input => {
                // Load saved data
                const savedValue = localStorage.getItem(`saleForm_${input.name}`);
                if (savedValue && !input.value) {
                    input.value = savedValue;
                }

                // Save data on change
                input.addEventListener('change', function() {
                    localStorage.setItem(`saleForm_${this.name}`, this.value);
                });
            });

            // Clear saved data on successful submission
            saleForm.addEventListener('submit', function() {
                setTimeout(() => {
                    formInputs.forEach(input => {
                        localStorage.removeItem(`saleForm_${input.name}`);
                    });
                }, 1000);
            });

            // Notification system
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className =
                    `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
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
                        saleForm.dispatchEvent(new Event('submit'));
                    }
                }
            });
        });
    </script>
@endsection
