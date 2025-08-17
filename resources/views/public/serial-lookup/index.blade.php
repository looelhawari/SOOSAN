@extends('layouts.public')
@vite(['resources/css/app.css', 'resources/js/app.js'])


@section('title', 'Equipment Warranty Check & Serial Lookup - SoosanEgypt')
@section('description', 'Check your equipment warranty status, ownership information, and service history with our
    serial lookup tool. Verify Soosan hydraulic breakers and drilling equipment coverage instantly.')
@section('keywords', 'equipment warranty check, serial lookup, hydraulic breaker warranty, drilling equipment
    verification, Soosan warranty, equipment coverage, service history')
@section('og_image', asset('images/logo2.png'))

@push('structured_data')
    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "SoosanEgypt Serial Lookup",
    "description": "Check equipment warranty status and service history",
    "url": "{{ url('/serial-lookup') }}",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web Browser",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>

    <script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "Serial Lookup",
            "item": "{{ url('/serial-lookup') }}"
        }
    ]
}
</script>
@endpush

@push('meta')
    <meta name="keywords" content="serial lookup, warranty check, equipment coverage, Soosan, hydraulic breakers">
    <meta property="og:title" content="{{ __('common.serial_lookup_title') }} - Soosan Cebotics">
    <meta property="og:description" content="{{ __('common.serial_lookup_subtitle') }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary">
    <meta name="robots" content="index, follow">
@endpush

