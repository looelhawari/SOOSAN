@extends('layouts.admin')

@section('title', __('owners.create_owner'))

@section('content')
    <style>
        /* Reset and prevent inheritance from global styles */
        .owners-create-container * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .owners-create-container {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e5e7eb 100%);
            min-height: 100vh;
            padding: 2rem;
            color: #1f2937;
            line-height: 1.6;
        }

        /* Modern Header with Enhanced Animations */
        .owners-create-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin: -2rem -2rem 2rem -2rem;
            border-radius: 0 0 2rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }

        .owners-create-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%);
        }

        .owners-create-header-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .owners-create-title-section h1 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .owners-create-title-section p {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            opacity: 0.9;
            margin: 0;
        }

        .owners-back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 1rem 2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .owners-back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Enhanced Form Card */
        .owners-form-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(229, 231, 235, 0.6);
            overflow: hidden;
        }

        .owners-form-header {
            background: linear-gradient(135deg, #f8fafc, #e5e7eb);
            padding: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .owners-form-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .owners-form-header i {
            color: #667eea;
            font-size: 1.25rem;
        }

        .owners-form-body {
            padding: 2rem;
        }

        .owners-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .owners-form-group {
            display: flex;
            flex-direction: column;
        }

        .owners-form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .owners-form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: white;
        }

        .owners-form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .owners-form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .owners-invalid-feedback {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .owners-invalid-feedback::before {
            content: '⚠';
            font-size: 0.875rem;
        }

        .owners-form-section {
            background: linear-gradient(135deg, #f8fafc, #ffffff);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid #667eea;
            border: 1px solid rgba(229, 231, 235, 0.6);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .owners-form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .owners-form-section h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
        }

        .owners-form-section h3::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, #667eea, transparent);
            margin-left: 1rem;
        }

        .owners-form-section i {
            color: #667eea;
        }

        /* Enhanced Image Upload Section */
        .owners-image-upload-container {
            display: flex;
            align-items: center;
            gap: 2rem;
            background: linear-gradient(135deg, #f8fafc, #ffffff);
            padding: 2rem;
            border-radius: 1rem;
            border: 2px dashed #e5e7eb;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .owners-image-upload-container:hover {
            border-color: #667eea;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.1);
        }

        .owners-image-preview-wrapper {
            flex-shrink: 0;
        }

        .owners-image-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            background-color: #e5e7eb;
            transition: all 0.3s ease;
        }

        .owners-image-preview:hover {
            transform: scale(1.05);
        }

        .owners-image-upload-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }

        .owners-image-upload-input {
            display: none;
        }

        .owners-btn.secondary-outline {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            cursor: pointer;
        }

        .owners-btn.secondary-outline:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .owners-form-text {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            line-height: 1.4;
        }

        .owners-form-text::before {
            content: 'ℹ';
            color: #667eea;
            font-weight: bold;
        }

        .owners-form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc, #e5e7eb);
            border-top: 1px solid #e5e7eb;
            margin: 0 -2rem -2rem -2rem;
        }

        .owners-btn {
            padding: 0.875rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .owners-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .owners-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .owners-btn.secondary {
            background: #6b7280;
            color: white;
        }

        .owners-btn.secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
            color: white;
        }

        /* Required asterisk */
        .owners-required {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1024px) {
            .owners-form-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.25rem;
            }

            .owners-image-upload-container {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
                padding: 1.5rem;
            }

            .owners-image-upload-actions {
                width: 100%;
                max-width: 320px;
                margin: 0 auto;
            }

            .owners-image-preview {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 768px) {
            .owners-create-container {
                padding: 1rem;
            }

            .owners-create-header {
                margin: -1rem -1rem 1.5rem -1rem;
                padding: 2rem 0;
            }

            .owners-create-header-content {
                flex-direction: column;
                text-align: center;
                padding: 0 1rem;
                gap: 1.5rem;
            }

            .owners-form-body {
                padding: 1.5rem;
            }

            .owners-form-section {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .owners-form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .owners-form-actions {
                flex-direction: column;
                gap: 0.75rem;
                padding: 1.5rem;
            }

            .owners-btn {
                justify-content: center;
                padding: 1rem 1.5rem;
            }

            .owners-image-upload-container {
                padding: 1.25rem;
                gap: 1.25rem;
            }

            .owners-image-preview {
                width: 90px;
                height: 90px;
            }

            .owners-form-section h3 {
                font-size: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .owners-form-section h3::after {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .owners-create-container {
                padding: 0.75rem;
            }

            .owners-create-header {
                margin: -0.75rem -0.75rem 1rem -0.75rem;
                padding: 1.5rem 0;
            }

            .owners-create-header-content {
                padding: 0 0.75rem;
                gap: 1rem;
            }

            .owners-form-body {
                padding: 1rem;
            }

            .owners-form-section {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .owners-form-actions {
                padding: 1rem;
            }

            .owners-btn {
                padding: 0.875rem 1.25rem;
                font-size: 0.875rem;
            }

            .owners-image-upload-container {
                padding: 1rem;
                gap: 1rem;
                flex-direction: column;
            }

            .owners-image-preview {
                width: 80px;
                height: 80px;
            }

            .owners-form-text {
                font-size: 0.7rem;
                text-align: center;
                justify-content: center;
            }

            .owners-btn.secondary-outline {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                width: 100%;
            }

            .owners-image-upload-actions {
                width: 100%;
                max-width: none;
            }
        }
    </style>

    <div class="owners-create-container">
        <!-- Page Header -->
        <div class="owners-create-header">
            <div class="owners-create-header-content">
                <div class="owners-create-title-section">
                    <h1><i class="fas fa-user-plus"></i> {{ __('owners.create_new_owner') }}</h1>
                    <p>{{ __('owners.add_new_owner') }}</p>
                </div>
                <a href="{{ route('admin.owners.index') }}" class="owners-back-btn">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('owners.back_to_owners') }}
                </a>
            </div>
        </div>

        <!-- Owner Form -->
        <div class="owners-form-card">
            <div class="owners-form-header">
                <h2><i class="fas fa-user-edit"></i> {{ __('owners.owner_information') }}</h2>
            </div>

            <form action="{{ route('admin.owners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="owners-form-body">
                    <!-- Company Logo Section -->
                    <div class="owners-form-section">
                        <h3><i class="fas fa-image"></i> {{ __('owners.company_logo') }}</h3>
                        <div class="owners-image-upload-container">
                            <div class="owners-image-preview-wrapper">
                                <img id="imagePreview" src="{{ asset('images/default-building.svg') }}"
                                    alt="{{ __('owners.company_logo') }}" class="owners-image-preview">
                            </div>
                            <div class="owners-image-upload-actions">
                                <label for="company_image" class="owners-btn secondary-outline">
                                    <i class="fas fa-upload"></i> {{ __('owners.upload_logo') }}
                                </label>
                                <input type="file" name="company_image" id="company_image"
                                    class="owners-image-upload-input" accept="image/png, image/jpeg, image/jpg, image/webp">
                                <p class="owners-form-text">{{ __('owners.image_supported_formats_with_max_size') }}</p>
                                @error('company_image')
                                    <div class="owners-invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information Section -->
                    <div class="owners-form-section">
                        <h3><i class="fas fa-user"></i> {{ __('owners.basic_information') }}</h3>
                        <div class="owners-form-grid">
                            <div class="owners-form-group">
                                <label for="name">{{ __('owners.name') }} <span
                                        class="owners-required">*</span></label>
                                <input type="text" class="owners-form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="{{ __('owners.enter_name') }}" required>
                                @error('name')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="owners-form-group">
                                <label for="email">{{ __('owners.email') }}</label>
                                <input type="email" class="owners-form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="{{ __('owners.enter_email') }}"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="owners-form-section">
                        <h3><i class="fas fa-address-book"></i> {{ __('owners.contact_information') }}</h3>
                        <div class="owners-form-grid">
                            <div class="owners-form-group">
                                <label for="phone_number">{{ __('owners.phone') }}</label>
                                <input type="text"
                                    class="owners-form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                    placeholder="{{ __('owners.enter_phone') }}">
                                @error('phone_number')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="owners-form-group">
                                <label for="company">{{ __('owners.company') }}</label>
                                <input type="text" class="owners-form-control @error('company') is-invalid @enderror"
                                    id="company" name="company" placeholder="{{ __('owners.enter_company') }}"
                                    value="{{ old('company') }}">
                                @error('company')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location Information Section -->
                    <div class="owners-form-section">
                        <h3><i class="fas fa-map-marker-alt"></i> {{ __('owners.location_information') }}</h3>
                        <div class="owners-form-grid">
                            <div class="owners-form-group">
                                <label for="address">{{ __('owners.address') }}</label>
                                <textarea class="owners-form-control @error('address') is-invalid @enderror" id="address" name="address"
                                    placeholder="{{ __('owners.enter_address') }}" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="owners-form-group">
                                <label for="city">{{ __('owners.city') }}</label>
                                <input type="text" class="owners-form-control @error('city') is-invalid @enderror"
                                    id="city" name="city" placeholder="{{ __('owners.enter_city') }}"
                                    value="{{ old('city') }}">
                                @error('city')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="owners-form-group">
                                <label for="country">{{ __('owners.country') }}</label>
                                <input type="text" class="owners-form-control @error('country') is-invalid @enderror"
                                    id="country" name="country" placeholder="{{ __('owners.enter_country') }}"
                                    value="{{ old('country') }}">
                                @error('country')
                                    <div class="owners-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Preferences Section -->

                </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="owners-form-actions">
        <a href="{{ route('admin.owners.index') }}" class="owners-btn secondary">
            <i class="fas fa-times"></i>
            {{ __('owners.cancel') }}
        </a>
        <button type="submit" class="owners-btn primary">
            <i class="fas fa-save"></i>
            {{ __('owners.create_owner') }}
        </button>
    </div>
    </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced loading state for form submission
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('owners.creating') }}';

                // Re-enable after 5 seconds in case of network issues
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }, 5000);
            });

            // Auto-focus first input with smooth animation
            const firstInput = document.querySelector('#name');
            if (firstInput) {
                setTimeout(() => {
                    firstInput.focus();
                }, 300);
            }

            // Enhanced image preview logic
            const imageInput = document.getElementById('company_image');
            const imagePreview = document.getElementById('imagePreview');
            const defaultImage = '{{ asset('images/default-building.svg') }}';
            const uploadContainer = document.querySelector('.owners-image-upload-container');

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Validate file size (max 5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('{{ __('owners.image_too_large') }}');
                            this.value = '';
                            return;
                        }

                        // Validate file type
                        if (!file.type.match(/image\/(png|jpeg|jpg|webp)/)) {
                            alert('{{ __('owners.invalid_image_format') }}');
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.style.opacity = '0';
                            setTimeout(() => {
                                imagePreview.src = e.target.result;
                                imagePreview.style.opacity = '1';
                            }, 150);
                        }
                        reader.readAsDataURL(file);

                        // Add success state to container
                        uploadContainer.style.borderColor = '#10b981';
                        uploadContainer.style.backgroundColor = 'rgba(16, 185, 129, 0.05)';
                    } else {
                        imagePreview.src = defaultImage;
                        uploadContainer.style.borderColor = '#e5e7eb';
                        uploadContainer.style.backgroundColor = 'transparent';
                    }
                });
            }

            // Enhanced form validation feedback
            const formControls = document.querySelectorAll('.owners-form-control');
            formControls.forEach(control => {
                control.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                        const feedback = this.parentNode.querySelector('.owners-invalid-feedback');
                        if (feedback) {
                            feedback.style.opacity = '0';
                            setTimeout(() => {
                                feedback.style.display = 'none';
                            }, 300);
                        }
                    }
                });
            });
        });
    </script>
@endsection
