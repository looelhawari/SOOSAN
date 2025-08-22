@extends('layouts.admin')

@section('title', __('users.edit_user'))

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
    .dark-mode .modern-container {
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
    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-items: center;
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
    .dark-mode .modern-card {
        background: rgba(45, 55, 72, 0.95);
        border-color: rgba(74, 85, 104, 0.3);
    }

    /* Form Styles */
    .modern-form-group {
        width: 94%;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .modern-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }
    .dark-mode .modern-label {
        color: #d1d5db;
    }
    .modern-input {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1rem;
        color: #1a202c;
        backdrop-filter: blur(5px);
    }
    .modern-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
        background: rgba(255, 255, 255, 1);
    }
    .modern-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    .dark-mode .modern-input {
        background: rgba(45, 55, 72, 0.9);
        border-color: #4a5568;
        color: #f7fafc;
    }
    .dark-mode .modern-input:focus {
        border-color: #667eea;
        background: rgba(45, 55, 72, 1);
    }
    .modern-select {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1rem;
        color: #1a202c;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        backdrop-filter: blur(5px);
    }
    .modern-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: rgba(255, 255, 255, 1);
    }
    .dark-mode .modern-select {
        background: rgba(45, 55, 72, 0.9);
        border-color: #4a5568;
        color: #f7fafc;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23f7fafc' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }
    .dark-mode .modern-select:focus {
        border-color: #667eea;
        background: rgba(45, 55, 72, 1);
    }

    /* Checkbox Styles */
    .modern-checkbox {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .modern-checkbox:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }
    .dark-mode .modern-checkbox {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border-color: #4a5568;
    }
    .dark-mode .modern-checkbox:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, #3730a3 0%, #4338ca 100%);
    }
    .modern-checkbox input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #667eea;
        border-radius: 6px;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }
    .modern-checkbox input[type="checkbox"]:checked {
        background: #667eea;
        border-color: #667eea;
    }
    .modern-checkbox input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #ffffff;
        font-size: 0.875rem;
        font-weight: bold;
    }
    .dark-mode .modern-checkbox input[type="checkbox"] {
        background: #2d3748;
        border-color: #667eea;
    }

    /* Buttons */
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: #ffffff;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
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
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: #ffffff;
    }
    .modern-btn-secondary {
        background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
    }
    .modern-btn-secondary:hover {
        box-shadow: 0 10px 25px rgba(113, 128, 150, 0.4);
    }

    /* User Avatar */
    .user-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 700;
        font-size: 3rem;
        margin: 0 auto 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        transition: transform 0.3s ease;
    }
    .user-avatar-large:hover {
        transform: scale(1.05) rotate(5deg);
    }

    /* Validation Styles */
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
        font-weight: 500;
    }
    .password-help {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
        font-style: italic;
    }
    .dark-mode .password-help {
        color: #9ca3af;
    }

    /* Focus Effects */
    .focused {
        transform: translateY(-2px);
    }
    .focused .modern-input,
    .focused .modern-select {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Responsive Design */
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
        .header-actions {
            justify-content: center;
        }
        .user-avatar-large {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }
        .modern-card .card-body {
            padding: 1.5rem !important;
        }
        .modern-checkbox {
            padding: 0.75rem;
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
        .modern-page-header h1 {
            font-size: 1.25rem;
        }
        .modern-page-header p {
            font-size: 0.875rem;
        }
        .modern-btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
        }
        .modern-input,
        .modern-select {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
        .modern-card .card-body {
            padding: 1rem !important;
        }
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

    .modern-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Focus and accessibility */
    .modern-input:focus,
    .modern-select:focus,
    .modern-btn:focus,
    .modern-checkbox:focus-within {
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
<div class="modern-container">
    <!-- Page Header -->
    <div class="modern-page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>
                        <i class="fas fa-user-edit"></i>
                        {{ __('users.edit_user') }}
                    </h1>
                    <p>{{ __('users.edit_user_description') }}</p>
                </div>
                <div class="col-lg-4">
                    <div class="header-actions">
                        <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            <span class="mobile-text">{{ __('users.back_to_users') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="modern-card">
                <div class="card-body p-4">
                    <!-- User Avatar -->
                    <div class="text-center mb-4">
                        <div class="user-avatar-large">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="name" class="modern-label">
                                        {{ __('users.name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="modern-input @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        placeholder="{{ __('users.name_placeholder') }}"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="email" class="modern-label">
                                        {{ __('users.email') }} <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        class="modern-input @error('email') is-invalid @enderror"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                        placeholder="{{ __('users.email_placeholder') }}"
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="password" class="modern-label">
                                        {{ __('users.new_password') }}
                                    </label>
                                    <input
                                        type="password"
                                        class="modern-input @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="{{ __('users.new_password_placeholder') }}"
                                    >
                                    <small class="password-help">{{ __('users.password_help') }}</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="password_confirmation" class="modern-label">
                                        {{ __('users.confirm_password') }}
                                    </label>
                                    <input
                                        type="password"
                                        class="modern-input"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="{{ __('users.confirm_password_placeholder') }}"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label for="role" class="modern-label">
                                        {{ __('users.role') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="modern-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">{{ __('users.select_role') }}</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                            {{ __('users.admin') }}
                                        </option>
                                        <option value="employee" {{ old('role', $user->role) === 'employee' ? 'selected' : '' }}>
                                            {{ __('users.employee') }}
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label class="modern-label">{{ __('users.account_status') }}</label>
                                    <div class="modern-checkbox">
                                        <input type="hidden" name="is_verified" value="0">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="is_verified"
                                            name="is_verified"
                                            value="1"
                                            {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="is_verified">
                                            <strong>{{ __('users.account_verified') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ __('users.account_verified_description') }}</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <a href="{{ route('admin.users.index') }}" class="modern-btn modern-btn-secondary">
                                        <i class="fas fa-times"></i>
                                        <span class="mobile-text">{{ __('users.cancel') }}</span>
                                    </a>
                                    <button type="submit" class="modern-btn">
                                        <i class="fas fa-save"></i>
                                        <span class="mobile-text">{{ __('users.update_user') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('editUserForm');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');

    form.addEventListener('submit', function(e) {
        if (passwordField.value && passwordField.value !== confirmPasswordField.value) {
            e.preventDefault();
            alert('{{ __('users.passwords_do_not_match') }}');
            confirmPasswordField.focus();
            confirmPasswordField.classList.add('is-invalid');
        }
    });

    // Password confirmation validation
    confirmPasswordField.addEventListener('input', function() {
        if (passwordField.value && this.value && passwordField.value !== this.value) {
            this.setCustomValidity('{{ __('users.passwords_do_not_match') }}');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });

    // Enhanced focus effects
    const inputs = document.querySelectorAll('.modern-input, .modern-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Add loading state to form submission
    form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span class="mobile-text">{{ __('users.updating') }}</span>';

            // Reset after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            }, 5000);
        }
    });

    // Real-time validation feedback
    const nameField = document.getElementById('name');
    const emailField = document.getElementById('email');

    nameField.addEventListener('input', function() {
        if (this.value.length < 2) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    emailField.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.value)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
        if (e.key === 'Escape') {
            const cancelButton = document.querySelector('a[href*="users.index"]');
            if (cancelButton) {
                cancelButton.click();
            }
        }
    });
});
</script>
@endpush
@endsection