@push('styles')
    <style>
        :root {
            --primary-blue: #00548e;
            --accent-green: #b0d701;
            --gradient-primary: linear-gradient(135deg, #00548e 0%, #0066a3 100%);
            --gradient-accent: linear-gradient(135deg, #b0d701 0%, #9bc600 100%);
            --shadow-primary: 0 20px 60px rgba(0, 84, 142, 0.15);
            --shadow-hover: 0 30px 80px rgba(0, 84, 142, 0.25);
            --border-radius: 24px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(0, 84, 142, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(176, 215, 1, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(0, 84, 142, 0.05) 0%, transparent 50%);
            z-index: -1;
            animation: backgroundFloat 20s ease-in-out infinite;
        }

        @keyframes backgroundFloat {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(1deg);
            }

            66% {
                transform: translateY(10px) rotate(-1deg);
            }
        }

        /* Hero Section */
        .lookup-hero {
            background: var(--gradient-primary);
            color: white;
            padding: 6rem 0 4rem;
            position: relative;
            overflow: hidden;
            /* clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%); */
        }

        .lookup-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)" /></svg>');
            opacity: 0.3;
            animation: gridMove 30s linear infinite;
        }

        @keyframes gridMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(60px, 60px);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: iconFloat 6s ease-in-out infinite;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #ffffff, #b0d701);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: titleGlow 3s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% {
                filter: drop-shadow(0 0 20px rgba(176, 215, 1, 0.3));
            }

            100% {
                filter: drop-shadow(0 0 30px rgba(176, 215, 1, 0.6));
            }
        }

        /* Main Lookup Form */
        .main-container {
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }

        .lookup-form {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-primary);
            border: 1px solid rgba(0, 84, 142, 0.1);
            padding: 3rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            margin-top: 50px;
        }

        .lookup-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(176, 215, 1, 0.1), transparent);
            transition: left 0.8s ease;
        }

        .lookup-form:hover::before {
            left: 100%;
        }

        .lookup-form:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .form-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-accent);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: var(--primary-blue);
            font-size: 2rem;
            box-shadow: 0 8px 32px rgba(176, 215, 1, 0.3);
            animation: formIconPulse 4s ease-in-out infinite;
        }

        @keyframes formIconPulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 8px 32px rgba(176, 215, 1, 0.3);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 12px 40px rgba(176, 215, 1, 0.5);
            }
        }

        .serial-input {
            border: 3px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            transition: var(--transition);
            background: #fafafa;
            position: relative;
        }

        .serial-input:focus {
            border-color: var(--primary-blue);
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 84, 142, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .lookup-btn {
            background: var(--gradient-primary);
            border: none;
            border-radius: 16px;
            padding: 1.25rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 700;
            color: white;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 84, 142, 0.3);
        }

        .lookup-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .lookup-btn:hover::before {
            left: 100%;
        }

        .lookup-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 16px 48px rgba(0, 84, 142, 0.4);
            background: var(--gradient-accent);
            color: var(--primary-blue);
        }

        .lookup-btn:active {
            transform: translateY(-2px) scale(0.98);
        }

        /* Sample Serials */
        .sample-serials {
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.05), rgba(176, 215, 1, 0.05));
            border-radius: 20px;
            padding: 2rem;
            border: 2px solid rgba(0, 84, 142, 0.1);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .sample-serials::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
            border-radius: 2px;
        }

        .sample-serial {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            margin: 0.5rem;
            display: inline-block;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }

        .sample-serial::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .sample-serial:hover::before {
            left: 0;
        }

        .sample-serial:hover {
            color: white;
            transform: translateY(-4px) scale(1.05);
            border-color: var(--primary-blue);
            box-shadow: 0 8px 24px rgba(0, 84, 142, 0.3);
        }

        /* Info Cards */
        .info-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2.5rem;
            border: 2px solid rgba(0, 84, 142, 0.1);
            height: 100%;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-accent);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }

        .info-card:hover {
            transform: translateY(-12px);
            box-shadow: var(--shadow-hover);
            border-color: var(--accent-green);
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 12px;
            transition: var(--transition);
            position: relative;
            height: fit-content;
        }

        .feature-item:hover {
            background: rgba(0, 84, 142, 0.05);
            transform: translateX(8px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            font-size: 1.25rem;
            box-shadow: 0 4px 16px rgba(0, 84, 142, 0.3);
            transition: var(--transition);
            flex-shrink: 0;
            margin-left: 20px;
        }

        .feature-item:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            background: var(--gradient-accent);
            color: var(--primary-blue);
        }

        /* Loading States */
        .loading-spinner {
            display: none;
            animation: spin 1s linear infinite;
        }

        .loading .loading-spinner {
            display: inline-block;
        }

        .loading .btn-text {
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Support Buttons */
        .support-btn {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: var(--transition);
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }

        .support-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .support-btn:hover::before {
            left: 0;
        }

        .support-btn div small {
            color: #6c6262;
        }

        .support-btn:hover {
            color: white;
            border-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 84, 142, 0.3);
        }

        .support-btn:hover div small {
            color: #fff;
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 20%;
            right: 10%;
            animation-delay: 5s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 10s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-30px) rotate(120deg);
            }

            66% {
                transform: translateY(15px) rotate(240deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .lookup-hero {
                padding: 4rem 0 3rem;
            }

            .hero-icon {
                width: 80px;
                height: 80px;
                border-radius: 20px;
            }

            .lookup-form {
                padding: 2rem 1.5rem;
                margin-bottom: 1.5rem;
            }

            .sample-serials {
                padding: 1.5rem;
            }

            .info-card {
                padding: 2rem 1.5rem;
                margin-bottom: 1.5rem;
            }

            .feature-item {
                padding: 0.75rem;
            }

            .feature-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* Entrance Animations */
        .animate-in {
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 0.8s ease-out forwards;
        }

        .animate-in:nth-child(1) {
            animation-delay: 0.1s;
        }

        .animate-in:nth-child(2) {
            animation-delay: 0.2s;
        }

        .animate-in:nth-child(3) {
            animation-delay: 0.3s;
        }

        .animate-in:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Serial validation styles */
        .serial-input.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        #serialError {
            font-size: 0.875rem;
            margin-top: 0.5rem;
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        #serialError:not([style*="display: none"]) {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <!-- Floating Background Elements -->
    <div class="floating-element">
        <i class="fas fa-cog" style="font-size: 3rem; color: var(--primary-blue);"></i>
    </div>
    <div class="floating-element">
        <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: var(--accent-green);"></i>
    </div>
    <div class="floating-element">
        <i class="fas fa-search" style="font-size: 2rem; color: var(--primary-blue);"></i>
    </div>

    <!-- Hero Section -->
    <section class="lookup-hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-icon">
                    <i class="fas fa-search" style="font-size: 3rem; color: white;"></i>
                </div>
                <h1 class="hero-title">{{ __('common.serial_lookup_title') }}</h1>
                <p class="fs-4 mb-4 opacity-90">{{ __('common.serial_lookup_subtitle') }}</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-2 rounded-pill">
                        <i class="fas fa-check-circle" style="color: var(--accent-green);"></i>
                        <span>{{ __('common.instant_verification') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-2 rounded-pill">
                        <i class="fas fa-clock text-warning"></i>
                        <span>{{ __('common.available') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 bg-white bg-opacity-10 px-3 py-2 rounded-pill">
                        <i class="fas fa-globe text-info"></i>
                        <span>{{ __('common.global_coverage') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container main-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Main Lookup Form -->
                <div class="lookup-form animate-in">
                    <div class="text-center mb-4">
                        <div class="form-icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <h2 class="h3 fw-bold mb-3" style="color: var(--primary-blue);">
                            {{ __('common.equipment_serial_lookup') }}</h2>
                        <!-- <p class="text-muted fs-5">{{ __('common.equipment_serial_lookup_desc') }}</p> -->
                    </div>

                    <form action="{{ route('serial-lookup.lookup') }}" method="POST" id="serialForm"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <!-- <label for="serial_number" class="form-label fw-bold fs-5" style="color: var(--primary-blue);">{{ __('common.serial_number') }}</label> -->
                            <input type="text"
                                class="form-control serial-input @error('serial_number') is-invalid @enderror"
                                id="serial_number" name="serial_number" value="{{ old('serial_number') }}"
                                placeholder="{{ __('common.enter_equipment_serial') }}" autocomplete="off">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Error message container -->
                            <small id="serialError" class="text-danger mt-2 d-block" style="display: none;"></small>
                            <div class="form-text mt-3">
                                <i class="fas fa-info-circle me-2" style="color: var(--accent-green);"></i>
                                {{ __('common.serial_found_location') }}
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn lookup-btn d-flex align-items-center justify-content-center"
                                id="lookupBtn">
                                <span class="btn-text">
                                    <i class="fas fa-search me-2"></i>
                                    {{ __('common.check_coverage') }}
                                </span>
                                <span class="spinner-border spinner-border-sm ms-2 d-none" id="lookupSpinner" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>

                    @if ($errors->any() || session('error'))
                        <div class="alert alert-danger mt-4 border-0 rounded-3"
                            style="background: linear-gradient(135deg, #ff3b30 0%, #dc3545 100%); color: white;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') ?? $errors->first() }}
                        </div>
                    @endif
                </div>

                <!-- Sample Serials
                <div class="sample-serials animate-in">
                    <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: var(--primary-blue);">
                        <i class="fas fa-lightbulb me-2" style="color: var(--accent-green);"></i>
                        {{ __('common.try_sample_serials') }}
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="sample-serial" onclick="fillSerial('2231')">2231</span>
                        <span class="sample-serial" onclick="fillSerial('TEST123')">TEST123</span>
                        <span class="sample-serial" onclick="fillSerial('HD1200-2025-001')">HD1200-2025-001</span>
                        <span class="sample-serial" onclick="fillSerial('SQ35-2024-789')">SQ35-2024-789</span>
                    </div>
                </div> -->

                <!-- Information Cards -->
                <div class="row g-4">
                    <div class="col-md-6 h-100">
                        <div class="info-card animate-in">
                            <h5 class="fw-bold mb-4 d-flex align-items-center"
                                style="color: var(--primary-blue); justify-content: center;">
                                <i class="fas fa-shield-check me-2" style="color: var(--accent-green);"></i>
                                {{ __('common.what_youll_get') }}
                            </h5>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <strong class="d-block mb-1">{{ __('common.technical_specifications') }}</strong>
                                    <small class="text-muted">{{ __('common.technical_specifications_desc') }}</small>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div>
                                    <strong class="d-block mb-1">{{ __('common.owner_information') }}</strong>
                                    <small class="text-muted">{{ __('common.owner_information_desc') }}</small>
                                </div>
                            </div>
                            <div class="feature-item mb-0">
                                <div class="feature-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <strong class="d-block mb-1">{{ __('common.warranty_status') }}</strong>
                                    <small class="text-muted">{{ __('common.warranty_status_desc') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card animate-in">
                            <h5 class="fw-bold mb-4 d-flex align-items-center" style="color: var(--primary-blue);">
                                <i class="fas fa-headset me-2" style="color: var(--accent-green);"></i>
                                {{ __('common.need_help') }}
                            </h5>
                            <p class="mb-4 text-muted">{{ __('common.need_help_desc') }}</p>
                            <div class="d-grid gap-3">
                                <a href="mailto:soosanegypt@madinagp.com" class="support-btn">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <strong>{{ __('common.email_support') }}</strong>
                                        <small class="d-block">soosanegypt@madinagp.com</small>
                                    </div>
                                </a>
                                <a href="tel:+201112696961" class="support-btn">
                                    <i class="fas fa-phone"></i>
                                    <div>
                                        <strong>{{ __('common.call_support') }}</strong>
                                        <small class="d-block">{{ __('common.phone_no') }}</small>
                                    </div>
                                </a>
                                <a href="https://wa.me/201112696961" class="support-btn" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                    <div>
                                        <strong>{{ __('common.whatsapp_support') }}</strong>
                                        <small class="d-block">{{ __('common.quick_messaging') }}</small>
                                    </div>
                                </a>
                            </div>
                            <div class="mt-4 p-3 rounded-3"
                                style="background: rgba(0, 84, 142, 0.05); border-left: 4px solid var(--accent-green);">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-clock me-2" style="color: var(--accent-green);"></i>
                                    {{ __('common.support_hours') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function fillSerial(serial) {
            const input = document.getElementById('serial_number');
            input.value = serial;
            input.focus();

            // Add visual feedback
            input.style.transform = 'scale(1.02)';
            input.style.borderColor = 'var(--accent-green)';
            setTimeout(() => {
                input.style.transform = '';
                input.style.borderColor = '';
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('serialForm');
            const btn = document.getElementById('lookupBtn');
            const serialInput = document.getElementById('serial_number');
            const errorDiv = document.getElementById('serialError');

            // دالة لإخفاء رسالة الخطأ بـ smooth transition
            function hideErrorMessage(errorDiv) {
                errorDiv.style.opacity = "0";
                errorDiv.style.transform = "translateY(-5px)";
                setTimeout(() => {
                    errorDiv.style.display = "none";
                    errorDiv.style.opacity = "";
                    errorDiv.style.transform = "";
                }, 300);
            }

            // Button click validation
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                let val = serialInput.value.trim();

                if (val === "") {
                    // إظهار رسالة الخطأ
                    errorDiv.textContent = "{{ __('common.enter_serial') }}";
                    errorDiv.style.display = "block";
                    serialInput.classList.add("is-invalid");
                    serialInput.focus();
                } else {
                    // إخفاء رسالة الخطأ وإرسال الفورم
                    hideErrorMessage(errorDiv);
                    serialInput.classList.remove("is-invalid");

                    // Show loading spinner and submit
                    btn.disabled = true;
                    document.getElementById('lookupSpinner').classList.remove('d-none');
                    form.submit();
                }
            });

            // Form submission handling (backup)
            form.addEventListener('submit', function(e) {
                let val = serialInput.value.trim();
                if (val === "") {
                    e.preventDefault();
                    errorDiv.textContent = "{{ __('common.enter_serial') }}";
                    errorDiv.style.display = "block";
                    serialInput.classList.add("is-invalid");
                    serialInput.focus();
                    return false;
                }

                btn.disabled = true;
                document.getElementById('lookupSpinner').classList.remove('d-none');
            });

            // Enhanced input validation
            serialInput.addEventListener('input', function() {
                // Clean input - allow only alphanumeric, hyphens, and underscores
                this.value = this.value.replace(/[^a-zA-Z0-9\-_]/g, '');

                // Hide error message when user types valid input
                let trimmedValue = this.value.trim();
                if (trimmedValue !== "") {
                    hideErrorMessage(errorDiv);
                    this.classList.remove('is-invalid');
                }

                // Visual feedback
                if (this.value.length > 0) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    this.style.borderColor = 'var(--accent-green)';
                } else {
                    this.classList.remove('is-valid');
                    this.style.borderColor = '';
                }
            });

            // Hide error message on focus if input has value
            serialInput.addEventListener('focus', function() {
                if (this.value.trim() !== "") {
                    hideErrorMessage(errorDiv);
                    this.classList.remove("is-invalid");
                }
            });

            // Auto-focus and entrance animation
            setTimeout(() => {
                serialInput.focus();
            }, 1000);

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 200);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe animated elements
            document.querySelectorAll('.animate-in').forEach(el => {
                observer.observe(el);
            });

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + Enter to submit form
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    form.submit();
                }

                // Escape to clear input
                if (e.key === 'Escape') {
                    serialInput.value = '';
                    serialInput.focus();
                }
            });

            // Add sample serial click animations
            document.querySelectorAll('.sample-serial').forEach(serial => {
                serial.addEventListener('click', function() {
                    // Ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                    `;

                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (rect.width / 2 - size / 2) + 'px';
                    ripple.style.top = (rect.height / 2 - size / 2) + 'px';

                    this.style.position = 'relative';
                    this.appendChild(ripple);

                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@endpush
