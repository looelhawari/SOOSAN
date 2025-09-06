<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo2.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo2.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo2.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/logo2.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Primary Meta Tags -->
    <title>@yield('title', 'SoosanEgypt - Drilling Equipment Solutions')</title>
    <meta name="title" content="@yield('title', 'SoosanEgypt - Drilling Equipment Solutions')">
    <meta name="description" content="@yield('description', 'Leading provider of drilling equipment and solutions. Quality machinery for construction, mining, and industrial applications.')">
    <meta name="keywords" content="@yield('keywords', 'drilling equipment, hydraulic breakers, construction machinery, mining equipment, Soosan, Egypt, industrial solutions, SQ, SB-E, SB, ET-II')">
    <meta name="author" content="SOOSAN EGYPT">
    <meta name="robots" content="index, follow">
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SoosanEgypt - Drilling Equipment Solutions')">
    <meta property="og:description" content="@yield('description', 'Leading provider of drilling equipment and solutions. Quality machinery for construction, mining, and industrial applications.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo2.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="SoosanEgypt">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:locale:alternate" content="{{ app()->getLocale() === 'en' ? 'ar' : 'en' }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'SoosanEgypt - Drilling Equipment Solutions')">
    <meta property="twitter:description" content="@yield('description', 'Leading provider of drilling equipment and solutions. Quality machinery for construction, mining, and industrial applications.')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/logo2.png'))">

    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="#00548e">
    <meta name="msapplication-TileColor" content="#00548e">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Alternate Language Versions -->
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}?lang=en">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() }}?lang=ar">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Global Enhanced Styles -->
    <link href="{{ asset('css/global-styles.css') }}" rel="stylesheet">

    <!-- Global Icon Centering Styles -->
    <style>
        /* Universal Icon Centering for ALL Icons */
        i,
        .fas,
        .fab,
        .far,
        .fal,
        .fad,
        .icon,
        [class*="fa-"] {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            vertical-align: middle !important;
            line-height: 1 !important;
        }

        /* Button Icon Centering */
        button i,
        .btn i,
        a i,
        .button i {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            vertical-align: middle !important;
            line-height: 1 !important;
        }

        /* Specific icon containers */
        .social i,
        .social-icons i,
        .search-input-btn i,
        .scroll-to-top-btn i,
        .hero-btn i,
        .slider-nav i,
        .mobile-nav-auth-btn i,
        .language-selector-btn i,
        .mobile-nav-logout-btn i,
        .youtube-explore-btn i,
        .breaker-product-btn i {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            vertical-align: middle !important;
            line-height: 1 !important;
            width: auto !important;
            height: auto !important;
        }

        /* RTL Support for Icons */
        html[dir='rtl'] i,
        html[dir='rtl'] .fas,
        html[dir='rtl'] .fab,
        html[dir='rtl'] .far,
        html[dir='rtl'] .fal,
        html[dir='rtl'] .fad,
        html[dir='rtl'] .icon,
        html[dir='rtl'] [class*="fa-"] {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            vertical-align: middle !important;
            line-height: 1 !important;
        }
    </style>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (app()->isLocale('ar'))
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/rtl-styles.css') }}">
    @endif

    <!-- Additional head content -->
    @stack('head')
    @stack('styles')

    <!-- Structured Data -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "SoosanEgypt",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo2.png') }}",
            "description": "Leading provider of drilling equipment and solutions in Egypt",
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "EG",
                "addressLocality": "Egypt"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "customer service"
            },
            "sameAs": [
                "https://www.facebook.com/soosanegypt",
                "https://www.linkedin.com/company/soosanegypt"
            ]
        }
    </script>

    <!-- Page-specific structured data -->
    @stack('structured_data')

    <style>
        /* Original Navbar Variables */
        :root {
            --navbar-height: 70px;
            --transition-speed: 0.3s;
        }
        html, body {
             overflow-x: hidden;
        }
        /* Enhanced Navbar Styling with Zoom Level Support */
        .navbar {
            min-height: var(--navbar-height);
            padding: 0.75rem 0;
            z-index: 1050;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Navbar Container Responsiveness */
        .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            min-width: 0;
        }

        /* Logo Optimization */
        .navbar-brand {
            flex-shrink: 0;
            margin-right: 1rem;
        }

        .navbar-brand img {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            height: 60px !important;
            width: auto !important;
            max-height: 60px;
        }

        /* Desktop Navigation Container */
        .navbar-nav-desktop {
            flex-grow: 1;
            max-width: calc(100% - 300px);
            min-width: 0;
        }

        .navbar-nav-desktop .navbar-nav {
            gap: 1.5rem;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
        }

        /* Zoom Level Responsive Adjustments */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .navbar-nav-desktop .navbar-nav {
                gap: 1.2rem;
            }

            .navbar-brand img {
                height: 55px !important;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .navbar-nav-desktop .navbar-nav {
                gap: 1rem;
            }

            .navbar-brand img {
                height: 50px !important;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .navbar-nav-desktop .navbar-nav {
                gap: 0.8rem;
            }

            .navbar-brand img {
                height: 45px !important;
            }
        }

        /* Desktop Navigation Items */
        .navbar-nav .nav-item {
            flex-shrink: 1;
            min-width: 0;
        }

        .navbar-nav .nav-link {
            font-weight: 600;
            color: #333;
            padding: 0.75rem 0.8rem;
            border-radius: 8px;
            transition: all var(--transition-speed) ease;
            position: relative;
            display: flex;
            align-items: center;
            white-space: nowrap;
            font-size: 0.95rem;
        }

        /* Zoom Level Text Adjustments */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .navbar-nav .nav-link {
                padding: 0.6rem 0.7rem;
                font-size: 0.9rem;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .navbar-nav .nav-link {
                padding: 0.5rem 0.6rem;
                font-size: 0.85rem;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .navbar-nav .nav-link {
                padding: 0.4rem 0.5rem;
                font-size: 0.8rem;
            }
        }

        /* Right Side Navigation */
        .navbar-nav-right {
            flex-shrink: 0;
            gap: 1rem;
            align-items: center;
            margin-left: auto;
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .navbar-nav-right {
                gap: 0.8rem;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .navbar-nav-right {
                gap: 0.6rem;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .navbar-nav-right {
                gap: 0.5rem;
            }
        }

        /* Language Selector Responsive */
        .language-selector-btn {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #64748b;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .language-selector-btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.85rem;
                border-radius: 10px;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .language-selector-btn {
                padding: 0.4rem 0.7rem;
                font-size: 0.8rem;
                border-radius: 8px;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .language-selector-btn {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
                border-radius: 6px;
            }
        }

        /* Enhanced Login Button */
        .enhanced-login-btn {
            background: linear-gradient(135deg, #00548e, #004085);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            border: none;
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .enhanced-login-btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                border-radius: 10px;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .enhanced-login-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
                border-radius: 8px;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .enhanced-login-btn {
                padding: 0.3rem 0.7rem;
                font-size: 0.75rem;
                border-radius: 6px;
            }
        }

        /* Korean Flag Container */
        .korean-flag-container {
            flex-shrink: 0;
        }

        .korean-flag {
            height: 30px;
            width: auto;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .korean-flag {
                height: 28px;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .korean-flag {
                height: 25px;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .korean-flag {
                height: 22px;
            }
        }

        /* Enhanced User Button */
        .enhanced-user-btn {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .enhanced-user-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
                border-radius: 10px;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .enhanced-user-btn {
                padding: 0.3rem 0.7rem;
                font-size: 0.8rem;
                border-radius: 8px;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .enhanced-user-btn {
                padding: 0.2rem 0.6rem;
                font-size: 0.75rem;
                border-radius: 6px;
            }
        }

        /* User Avatar */
        .user-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .user-avatar-img {
                width: 30px;
                height: 30px;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .user-avatar-img {
                width: 28px;
                height: 28px;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .user-avatar-img {
                width: 25px;
                height: 25px;
            }
        }

        /* Navigation Link Icons */
        .navbar-nav .nav-link i {
            font-size: 1rem;
            margin-right: 0.5rem;
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .navbar-nav .nav-link i {
                font-size: 0.9rem;
                margin-right: 0.4rem;
            }
        }

        @media (min-width: 1100px) and (max-width: 1199px) {
            .navbar-nav .nav-link i {
                font-size: 0.85rem;
                margin-right: 0.3rem;
            }
        }

        @media (min-width: 1000px) and (max-width: 1099px) {
            .navbar-nav .nav-link i {
                font-size: 0.8rem;
                margin-right: 0.25rem;
            }
        }

        /* Prevent text wrapping and overflow */
        .navbar-nav .nav-link,
        .language-selector-btn,
        .enhanced-login-btn,
        .enhanced-user-btn {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* RTL Support */
        html[dir="rtl"] .navbar-nav .nav-link i {
            margin-right: 0;
            margin-left: 0.5rem;
        }

        html[dir="rtl"] .language-selector-btn,
        html[dir="rtl"] .enhanced-login-btn {
            flex-direction: row-reverse;
        }

        /* Ensure navbar stays within viewport */
        @media (max-width: 1199px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
            z-index: 1050;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-brand img {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        /* Mobile Hamburger Menu */
        .mobile-nav-toggle {
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transition: all var(--transition-speed) ease;
            border-radius: 8px;
        }

        .mobile-nav-toggle:hover {
            background: rgba(0, 0, 0, 0.1);
        }

        .hamburger-line {
            width: 25px;
            height: 3px;
            background: #333;
            border-radius: 2px;
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-nav-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .mobile-nav-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .mobile-nav-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* Desktop Navigation */
        .navbar-nav .nav-link {
            font-weight: 600;
            color: #333;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all var(--transition-speed) ease;
            position: relative;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-blue);
            background: rgba(0, 84, 142, 0.08);
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-green));
            border-radius: 2px;
            transition: all var(--transition-speed) ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }

        /* Mega Menu Styling */
        .mega-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 0.5rem;
            min-width: 600px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
        }

        .mega-dropdown .dropdown-header {
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(0, 84, 142, 0.1);
        }

        .mega-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.25rem;
            transition: all var(--transition-speed) ease;
            border: 1px solid transparent;
        }

        .mega-dropdown .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.08), rgba(176, 215, 1, 0.08));
            color: var(--primary-blue);
            transform: translateX(8px);
            border-color: rgba(0, 84, 142, 0.2);
        }

        /* Mobile Navigation Overlay */
        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed) ease;
            backdrop-filter: blur(5px);
        }

        .mobile-nav-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Navigation Sidebar */
        .mobile-nav-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 85%;
            max-width: 380px;
            height: 100vh;
            background: linear-gradient(135deg, #00548e 0%, #004085 30%, #ffffff 100%);
            z-index: 1050;
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 20px 0 60px rgba(0, 84, 142, 0.25), 0 0 100px rgba(0, 84, 142, 0.15);
            border-top-right-radius: 24px;
            border-bottom-right-radius: 24px;
            backdrop-filter: blur(20px);
        }

        .mobile-nav-sidebar.show {
            left: 0;
        }

        /* Mobile Navigation Header */
        .mobile-nav-header {
            background: linear-gradient(135deg, #00548e 0%, #004085 100%);
            color: white;
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 32px rgba(0, 84, 142, 0.4);
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid #b0d701;
        }

        /* .mobile-nav-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(176, 215, 1, 0.15), transparent);
            transition: left 1s ease;
        }

        .mobile-nav-header:hover::before {
            left: 100%;
        } */

        .mobile-nav-logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .mobile-nav-logo:hover {
            color: #b0d701;
            text-decoration: none;
        }

        .mobile-nav-header .btn {
            transition: all var(--transition-speed) ease;
        }

        .mobile-nav-header .btn:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        /* Mobile Navigation Content */
        .mobile-nav-content {
            padding: 2rem 1.5rem;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            margin-top: -8px;
            position: relative;
            z-index: 2;
            min-height: calc(100vh - 140px);
        }

        /* Mobile Navigation Sections */
        .mobile-nav-section {
            margin-bottom: 1.5rem;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid rgba(0, 84, 142, 0.12);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 25px rgba(0, 84, 142, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-nav-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 84, 142, 0.12);
            border-color: rgba(176, 215, 1, 0.3);
        }

        .mobile-nav-section-header {
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.08), rgba(176, 215, 1, 0.05));
            padding: 1.25rem 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1rem;
            color: #00548e;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 2px solid rgba(0, 84, 142, 0.08);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mobile-nav-section-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(176, 215, 1, 0.12), transparent);
            transition: left 0.7s ease;
        }

        .mobile-nav-section-header:hover {
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.15), rgba(176, 215, 1, 0.12));
            color: #004085;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 84, 142, 0.2);
            border-bottom-color: rgba(176, 215, 1, 0.3);
        }

        .mobile-nav-section-header:hover::before {
            left: 100%;
        }

        .mobile-nav-section-header .nav-arrow {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #00548e;
            font-size: 1rem;
            margin-left: auto;
        }

        .mobile-nav-section-header:hover .nav-arrow {
            color: #004085;
            transform: scale(1.15);
        }

        .mobile-nav-section-header.expanded {
            background: linear-gradient(135deg, rgba(176, 215, 1, 0.12), rgba(0, 84, 142, 0.08));
            color: #00548e;
            border-bottom-color: rgba(176, 215, 1, 0.2);
        }

        .mobile-nav-section-header.expanded .nav-arrow {
            transform: rotate(180deg);
            color: #b0d701;
        }

        .mobile-nav-section-header.expanded:hover {
            background: linear-gradient(135deg, rgba(176, 215, 1, 0.18), rgba(0, 84, 142, 0.12));
        }

        .mobile-nav-section-header.expanded:hover .nav-arrow {
            transform: rotate(180deg) scale(1.15);
            color: #9bc600;
        }

        .mobile-nav-section-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height var(--transition-speed) ease;
            background: white;
        }

        .mobile-nav-section-content.expanded {
            max-height: 1000px;
            padding: 1rem 0;
        }

        /* Mobile Navigation Subsections */
        .mobile-nav-subsection {
            padding: 0 1.25rem;
            margin-bottom: 1rem;
        }

        .mobile-nav-subsection:last-child {
            margin-bottom: 0;
        }

        .mobile-nav-subheader {
            color: #00548e;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid rgba(176, 215, 1, 0.3);
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.05), rgba(176, 215, 1, 0.03));
            border-radius: 8px 8px 0 0;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            position: relative;
            overflow: hidden;
        }

        .mobile-nav-subheader::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #00548e, #b0d701);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }

        .mobile-nav-subsection:hover .mobile-nav-subheader::before {
            transform: scaleX(1);
        }

        /* Mobile Navigation Items */
        .mobile-nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            font-weight: 600;
            font-size: 0.95rem;
            background: rgba(248, 250, 252, 0.8);
            position: relative;
            overflow: hidden;
        }

        .mobile-nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(176, 215, 1, 0.15), transparent);
            transition: left 0.6s ease;
        }

        .mobile-nav-item:hover {
            color: #00548e;
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.08), rgba(176, 215, 1, 0.05));
            transform: translateX(15px) translateY(-3px);
            border-color: rgba(0, 84, 142, 0.25);
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(0, 84, 142, 0.15);
        }

        .mobile-nav-item:hover::before {
            left: 100%;
        }

        .mobile-nav-item:active {
            transform: translateX(10px) translateY(-1px);
            box-shadow: 0 3px 12px rgba(0, 84, 142, 0.12);
        }

        .mobile-nav-item i {
            color: #00548e;
            margin-right: 1rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .mobile-nav-item:hover i {
            color: #b0d701;
            transform: scale(1.1);
        }

        .mobile-nav-item-simple {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 16px;
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(0, 84, 142, 0.12);
            background: rgba(255, 255, 255, 0.95);
            font-weight: 700;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 84, 142, 0.05);
        }

        .mobile-nav-item-simple::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(176, 215, 1, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .mobile-nav-item-simple:hover {
            color: #00548e;
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.08), rgba(176, 215, 1, 0.05));
            transform: translateX(12px) translateY(-2px);
            border-color: rgba(176, 215, 1, 0.3);
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(0, 84, 142, 0.12);
        }

        .mobile-nav-item-simple:hover::before {
            left: 100%;
        }

        .mobile-nav-item-simple i {
            color: #00548e;
            margin-right: 1rem;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .mobile-nav-item-simple:hover i {
            color: #b0d701;
            transform: scale(1.15);
        }

        /* Mobile Authentication Section */
        .mobile-nav-auth {
            margin-top: 2.5rem;
            padding: 2rem 1.5rem;
            border-top: 3px solid rgba(0, 84, 142, 0.2);
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.03), rgba(176, 215, 1, 0.02));
            border-radius: 16px 16px 0 0;
        }

        .mobile-nav-auth-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 1.25rem 2rem;
            background: #00548e;
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(0, 84, 142, 0.3);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-nav-auth-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
        }

        .mobile-nav-auth-btn:hover {
            color: white;
            text-decoration: none;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 84, 142, 0.4);
            border-color: rgba(176, 215, 1, 0.4);
        }

        .mobile-nav-auth-btn:hover::before {
            left: 100%;
        }

        .mobile-nav-auth-btn:active {
            transform: translateY(-1px) scale(1.01);
            box-shadow: 0 6px 20px rgba(0, 84, 142, 0.35);
        }

        .mobile-nav-auth-btn i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .mobile-nav-user {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            border: 1px solid rgba(0, 84, 142, 0.1);
        }

        .mobile-nav-user .user-info {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.08), rgba(176, 215, 1, 0.08));
            border-radius: 8px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .mobile-logout-form {
            margin-top: 0.5rem;
        }

        .mobile-nav-logout-btn {
            width: 100%;
            background: none;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
        }

        .mobile-nav-logout-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* Mobile Language Section */
        .mobile-language-section {
            margin-top: 2rem;
            padding: 2rem 1.5rem;
            border-top: 3px solid rgba(0, 84, 142, 0.2);
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.05), rgba(176, 215, 1, 0.03));
            border-radius: 16px 16px 0 0;
        }

        .mobile-language-header {
            color: #00548e;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mobile-language-header i {
            color: #b0d701;
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .mobile-language-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .mobile-language-option {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(0, 84, 142, 0.15);
            background: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 84, 142, 0.08);
        }

        .mobile-language-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(176, 215, 1, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .mobile-language-option:hover {
            color: #00548e;
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.08), rgba(176, 215, 1, 0.05));
            transform: translateX(10px) translateY(-2px);
            border-color: rgba(176, 215, 1, 0.4);
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(0, 84, 142, 0.12);
        }

        .mobile-language-option:hover::before {
            left: 100%;
        }

        .mobile-language-option.active {
            background: linear-gradient(135deg, rgba(176, 215, 1, 0.15), rgba(0, 84, 142, 0.08));
            color: #00548e;
            border-color: rgba(176, 215, 1, 0.4);
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(176, 215, 1, 0.2);
        }

        .mobile-language-option.active:hover {
            background: linear-gradient(135deg, rgba(176, 215, 1, 0.2), rgba(0, 84, 142, 0.1));
            transform: translateX(8px) translateY(-1px);
        }

        .mobile-language-option i {
            color: #00548e;
            margin-right: 1rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .mobile-language-option:hover i,
        .mobile-language-option.active i {
            color: #b0d701;
            transform: scale(1.1);
        }

        /* Enhanced Language Selector */
        .language-selector-container {
            display: flex;
            align-items: center;
        }

        .language-selector-btn {
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.9));
            border: 2px solid rgba(0, 123, 255, 0.2);
            border-radius: 15px;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 700;
            color: #007bff;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .language-selector-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .language-selector-btn:hover {
            background: linear-gradient(135deg, #007bff, #004085);
            border-color: #007bff;
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        .language-selector-btn:hover::before {
            left: 100%;
        }

        .language-selector-btn:active {
            transform: translateY(-1px) scale(1.02);
        }

        .language-selector-btn:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }

        .language-selector-btn .current-lang {
            margin: 0 0.25rem;
            white-space: nowrap;
        }

        .language-dropdown {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 180px;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.98);
        }

        .language-dropdown .dropdown-item {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            width: 92%;
        }

        .language-dropdown .dropdown-item:hover {
            background-color: #00548e;
            color: white;
        }

        .language-dropdown .dropdown-item.active {
            background: rgba(0, 123, 255, 0.1);
            color:rgb(1, 45, 77);
            font-weight: 700;
        }

        .language-dropdown .dropdown-item.active:hover {
            background-color: #00548e;
            color: white;
        }

        /* Enhanced Login Button */
        .enhanced-login-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #00548e;
            color: white;
            text-decoration: none;
            border-radius: 15px;
            padding: 0.875rem 1.75rem;
            font-size: 0.95rem;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.35);
            border: 2px solid rgba(255, 255, 255, 0.2);
            outline: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .enhanced-login-btn:hover {
            transform: translateY(-4px) scale(1.08);
            box-shadow: 0 12px 35px rgba(0, 123, 255, 0.5);
            color: white;
            text-decoration: none;
            border-color: rgba(176, 215, 1, 0.4);
        }

        .enhanced-login-btn:active {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        /* Enhanced User Dropdown */
        .enhanced-user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .enhanced-user-btn:hover {
            background: linear-gradient(135deg, #007bff, #004085);
            border-color: #00548e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .user-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .enhanced-user-btn:hover .user-avatar {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 700;
            line-height: 1.2;
            color: #374151;
            transition: color 0.3s ease;
        }

        .enhanced-user-btn:hover .user-name {
            color: white;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6b7280;
            line-height: 1;
            transition: color 0.3s ease;
        }

        .enhanced-user-btn:hover .user-role {
            color: rgba(255, 255, 255, 0.8);
        }

        .user-dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            min-width: 200px;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.98);
        }

        .user-dropdown-menu .dropdown-item {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 0.25rem 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            width: 92%;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background: #00548e;
            color: white;
        }
        .user-dropdown-menu .dropdown-item.logout-btn {
            display: flex;
            align-items: center;
            flex-direction: row;
            width: 92%;
        }

        .user-dropdown-menu .dropdown-item.logout-btn:hover {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1199.98px) {
            .navbar-nav-desktop,
            .navbar-nav-right {
                display: none !important;
            }

            /* Mobile language and login adjustments */
            .mobile-nav-auth {
                margin-top: 1.5rem;
            }

            .mobile-language-section {
                margin-top: 1.5rem;
            }

            /* Enhanced mobile sidebar on smaller screens */
            .mobile-nav-sidebar {
                width: 90%;
                max-width: 350px;
            }

            .mobile-nav-content {
                padding: 1rem;
            }

            .mobile-nav-section {
                margin-bottom: 0.75rem;
            }

            .language-selector-btn {
                padding: 0.625rem 1rem;
                font-size: 0.85rem;
            }

            .enhanced-login-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .mobile-nav-sidebar {
                width: 75%;
                max-width: 320px;
            }

            .mobile-nav-header {
                padding: 1.25rem;
            }

            .mobile-nav-content {
                padding: 0.75rem;
            }

            .mobile-nav-item {
                padding: 0.625rem 1rem;
                font-size: 0.9rem;
            }

            .language-selector-btn {
                padding: 0.5rem 0.875rem;
                font-size: 0.8rem;
            }

            .enhanced-login-btn {
                padding: 0.625rem 1.25rem;
                font-size: 0.8rem;
                text-transform: none;
                letter-spacing: 0.25px;
            }
        }

        @media (min-width: 1200px) {
            .mobile-nav-toggle,
            .mobile-nav-overlay,
            .mobile-nav-sidebar {
                display: none !important;
            }

            /* Desktop mega dropdown positioning */
            .mega-dropdown .dropdown-menu {
                position: absolute !important;
                top: 100% !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
            }
        }

        @media (max-width: 768px) {
            /* Enhanced mobile responsive */
            .language-selector-btn .current-lang {
                display: none;
            }

            .enhanced-login-btn span {
                display: none;
            }

            .enhanced-login-btn {
                padding: 0.75rem;
                border-radius: 50%;
                width: 45px;
                height: 45px;
                justify-content: center;
            }

            .user-info .user-name,
            .user-info .user-role {
                display: none;
            }

            .enhanced-user-btn {
                padding: 0.5rem;
                border-radius: 50%;
                width: 45px;
                height: 45px;
                justify-content: center;
            }

            .navbar-brand img {
                height: 50px !important;
            }
        }

        @media (max-width: 575.98px) {
            .mobile-nav-sidebar {
                width: 95%;
                max-width: none;
            }

            .mobile-nav-header {
                padding: 1rem;
            }

            .mobile-nav-content {
                padding: 1rem;
            }
        }

        /* Global Mobile Spacing Fix */
        @media (max-width: 768px) {
            /* Fix blank space between navbar and content */
            main {
                padding-top: 0 !important;
                margin-top: 0 !important;
            }

            /* Ensure no unexpected gaps in mobile */
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Fix hero sections spacing on mobile */
            section[class*="hero"] {
                margin-bottom: 0;
            }

            /* Fix any negative margins causing gaps */
            *[class*="main-container"],
            *[class*="content-section"] {
                margin-top: 0 !important;
            }
        }

        @media (max-width: 375px) {
            .navbar-brand img {
                height: 40px !important;
            }

            .mobile-nav-sidebar {
                width: 100%;
            }
        }

        /* RTL Support */
        [dir="rtl"] .mobile-nav-sidebar {
            left: auto;
            right: -100%;
        }

        [dir="rtl"] .mobile-nav-sidebar.show {
            right: 0;
            left: auto;
        }

        [dir="rtl"] .mobile-nav-item:hover,
        [dir="rtl"] .mobile-nav-item-simple:hover {
            transform: translateX(-8px);
        }

        [dir="rtl"] .dropdown-item:hover {
            transform: translateX(-8px);
        }

        /* Smooth scrolling for mobile nav */
        .mobile-nav-sidebar {
            scrollbar-width: thin;
            scrollbar-color: #007bff transparent;
        }

        .mobile-nav-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .mobile-nav-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .mobile-nav-sidebar::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 4px;
        }

        /* Social icons and footer styling from previous implementation */
        .social-icons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
            width: 100%;
        }
        .social {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .social i {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            vertical-align: middle !important;
            line-height: 1 !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .social::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .social:hover::before {
            left: 100%;
        }

        .social:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .facebook {
            background-color: #1877F2;
        }

        .linkedin {
            background-color: #0A66C2;
        }

        .youtube {
            background-color: #FF0000;
        }

        /* RTL Support for Social Icons */
        html[dir='rtl'] .social-icons {
            justify-content: flex-end;
            direction: ltr; /* Keep icons in LTR order even in RTL layout */
        }

        html[dir='rtl'] .social {
            margin: 0 2px;
        }

        /* Enhanced Footer Responsiveness */
        .copy-right-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .copy-right-section img:first-child,
        .copy-right-section img:last-child {
            width: 150px;
            height: auto;
            transition: all 0.3s ease;
            filter: brightness(1.1);
        }

        .copy-right-section img:hover {
            transform: scale(1.05);
            filter: brightness(1.3);
        }

        .copy-right-section p {
            font-size: 20px;
            margin: 0;
            text-align: center;
            flex: 1;
        }

        .powered-by {
            text-align: center;
            font-size: 18px;
            color: #ccc;
            margin-top: 1rem;
            transition: color 0.3s ease;
        }

        .powered-by:hover {
            color: #fff;
        }

        /* Simple Logo Styling */
        .navbar-brand {
            padding: 0.5rem 0;
        }

        /* Enhanced Mega Dropdown Styles */
        .mega-dropdown .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            min-width: 750px;
            background: rgba(255, 255, 255, 0.98);
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            margin-top: 8px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 1050;
        }

        .mega-dropdown .dropdown-header {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #007bff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mega-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            color: #4b5563;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            background: transparent;
        }

        .mega-dropdown .dropdown-item:hover {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            color: #0369a1;
            text-decoration: none;
            transform: translateX(8px) scale(1.02);
            border-color: #38bdf8;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.2);
        }

        .mega-dropdown .dropdown-item i {
            font-size: 1.1rem;
            width: 20px;
            transition: all 0.3s ease;
        }

        .mega-dropdown .dropdown-item:hover i {
            transform: scale(1.1) rotate(5deg);
            color: #0284c7;
        }

        .dropdown-category-item .category-icon {
            width: 28px;
            height: 28px;
            margin-right: 15px;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .dropdown-category-item:hover .category-icon {
            color: #2563eb;
            transform: scale(1.1) rotate(5deg);
        }

        .dropdown-category-item .arrow-icon {
            font-size: 14px;
            color: #9ca3af;
            transition: all 0.3s ease;
        }

        .dropdown-category-item:hover .arrow-icon {
            color: #2563eb;
            transform: translateX(5px);
        }

        .dropdown-line-item {
            padding: 12px 24px;
            color: #374151;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }

        .dropdown-line-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .dropdown-line-item:hover::before {
            left: 100%;
        }

        .dropdown-line-item:hover {
            background: #f0f9ff;
            color: #0284c7;
            text-decoration: none;
            padding-left: 32px;
            transform: translateY(-1px);
        }

        .dropdown-line-item:last-child {
            border-bottom: none;
        }

        /* Enhanced Icon Navigation */
        .icon-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }

        .nav-icon-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #374151;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            min-width: 70px;
            background: transparent;
            overflow: hidden;
        }

        .nav-icon-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(16, 185, 129, 0.1));
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.4s ease;
            border-radius: 12px;
            z-index: -1;
        }

        .nav-icon-item:hover::before {
            opacity: 1;
            transform: scale(1);
        }

        .nav-icon-item:hover {
            color: #2563eb;
            transform: translateY(-3px) scale(1.05);
            text-decoration: none;
        }

        .nav-icon-item.active {
            color: #2563eb;
            background: rgba(37, 99, 235, 0.1);
        }

        .nav-icon {
            font-size: 1.3rem;
            margin-bottom: 0.3rem;
            transition: all 0.3s ease;
        }

        .nav-icon-item:hover .nav-icon {
            transform: scale(1.1);
        }

        .nav-icon-label {
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
            transition: all 0.3s ease;
        }

        .nav-icon-item:hover .nav-icon-label {
            opacity: 1;
            transform: scale(1.05);
        }

        /* Enhanced Mobile Navigation */
        @media (max-width: 991px) {
            .navbar-nav-dropdown {
                position: static;
            }

            .dropdown-menu-level1,
            .dropdown-menu-level2 {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                box-shadow: none;
                border: none;
                margin: 0;
                background: transparent;
                min-width: auto;
                width: 100%;
                backdrop-filter: none;
            }

            .icon-nav {
                flex-direction: column;
                gap: 0.75rem;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.98));
                padding: 2rem 1.5rem;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
                margin-top: 1rem;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .nav-icon-item {
                flex-direction: row;
                justify-content: flex-start;
                width: 100%;
                padding: 1.2rem 1.5rem;
                gap: 1rem;
                border-radius: 15px;
                min-width: auto;
            }

            .nav-icon-item:hover {
                transform: translateX(8px) scale(1.02);
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(16, 185, 129, 0.1));
            }

            .nav-icon {
                margin-bottom: 0;
                font-size: 1.5rem;
            }

            .nav-icon-label {
                font-size: 1rem;
                font-weight: 600;
                text-transform: none;
            }

            .dropdown-category-item {
                padding: 12px 20px;
                font-size: 15px;
            }

            .dropdown-line-item {
                padding: 10px 20px;
                font-size: 14px;
                margin-left: 25px;
            }

            html[dir='rtl'] .dropdown-line-item {
                margin-left: 0;
                margin-right: 25px;
            }
        }

        /* Enhanced Footer Responsiveness */
        @media (max-width: 767px) {
            .copy-right-section {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .copy-right-section img:first-child,
            .copy-right-section img:last-child {
                width: 120px;
            }

            .copy-right-section p {
                font-size: 16px;
                order: 2;
            }

            .social-icons {
                justify-content: center;
                margin-top: 1rem;
            }

            .social {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .copy-right-section img:first-child,
            .copy-right-section img:last-child {
                width: 100px;
            }

            .copy-right-section p {
                font-size: 14px;
            }

            .powered-by {
                font-size: 16px;
            }
        }

        /* Enhanced RTL Support */
        html[dir='rtl'] .dropdown-menu-level1 {
            left: auto;
            right: 0;
        }

        html[dir='rtl'] .dropdown-menu-level2 {
            left: auto;
            right: 100%;
            margin-left: 0;
            margin-right: 8px;
        }

        html[dir='rtl'] .dropdown-category-item .category-icon {
            margin-right: 0;
            margin-left: 15px;
        }

        html[dir='rtl'] .dropdown-category-item .arrow-icon {
            transform: rotate(180deg);
        }

        html[dir='rtl'] .dropdown-category-item:hover .arrow-icon {
            transform: rotate(180deg) translateX(5px);
        }

        html[dir='rtl'] .dropdown-line-item:hover {
            padding-left: 24px;
            padding-right: 32px;
        }

        html[dir='rtl'] .dropdown-category-item:hover {
            transform: translateX(-5px);
            padding-right: 28px;
            padding-left: 24px;
        }

        html[dir='rtl'] .dropdown-category-item:hover .dropdown-menu-level2 {
            transform: translateX(0) scale(1);
        }

        html[dir='rtl'] .dropdown-menu-level2 {
            transform: translateX(15px) scale(0.95);
        }

        /* Enhanced Hover Effects */
        .navbar-nav-dropdown .nav-icon-item:hover {
            background: rgba(37, 99, 235, 0.1);
            border-radius: 12px;
        }

        /* Smooth Scroll Enhancement */
        html {
            scroll-behavior: smooth;
        }

        /* Loading and Transition States */
        .navbar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        /* Enhanced Focus States for Accessibility */
        .nav-icon-item:focus,
        .dropdown-category-item:focus,
        .dropdown-line-item:focus {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
            border-radius: 8px;
        }



        /* Mobile Navigation Styling */
        .mobile-nav-section {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mobile-nav-section-header {
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background 0.3s ease;
            font-weight: 600;
        }

        .mobile-nav-section-header:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .mobile-nav-section-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .mobile-nav-section-content.expanded {
            max-height: 1000px;
        }

        .mobile-nav-subsection {
            padding: 1rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .mobile-nav-subheader {
            color: #b0d701;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            letter-spacing: 1px;
        }

        .mobile-nav-item {
            display: block;
            padding: 0.75rem 1rem;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            background: transparent;
            border: 1px solid transparent;
        }

        .mobile-nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(8px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .mobile-nav-item-simple {
            display: block;
            padding: 1.2rem 2rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            background: transparent;
            font-weight: 500;
        }

        .mobile-nav-item-simple:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(8px);
        }

        .nav-arrow {
            transition: transform 0.3s ease;
        }

        .nav-arrow.rotated {
            transform: rotate(180deg);
        }

        /* Performance Optimizations */
        .dropdown-menu-level1,
        .dropdown-menu-level2 {
            will-change: opacity, transform;
        }

        .nav-icon-item,
        .dropdown-category-item,
        .dropdown-line-item {
            will-change: transform;
        }

        /* Enhanced Button Styles */
        .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Enhanced Link Hover Effects */
        footer a {
            transition: all 0.3s ease;
            position: relative;
        }

        footer a:hover {
            transform: translateX(3px);
        }

        /* Hydraulic Breakers Category and Product Lines Submenu */
        .hydraulic-breakers-category {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            background: transparent;
        }

        .hydraulic-breakers-category:hover {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            color: #0369a1;
            text-decoration: none;
            transform: translateX(8px) scale(1.02);
            border-color: #38bdf8;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.2);
        }

        .hydraulic-breakers-category a {
            color: inherit;
            text-decoration: none;
            flex-grow: 1;
            display: flex;
            align-items: center;
        }

        .hydraulic-breakers-category:hover a {
            color: inherit;
            text-decoration: none;
        }

        .hydraulic-breakers-category .fa-chevron-right {
            transition: all 0.3s ease;
            font-size: 0.875rem;
            color: #6b7280;
            flex-shrink: 0;
        }

        .hydraulic-breakers-category:hover .fa-chevron-right {
            transform: translateX(4px);
            color: #2563eb;
        }

        .product-lines-submenu {
            position: absolute;
            left: 100%;
            top: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            padding: 1.5rem;
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateX(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1060;
            margin-left: 10px;
        }

        .product-lines-submenu.show {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .submenu-header {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #007bff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .submenu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            background: transparent;
            position: relative;
            overflow: hidden;
        }

        .submenu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .submenu-item:hover::before {
            left: 100%;
        }

        .submenu-item:hover {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            color: #0369a1;
            text-decoration: none;
            transform: translateX(8px) scale(1.02);
            border-color: #38bdf8;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.2);
        }

        .submenu-item i {
            font-size: 1rem;
            width: 20px;
            transition: all 0.3s ease;
        }

        .submenu-item:hover i {
            transform: scale(1.1) rotate(5deg);
            color: #0284c7;
        }

        /* RTL Support for Submenu */
        html[dir='rtl'] .product-lines-submenu {
            left: auto;
            right: 100%;
            transform: translateX(10px);
        }

        html[dir='rtl'] .product-lines-submenu.show {
            transform: translateX(0);
        }

        html[dir='rtl'] .hydraulic-breakers-category .fa-chevron-right {
            transform: rotate(180deg);
        }

        html[dir='rtl'] .hydraulic-breakers-category:hover .fa-chevron-right {
            transform: rotate(180deg) translateX(-4px);
        }

        html[dir='rtl'] .submenu-item:hover {
            transform: translateX(-8px) scale(1.02);
        }

        /* Mobile Hydraulic Breakers Category */
        .hydraulic-breakers-mobile {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hydraulic-breakers-mobile a {
            color: inherit;
            text-decoration: none;
            flex-grow: 1;
            display: flex;
            align-items: center;
        }

        .hydraulic-breakers-mobile:hover a {
            color: inherit;
            text-decoration: none;
        }

        .hydraulic-breakers-mobile .nav-arrow {
            transition: all 0.3s ease;
            font-size: 0.875rem;
            color: #6b7280;
            flex-shrink: 0;
        }

        .hydraulic-breakers-mobile.expanded .nav-arrow {
            transform: rotate(90deg);
            color: #b0d701;
        }

        .mobile-nav-subsection-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 1rem;
        }

        .mobile-nav-subsection-content.expanded {
            max-height: 1000px;
            padding-top: 1rem;
        }

        /* Enhanced Icon Navigation */

        /* Korean Flag Styling */
        .korean-flag-container {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .korean-flag-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 84, 142, 0.1), rgba(176, 215, 1, 0.1));
            opacity: 0;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .korean-flag-container:hover::before {
            opacity: 1;
        }

        .korean-flag-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 84, 142, 0.2);
        }

        .korean-flag {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            object-fit: cover;
        }

        .korean-flag-container:hover .korean-flag {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* RTL Support for Korean Flag */
        html[dir='rtl'] .korean-flag-container {
            order: -1;
        }

        /* Responsive Korean Flag */
        @media (max-width: 1200px) {
            .korean-flag {
                width: 28px;
                height: 21px;
            }
        }

        @media (max-width: 768px) {
            .korean-flag-container {
                padding: 0.25rem;
            }

            .korean-flag {
                width: 24px;
                height: 18px;
            }
        }

        /* Korean Flag Animation */
        .korean-flag-container:hover .korean-flag {
            animation: flagWave 2s ease-in-out infinite;
        }

        @keyframes flagWave {
            0%, 100% {
                transform: scale(1.1) rotate(0deg);
            }
            25% {
                transform: scale(1.1) rotate(1deg);
            }
            75% {
                transform: scale(1.1) rotate(-1deg);
            }
        }
    </style>
</head>

<body class="bg-light">
    <!-- Enhanced Navbar with Mobile Sidebar -->
    <nav class="navbar navbar-expand-xl navbar-light fixed-top" style="backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.95);">
        <div class="container-fluid px-3 px-lg-4">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
                <img src="{{ asset('images/logo2.png') }}" alt="Soosan Logo" style="height: 60px; width: auto;">
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-nav-toggle d-xl-none" id="mobileNavToggle" type="button" aria-label="Toggle navigation">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <!-- Desktop Navigation -->
            <div class="navbar-nav-desktop d-none d-xl-flex flex-grow-1 justify-content-center">
                <ul class="navbar-nav align-items-center gap-4">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homepage') }}">
                            <i class="fas fa-home me-2"></i>
                            {{ __('common.home') }}
                        </a>
                    </li>

                    <!-- Products with Hover Dropdown -->
                    <li class="nav-item dropdown mega-dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="{{ route('products.index') }}" id="productsDropdown" role="button"
                           data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"
                           onmouseover="showProductsDropdown()" onmouseout="startHideTimer()">
                            <i class="fas fa-tools me-2"></i>
                            {{ __('common.products') }}
                        </a>
                        <div class="dropdown-menu mega-menu" id="productsDropdownMenu"
                             onmouseover="cancelHideTimer()" onmouseout="startHideTimer()">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="dropdown-header">{{ __('common.product_categories') }}</h6>
                                        <!-- Hydraulic breakers category with hover submenu -->
                                        <div class="dropdown-item hydraulic-breakers-category"
                                             onmouseover="showProductLines()" onmouseout="hideProductLines()">
                                            <a href="{{ route('products.index') }}" class="d-flex align-items-center flex-grow-1 text-decoration-none text-inherit">
                                                <i class="fas fa-cogs me-2"></i>{{ __('common.hydraulic_breakers') }}
                                            </a>
                                            <i class="fas fa-chevron-right ms-auto"></i>
                                            <div class="product-lines-submenu" id="productLinesSubmenu">
                                                <h6 class="submenu-header">{{ __('common.product_lines') }}</h6>
                                                <a class="submenu-item" href="{{ route('products.index', ['line[]' => 'SQ Line']) }}">
                                                    <i class="fas fa-cog me-2"></i>{{ __('common.SQ_line') }}
                                                </a>
                                                <a class="submenu-item" href="{{ route('products.index', ['line[]' => 'SB Line']) }}">
                                                    <i class="fas fa-cog me-2"></i>{{ __('common.SB_line') }}
                                                </a>
                                                <a class="submenu-item" href="{{ route('products.index', ['line[]' => 'SB-E Line']) }}">
                                                    <i class="fas fa-cog me-2"></i>{{ __('common.SB-E_line') }}
                                                </a>
                                                <a class="submenu-item" href="{{ route('products.index', ['line[]' => 'ET-II Line']) }}">
                                                    <i class="fas fa-cog me-2"></i>{{ __('common.ET-II_line') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6 class="dropdown-header">{{ __('common.quick_actions') }}</h6>
                                        <a class="dropdown-item" href="{{ route('products.index') }}">
                                            <i class="fas fa-th-large me-2"></i>{{ __('common.all_products') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('serial-lookup.index') }}">
                                            <i class="fas fa-search me-2"></i>{{ __('common.check_warranty') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- Check Warranty -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('serial-lookup.index') }}">
                            <i class="fas fa-shield-alt me-2"></i>
                            {{ __('common.check_warranty') }}
                        </a>
                    </li>

                    <!-- About Us -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('common.about_us') }}
                        </a>
                    </li>

                    <!-- Contact -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-2"></i>
                            {{ __('common.contact') }}
                        </a>
                    </li>

                    <!-- Support -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('support') }}">
                            <i class="fas fa-headset me-2"></i>
                            {{ __('common.support') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Desktop Right Side -->
            <div class="navbar-nav-right d-none d-xl-flex align-items-center gap-3">

                <!-- Enhanced Language Selector -->
                <div class="language-selector-container">
                    <div class="dropdown">
                        <button class="language-selector-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-2"></i>
                            <span class="current-lang">{{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <ul class="dropdown-menu language-dropdown">
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                                   href="{{ route('lang.switch', 'en') }}">
                                    <i class="fas fa-flag-usa me-2"></i>
                                    English
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'ar' ? 'active' : '' }}"
                                   href="{{ route('lang.switch', 'ar') }}">
                                    <i class="fas fa-flag me-2"></i>
                                    العربية
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Enhanced Login Button -->
                @guest
                    <a href="{{ route('admin.login') }}" class="enhanced-login-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        <span>{{ __('auth.login') }}</span>
                    </a>
                    <div class="korean-flag-container">
                        <img src="{{ asset('images/korean-flag-removebg-preview.webp') }}"
                            alt="Korean Flag"
                            class="korean-flag"
                            title="Korean Partnership">
                    </div>
                @else
                    <div class="dropdown user-dropdown">
                        <button class="enhanced-user-btn dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <img src="{{ Auth::user()->image_url ? asset(Auth::user()->image_url) : asset('images/fallback.webp') }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="user-avatar-img">
                            </div>

                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <small class="user-role">{{ Auth::user()->role ?? 'User' }}</small>
                            </div>
                        </button>
                        <ul class="dropdown-menu user-dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    {{ __('common.dashboard') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i>
                                    {{ __('common.profile') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        {{ __('auth.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <!-- Korean Flag -->
                    <div class="korean-flag-container">
                        <img src="{{ asset('images/korean-flag-removebg-preview.webp') }}"
                             alt="Korean Flag"
                             class="korean-flag"
                             title="Korean Partnership">
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Enhanced Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay d-xl-none" id="mobileNavOverlay"></div>

    <!-- Enhanced Mobile Navigation Sidebar -->
    <div class="mobile-nav-sidebar d-xl-none" id="mobileNavSidebar">
        <div class="mobile-nav-header">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo2.png') }}" alt="SoosanEgypt Logo" style="height: 40px; width: auto;">
            </div>
            <button type="button" class="btn btn-link text-white p-0" id="closeMobileNav">
                <i class="fas fa-times" style="font-size: 1.5rem;"></i>
            </button>
        </div>

        <div class="mobile-nav-content">
            <!-- Home -->
            <a class="mobile-nav-item-simple" href="{{ route('homepage') }}">
                <i class="fas fa-home me-3"></i>
                {{ __('common.home') }}
            </a>

            <!-- Products Section -->
            <div class="mobile-nav-section">
                <div class="mobile-nav-section-header" data-target="#mobile-products-section">
                    <i class="fas fa-tools me-3"></i>
                    <span class="fw-semibold">{{ __('common.products') }}</span>
                    <i class="fas fa-chevron-down ms-auto nav-arrow"></i>
                </div>
                <div id="mobile-products-section" class="mobile-nav-section-content">
                    <div class="mobile-nav-subsection">
                        <h6 class="mobile-nav-subheader">{{ __('common.product_categories') }}</h6>

                        <!-- Hydraulic breakers category with clickable link and expandable submenu -->
                        <div class="mobile-nav-item hydraulic-breakers-mobile" data-target="#mobile-product-lines">
                            <a href="{{ route('products.index') }}" class="d-flex align-items-center flex-grow-1 text-decoration-none text-inherit">
                                <i class="fas fa-cogs me-3"></i>{{ __('common.hydraulic_breakers') }}
                            </a>
                            <i class="fas fa-chevron-right ms-auto nav-arrow"></i>
                        </div>
                        <div id="mobile-product-lines" class="mobile-nav-subsection-content">
                            <h6 class="mobile-nav-subheader">{{ __('common.product_lines') }}</h6>
                            <a class="mobile-nav-item" href="{{ route('products.index', ['line[]' => 'SQ Line']) }}">
                                <i class="fas fa-cog me-3"></i>{{ __('common.SQ_line') }}
                            </a>
                            <a class="mobile-nav-item" href="{{ route('products.index', ['line[]' => 'SB Line']) }}">
                                <i class="fas fa-cog me-3"></i>{{ __('common.SB_line') }}
                            </a>
                            <a class="mobile-nav-item" href="{{ route('products.index', ['line[]' => 'SB-E Line']) }}">
                                <i class="fas fa-cog me-3"></i>{{ __('common.SB-E_line') }}
                            </a>
                            <a class="mobile-nav-item" href="{{ route('products.index', ['line[]' => 'ET-II Line']) }}">
                                <i class="fas fa-cog me-3"></i>{{ __('common.ET-II_line') }}
                            </a>
                        </div>
                    </div>

                    <div class="mobile-nav-subsection">
                        <h6 class="mobile-nav-subheader">{{ __('common.quick_actions') }}</h6>
                        <a class="mobile-nav-item" href="{{ route('products.index') }}">
                            <i class="fas fa-th-large me-3"></i>{{ __('common.all_products') }}
                        </a>
                        <a class="mobile-nav-item" href="{{ route('serial-lookup.index') }}">
                            <i class="fas fa-search me-3"></i>{{ __('common.check_warranty') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Check Warranty -->
            <a class="mobile-nav-item-simple" href="{{ route('serial-lookup.index') }}">
                <i class="fas fa-shield-alt me-3"></i>
                {{ __('common.check_warranty') }}
            </a>

            <!-- About Us -->
            <a class="mobile-nav-item-simple" href="{{ route('about') }}">
                <i class="fas fa-info-circle me-3"></i>
                {{ __('common.about_us') }}
            </a>

            <!-- Contact -->
            <a class="mobile-nav-item-simple" href="{{ route('contact') }}">
                <i class="fas fa-envelope me-3"></i>
                {{ __('common.contact') }}
            </a>

            <!-- Support -->
            <a class="mobile-nav-item-simple" href="{{ route('support') }}">
                <i class="fas fa-headset me-3"></i>
                {{ __('common.support') }}
            </a>

            <!-- Mobile Authentication -->
            <div class="mobile-nav-auth">
                @guest
                    <a href="{{ route('admin.login') }}" class="mobile-nav-auth-btn">
                        <i class="fas fa-sign-in-alt me-3"></i>
                        {{ __('auth.login') }}
                    </a>
                    @else
                    <div class="mobile-nav-user">
                        <div class="user-info">
                            <i class="fas fa-user-circle me-3"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <a href="{{ route('dashboard') }}" class="mobile-nav-item">
                            <i class="fas fa-tachometer-alt me-3"></i>
                            {{ __('common.dashboard') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="mobile-nav-item">
                            <i class="fas fa-user-edit me-3"></i>
                            {{ __('common.profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mobile-logout-form">
                            @csrf
                            <button type="submit" class="mobile-nav-logout-btn">
                                <i class="fas fa-sign-out-alt me-3"></i>
                                {{ __('auth.logout') }}
                            </button>
                        </form>
                    </div>
                @endguest
                </div>

            <!-- Mobile Language Section -->
            <div class="mobile-language-section">
                <div class="mobile-language-header">
                    <i class="fas fa-globe me-2"></i>
                    {{ __('common.language') }}
            </div>
                <div class="mobile-language-options">
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="mobile-language-option {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                        <i class="fas fa-flag-usa me-2"></i>
                        English
                    </a>
                    <a href="{{ route('lang.switch', 'ar') }}"
                       class="mobile-language-option {{ app()->getLocale() === 'ar' ? 'active' : '' }}">
                        <i class="fas fa-flag me-2"></i>
                        العربية
                    </a>
        </div>
            </div>
        </div>
    </div>

    <!-- Page Header/Search Slot -->
    @hasSection('page-header')
        <div class="bg-white border-bottom shadow-sm" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
            <div class="container">
                @yield('page-header')
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white">
        <div class="container py-5">
            <div class="row g-4">

                <!-- Company Info -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">SOOSAN</h5>
                    <p class="text-light small mb-3">{{ __('common.footer_description') }}</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/share/1KvmELF3Kn/?mibextid=wwXIfr" class="social facebook" aria-label="Facebook" target="_blank" title="SOOSAN EGYPT FACEBOOK">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/madina-contracting-company/" class="social linkedin" aria-label="LinkedIn" target="_blank" title="AL MADINA COMPANY LINKEDIN">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.youtube.com/@soosancebotics" class="social youtube" aria-label="YouTube" target="_blank" title="SOOSAN CEBOTICS YOUTUBE">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">{{ __('common.quick_links') }}</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('products.index') }}"
                                class="text-light text-decoration-none small">{{ __('common.products') }}</a></li>
                        <li class="mb-2"><a href="{{ route('serial-lookup.index') }}"
                                class="text-light text-decoration-none small">{{ __('common.check_warranty') }}</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}"
                                class="text-light text-decoration-none small">{{ __('common.about_us') }}</a></li>
                        <li class="mb-2"><a href="{{ route('support') }}"
                                class="text-light text-decoration-none small">{{ __('common.support') }}</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">{{ __('common.legal') }}</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('privacy') }}"
                                class="text-light text-decoration-none small">{{ __('common.privacy') }}</a></li>
                        <li class="mb-2"><a href="{{ route('terms') }}"
                                class="text-light text-decoration-none small">{{ __('common.terms') }}</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">{{ __('common.contact') }}</h5>
                    <div class="text-light small info">
                        <a href="https://maps.app.goo.gl/3CeG29sE5xK5uTBp6" target="_blank"><p class="mb-1">{{ __('common.st_address') }}</p></a>
                        <a href="https://maps.app.goo.gl/3CeG29sE5xK5uTBp6" target="_blank"><p class="mb-1">{{ __('common.city_country') }}</p></a>
                        <a href="tel:+201112696961"><p class="mb-1">{{ __('common.contact_phone_number') }}</p></a>
                        <a href="mailto:Info@soosanegypt.com"><p class="mb-1">{{ __('common.contact_email') }}</p></a>
                        <a href="mailto:Support@soosanegypt.com"><p class="mb-1">{{ __('common.support_email') }}</p></a>
                    </div>
                </div>
            </div>
            <style>
                .info a {
                    text-decoration: none;
                    color: #fff;
                }
            </style>

            <hr class="border-secondary mt-4 mb-3">
            <div class="text-center copy-right-section">
                <a href="https://soosancebotics.com/en/main" title="SOOSAN CEBOTICS" target="_blank">
                    <img src="{{ asset('images/soosan_logo_en.svg') }}" alt="SOOSAN CEBOTICS">
                </a>
                <p class="text-light small mb-0">&copy; {{ date('Y') }} AL-MADINA
                    {{ __('common.copyright') }}</p>
                <a href="https://madinagp.com/tag/al-madina-contracting-company/" title="AL MADINA CONRACTING COMPANY" target="_blank">
                    <img src="{{ asset('images/almadina2.png') }}" alt="AL MADINA CONTRACTING COMPANY">
                </a>
            </div>
            <div>
                <p class="powered-by">Developed by: A&K</p>
            </div>
        </div>

    </footer>

    <!-- Scripts -->
    <script>
        // Global Enhanced Navigation Functions
        function initGlobalNavEffects() {
            const navbar = document.querySelector('.navbar');
            let lastScrollY = window.scrollY;

            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;

                // Add scrolled class when scrolling down
                if (currentScrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                // Hide/show navbar on scroll (optional enhancement)
                if (currentScrollY > lastScrollY && currentScrollY > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }

                lastScrollY = currentScrollY;
            });
        }

        // Enhanced Icon Animations for All Pages
        function initGlobalIconAnimations() {
            const iconItems = document.querySelectorAll('.nav-icon-item');

            iconItems.forEach((item, index) => {
                // Add staggered entrance animation
                item.style.animationDelay = `${index * 0.1}s`;

                // Add click ripple effect
                item.addEventListener('click', function(e) {
                    // Don't add ripple if it's a navigation click
                    if (e.target.closest('a')) return;

                    // Create ripple element
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');

                    // Position ripple
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, transparent 70%);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                        z-index: 1000;
                    `;

                    this.appendChild(ripple);

                    // Remove ripple after animation
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });

                // Add hover effects
                item.addEventListener('mouseenter', function() {
                    this.style.filter = 'drop-shadow(0 4px 8px rgba(37, 99, 235, 0.2))';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.filter = 'none';
                });
            });
        }

        // Enhanced Button Interactions
        function initEnhancedButtons() {
            const buttons = document.querySelectorAll('.btn');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Add loading class for form submissions
                    if (this.type === 'submit') {
                        this.classList.add('loading');
                    }
                });
            });
        }

        // Enhanced Form Interactions
        function initEnhancedForms() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                    }
                });
            });
        }

        // Enhanced Card Interactions
        function initEnhancedCards() {
            const cards = document.querySelectorAll('.card');

            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        }

        // Unit switcher (if exists)
        function initUnitSwitcher() {
            const unitToggle = document.getElementById('unit-toggle');
            if (unitToggle) {
                unitToggle.addEventListener('click', function() {
                    const currentUnit = document.getElementById('current-unit');
                    const newUnit = currentUnit.textContent === 'SI' ? 'Imperial' : 'SI';
                    currentUnit.textContent = newUnit;

                    // Store in localStorage
                    localStorage.setItem('preferredUnit', newUnit);

                    // Trigger unit conversion on page
                    if (typeof convertUnits === 'function') {
                        convertUnits(newUnit);
                    }
                });
            }
        }

        // Page Loading Effects
        function initPageEffects() {
            // Fade in page content
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.3s ease';

            window.addEventListener('load', function() {
                document.body.style.opacity = '1';
            });

            // Initialize all enhancements after DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeEnhancements);
            } else {
                initializeEnhancements();
            }
        }

        // Initialize All Enhancements
        function initializeEnhancements() {
            // Load preferred settings
            const preferredUnit = localStorage.getItem('preferredUnit') || 'SI';
            const currentUnitElement = document.getElementById('current-unit');
            if (currentUnitElement) {
                currentUnitElement.textContent = preferredUnit;
            }

            if (typeof convertUnits === 'function') {
                convertUnits(preferredUnit);
            }

            // Initialize all global effects
            initGlobalNavEffects();
            initGlobalIconAnimations();
            initEnhancedButtons();
            initEnhancedForms();
            initEnhancedCards();
            initUnitSwitcher();

            // Initialize enhanced navbar components
            const languageSelector = document.querySelector('.language-selector-btn');
            if (languageSelector) {
                languageSelector.style.opacity = '0';
                languageSelector.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    languageSelector.style.transition = 'all 0.3s ease';
                    languageSelector.style.opacity = '1';
                    languageSelector.style.transform = 'scale(1)';
                }, 100);
            }

            // Add keyboard navigation support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('keyboard-navigation');
                }
            });

            document.addEventListener('mousedown', function() {
                document.body.classList.remove('keyboard-navigation');
            });
        }

        // Initialize page effects immediately
        initPageEffects();

        // Enhanced navigation and navbar functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth navigation without refresh
            const navLinks = document.querySelectorAll('.nav-icon-item[href]');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading state
                    const icon = this.querySelector('.nav-icon');
                    const originalClass = icon.className;

                    // Show loading spinner briefly
                    icon.className = 'fas fa-spinner fa-spin nav-icon';

                    // Restore original icon after short delay
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 300);
                });
            });

            // Enhanced multi-level dropdown functionality
            const dropdownItems = document.querySelectorAll('.dropdown-category-item');
            let activeDropdown = null;
            let dropdownTimeout = null;

            dropdownItems.forEach(item => {
                const level2Menu = item.querySelector('.dropdown-menu-level2');

                item.addEventListener('mouseenter', function() {
                    clearTimeout(dropdownTimeout);

                    // Hide other level 2 menus
                    dropdownItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            const otherLevel2 = otherItem.querySelector('.dropdown-menu-level2');
                            if (otherLevel2) {
                                otherLevel2.style.opacity = '0';
                                otherLevel2.style.visibility = 'hidden';
                                otherLevel2.style.transform = 'translateX(-10px)';
                            }
                        }
                    });

                    // Show current level 2 menu
                    if (level2Menu) {
                        setTimeout(() => {
                            level2Menu.style.opacity = '1';
                            level2Menu.style.visibility = 'visible';
                            level2Menu.style.transform = 'translateX(0)';
                        }, 100);
                    }
                });

                item.addEventListener('mouseleave', function() {
                    dropdownTimeout = setTimeout(() => {
                        if (level2Menu) {
                            level2Menu.style.opacity = '0';
                            level2Menu.style.visibility = 'hidden';
                            level2Menu.style.transform = 'translateX(-10px)';
                        }
                    }, 150);
                });

                // Keep level 2 menu open when hovering over it
                if (level2Menu) {
                    level2Menu.addEventListener('mouseenter', function() {
                        clearTimeout(dropdownTimeout);
                    });

                    level2Menu.addEventListener('mouseleave', function() {
                        this.style.opacity = '0';
                        this.style.visibility = 'hidden';
                        this.style.transform = 'translateX(-10px)';
                    });
                }
            });

            // Enhanced navbar scroll behavior
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                lastScrollTop = scrollTop;
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                const dropdown = e.target.closest('.navbar-nav-dropdown');
                if (!dropdown) {
                    dropdownItems.forEach(item => {
                        const level2Menu = item.querySelector('.dropdown-menu-level2');
                        if (level2Menu) {
                            level2Menu.style.opacity = '0';
                            level2Menu.style.visibility = 'hidden';
                            level2Menu.style.transform = 'translateX(-10px)';
                        }
                    });
                }
            });
        });
    </script>

    @stack('scripts')

    <!-- Enhanced Mobile Navigation JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Navigation Elements
            const mobileNavToggle = document.getElementById('mobileNavToggle');
            const mobileNavOverlay = document.getElementById('mobileNavOverlay');
            const mobileNavSidebar = document.getElementById('mobileNavSidebar');
            const closeMobileNav = document.getElementById('closeMobileNav');

            // Products Dropdown Hover Elements
            const productsDropdown = document.getElementById('productsDropdown');
            const productsDropdownMenu = document.getElementById('productsDropdownMenu');
            let dropdownTimer;

            // Mobile Navigation Functionality
            function openMobileNav() {
                if (mobileNavOverlay && mobileNavSidebar && mobileNavToggle) {
                    mobileNavOverlay.classList.add('show');
                    mobileNavSidebar.classList.add('show');
                    mobileNavToggle.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeMobileNavFunc() {
                if (mobileNavOverlay && mobileNavSidebar && mobileNavToggle) {
                    mobileNavOverlay.classList.remove('show');
                    mobileNavSidebar.classList.remove('show');
                    mobileNavToggle.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }

            // Event Listeners for Mobile Navigation
            if (mobileNavToggle) {
                mobileNavToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isOpen = mobileNavSidebar && mobileNavSidebar.classList.contains('show');
                    if (isOpen) {
                        closeMobileNavFunc();
                    } else {
                        openMobileNav();
                    }
                });
            }

            if (closeMobileNav) {
                closeMobileNav.addEventListener('click', closeMobileNavFunc);
            }

            if (mobileNavOverlay) {
                mobileNavOverlay.addEventListener('click', closeMobileNavFunc);
            }

            // Close mobile nav when clicking on nav links
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-item, .mobile-nav-item-simple, .mobile-nav-auth-btn');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Small delay to allow navigation to complete
                    setTimeout(closeMobileNavFunc, 150);
                });
            });

            // Mobile Navigation Section Toggle
            const sectionHeaders = document.querySelectorAll('.mobile-nav-section-header');
            sectionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetContent = document.querySelector(targetId);
                    const arrow = this.querySelector('.nav-arrow');

                    if (targetContent) {
                        const isExpanded = this.classList.contains('expanded');

                        // Toggle expanded state
                        this.classList.toggle('expanded', !isExpanded);
                        targetContent.classList.toggle('expanded', !isExpanded);

                        // Update arrow rotation
                        if (arrow) {
                            arrow.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
                        }
                    }
                });
            });

            // Mobile Hydraulic Breakers Category Toggle
            const hydraulicBreakersMobile = document.querySelector('.hydraulic-breakers-mobile');
            if (hydraulicBreakersMobile) {
                hydraulicBreakersMobile.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetContent = document.querySelector(targetId);
                    const arrow = this.querySelector('.nav-arrow');

                    if (targetContent) {
                        const isExpanded = this.classList.contains('expanded');

                        // Toggle expanded state
                        this.classList.toggle('expanded', !isExpanded);
                        targetContent.classList.toggle('expanded', !isExpanded);

                        // Update arrow rotation
                        if (arrow) {
                            arrow.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(90deg)';
                        }
                    }
                });
            }

            // Initialize mobile sections as collapsed
            function initializeMobileSections() {
                const sectionContents = document.querySelectorAll('.mobile-nav-section-content');
                sectionContents.forEach(content => {
                    content.classList.remove('expanded');
                });

                const sectionHeadersInit = document.querySelectorAll('.mobile-nav-section-header');
                sectionHeadersInit.forEach(header => {
                    header.classList.remove('expanded');
                    const arrow = header.querySelector('.nav-arrow');
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                });
            }

            initializeMobileSections();

            // Products Dropdown Hover Functionality
            window.showProductsDropdown = function() {
                if (productsDropdownMenu) {
                    clearTimeout(dropdownTimer);
                    productsDropdownMenu.classList.add('show');
                    productsDropdown.setAttribute('aria-expanded', 'true');
                }
            };

            window.startHideTimer = function() {
                dropdownTimer = setTimeout(() => {
                    if (productsDropdownMenu) {
                        productsDropdownMenu.classList.remove('show');
                        productsDropdown.setAttribute('aria-expanded', 'false');
                    }
                }, 300);
            };

            window.cancelHideTimer = function() {
                clearTimeout(dropdownTimer);
            };

            // Product Lines Submenu Functionality
            window.showProductLines = function() {
                const submenu = document.getElementById('productLinesSubmenu');
                if (submenu) {
                    clearTimeout(window.hideProductLinesTimer);
                    submenu.classList.add('show');
                }
            };

            window.hideProductLines = function() {
                const submenu = document.getElementById('productLinesSubmenu');
                if (submenu) {
                    window.hideProductLinesTimer = setTimeout(() => {
                        submenu.classList.remove('show');
                    }, 150);
                }
            };

            // Close submenu when clicking outside
            document.addEventListener('click', function(e) {
                const hydraulicCategory = document.querySelector('.hydraulic-breakers-category');
                const submenu = document.getElementById('productLinesSubmenu');

                if (hydraulicCategory && submenu && !hydraulicCategory.contains(e.target) && !submenu.contains(e.target)) {
                    submenu.classList.remove('show');
                }
            });

            // Keep submenu open when hovering over it
            const productLinesSubmenu = document.getElementById('productLinesSubmenu');
            if (productLinesSubmenu) {
                productLinesSubmenu.addEventListener('mouseenter', function() {
                    clearTimeout(window.hideProductLinesTimer);
                });

                productLinesSubmenu.addEventListener('mouseleave', function() {
                    window.hideProductLinesTimer = setTimeout(() => {
                        this.classList.remove('show');
                    }, 150);
                });
            }

            // Enhanced navbar scroll effect
            let lastScrollTop = 0;
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (navbar) {
                    if (scrollTop > 100) {
                        navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                        navbar.style.backdropFilter = 'blur(25px)';
                        navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.12)';
                    } else {
                        navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                        navbar.style.backdropFilter = 'blur(20px)';
                        navbar.style.boxShadow = '0 2px 15px rgba(0, 0, 0, 0.08)';
                    }
                }

                lastScrollTop = scrollTop;
            });

            // Escape key to close mobile nav
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileNavSidebar && mobileNavSidebar.classList.contains('show')) {
                    closeMobileNavFunc();
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1200) {
                    closeMobileNavFunc();
                }
            });

            // Touch-friendly enhancements for mobile
            if ('ontouchstart' in window) {
                document.body.classList.add('touch-device');

                // Add touch-specific styles
                const touchStyle = document.createElement('style');
                touchStyle.textContent = `
                    .touch-device .mobile-nav-item:active,
                    .touch-device .mobile-nav-item-simple:active {
                        background: linear-gradient(135deg, rgba(0, 84, 142, 0.15), rgba(176, 215, 1, 0.15));
                        transform: translateX(12px) scale(0.98);
                    }

                    .touch-device .mobile-nav-section-header:active {
                        background: linear-gradient(135deg, rgba(0, 84, 142, 0.15), rgba(176, 215, 1, 0.15));
                    }

                    .touch-device .language-toggle:active {
                        transform: scale(0.95);
                    }
                `;
                document.head.appendChild(touchStyle);
            }

            // Initialize Bootstrap dropdowns for desktop
            const dropdownElements = document.querySelectorAll('.dropdown-toggle');
            dropdownElements.forEach(element => {
                if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                    new bootstrap.Dropdown(element);
                }
            });

            // Performance optimization - add will-change properties
            const performanceStyle = document.createElement('style');
            performanceStyle.textContent = `
                @media (prefers-reduced-motion: reduce) {
                    .mobile-nav-sidebar,
                    .mobile-nav-overlay,
                    .mobile-nav-section-content,
                    .hamburger-line,
                    .nav-arrow {
                        transition: none !important;
                        animation: none !important;
                    }
                }

                .mobile-nav-sidebar {
                    will-change: transform;
                }

                .mobile-nav-overlay {
                    will-change: opacity;
                }

                .mobile-nav-section-content {
                    will-change: max-height;
                }
            `;
            document.head.appendChild(performanceStyle);

            console.log('Enhanced mobile navigation initialized successfully');
        });
    </script>

@if (!request()->is('admin*') && !request()->is('dashboard*'))
    <!-- Scroll to Top Button -->
    <button id="scrollToTopBtn" class="scroll-to-top-btn shadow rounded-circle d-flex align-items-center justify-content-center bg-primary"
        aria-label="{{ __('common.scroll_to_top') }}"
        style="position: fixed; bottom: 32px; right: 32px; width: 48px; height: 48px; color: #fff; border: none; z-index: 2000; display: none; transition: opacity 0.3s, visibility 0.3s;">
        <i class="fas fa-arrow-up"></i>
    </button>
    <style>
        .scroll-to-top-btn {
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 8px 32px rgba(0, 84, 142, 0.18);
            font-size: 1.5rem;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .scroll-to-top-btn i {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            vertical-align: middle !important;
            line-height: 1 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }
        .scroll-to-top-btn.show {
            opacity: 1;
            visibility: visible;
        }
        .scroll-to-top-btn:active {
            transform: scale(0.95);
        }
        html[dir='rtl'] .scroll-to-top-btn {
            right: auto;
            left: 32px;
            padding-right: 14px;
        }
    </style>
    <script>
        (function() {
            const btn = document.getElementById('scrollToTopBtn');
            let ticking = false;
            function toggleBtn() {
                if (window.scrollY > 200) {
                    btn.classList.add('show');
                    btn.style.display = 'flex';
                } else {
                    btn.classList.remove('show');
                    setTimeout(() => { btn.style.display = 'none'; }, 300);
                }
            }
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        toggleBtn();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
            btn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();
    </script>
@endif
</body>
</html>
