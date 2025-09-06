@extends('layouts.public')

@section('title', 'Contact SOOSAN - Get Expert Support for Drilling Equipment')
@section('description', 'Contact SoosanEgypt for expert support, equipment inquiries, and professional drilling solutions. Get in touch with our team for hydraulic breakers, construction machinery, and industrial equipment in Egypt.')
@section('keywords', 'contact SoosanEgypt, drilling equipment support, hydraulic breaker inquiries, construction machinery Egypt, industrial equipment support, customer service')
@section('og_image', asset('images/logo2.png'))

@push('structured_data')
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ContactPage",
        "name": "Contact SoosanEgypt",
        "description": "Contact us for expert support and equipment inquiries",
        "url": "{{ url('/contact') }}",
        "mainEntity": {
            "@type": "Organization",
            "name": "SoosanEgypt",
            "contactPoint": [
                {
                    "@type": "ContactPoint",
                    "contactType": "customer service",
                    "telephone": "+20-123-456-7890",
                    "email": "info@soosanegypt.com",
                    "availableLanguage": ["English", "Arabic"]
                }
            ]
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
                "name": "Contact",
                "item": "{{ url('/contact') }}"
            }
        ]
    }
</script>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
    :root {
        --primary-color: #00548e;
        --secondary-color: #b0d701;
        --accent-color: #4ade80;
        --background-color: #f8fafc;
        --text-color: #111827;
        --text-muted: #6b7280;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --transition-duration: 0.3s;
        --border-radius: 16px;
        --card-shadow: 0 4px 20px rgba(0, 84, 142, 0.08);
        --card-shadow-hover: 0 8px 32px rgba(0, 84, 142, 0.15);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        background: var(--background-color);
        overflow-x: hidden;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: var(--border-radius);
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-color);
    }

    /* Enhanced Hero Section */
    .contact-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, #0066a3 100%);
        color: white;
        padding: 8rem 0 5rem;
        margin-top: 0;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
            radial-gradient(circle at 20% 30%, rgba(176, 215, 1, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="contact-grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23contact-grid)"/></svg>');
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .contact-hero h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        line-height: 1.2;
    }

    .contact-hero .lead {
        font-size: clamp(1.1rem, 2.5vw, 1.4rem);
        font-weight: 400;
        opacity: 0.95;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    /* Enhanced Hero Stats */
    .hero-stats {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-top: 3rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .stat-item {
        text-align: center;
        position: relative;
        transition: all var(--transition-duration) ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
    }

    .stat-item::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .stat-item:last-child::after {
        display: none;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        display: block;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--secondary-color), #9bc600);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: none;
    }

    /* Enhanced Contact Methods */
    .contact-methods {
        padding: 6rem 0;
        background: linear-gradient(135deg, var(--background-color) 0%, #ffffff 100%);
        position: relative;
    }

    .contact-methods::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots-pattern" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(0,84,142,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots-pattern)"/></svg>');
        z-index: 0;
    }

    .contact-methods .container {
        position: relative;
        z-index: 1;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .section-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        color: var(--text-color);
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .section-description {
        font-size: 1.2rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .contact-method-card {
        background: white;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border-color);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
        text-align: center;
    }

    .contact-method-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .contact-method-card:hover::before {
        transform: scaleX(1);
    }

    .contact-method-card:hover {
        transform: translateY(-12px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(0, 84, 142, 0.2);
    }

    .method-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), #0066a3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 24px rgba(0, 84, 142, 0.25);
        transition: all 0.4s ease;
    }

    .contact-method-card:hover .method-icon {
        background: linear-gradient(135deg, var(--secondary-color), #9bc600);
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 32px rgba(176, 215, 1, 0.4);
    }

    .method-action {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition-duration) ease;
        margin-top: 1rem;
        position: relative;
        overflow: hidden;
    }

    .method-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .method-action:hover::before {
        left: 100%;
    }

    .method-action:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(176, 215, 1, 0.3);
        color: white;
        text-decoration: none;
    }

    /* Enhanced Contact Form */
    .contact-form-section {
        padding: 6rem 0;
        background: white;
        position: relative;
    }

    .contact-form-container {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 84, 142, 0.1);
        border: 1px solid var(--border-color);
        overflow: hidden;
        position: relative;
    }

    .contact-form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 84, 142, 0.02), rgba(176, 215, 1, 0.02));
        z-index: 1;
    }

    .form-header {
        background: linear-gradient(135deg, var(--background-color), #e2e8f0);
        padding: 3rem 3rem 2rem;
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        position: relative;
        z-index: 2;
    }

    .form-body {
        padding: 3rem;
        position: relative;
        z-index: 2;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        display: block;
    }

    .form-control, .form-select {
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all var(--transition-duration) ease;
        background: #fafafa;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 84, 142, 0.1);
        background: white;
        transform: translateY(-1px);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .send-message {
        background: var(--primary-color);
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        padding: 1rem 2rem;
        border: none;
        border-radius: 50px;
        transition: all var(--transition-duration) ease;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .send-message::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }

    .send-message:hover::before {
        left: 100%;
    }

    .send-message:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(176, 215, 1, 0.3);
    }

    /* Enhanced Departments */
    .departments-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, var(--background-color) 0%, #e2e8f0 100%);
        position: relative;
    }

    .departments-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dept-grid" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="15" cy="15" r="1" fill="rgba(0,84,142,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23dept-grid)"/></svg>');
        z-index: 0;
    }

    .departments-section .container {
        position: relative;
        z-index: 1;
    }

    .department-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border-color);
        transition: all var(--transition-duration) ease;
        height: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .department-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 84, 142, 0.02), rgba(176, 215, 1, 0.02));
        opacity: 0;
        transition: opacity var(--transition-duration) ease;
    }

    .department-card:hover::before {
        opacity: 1;
    }

    .department-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(0, 84, 142, 0.2);
    }

    .dept-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-color), #0066a3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 16px rgba(0, 84, 142, 0.25);
        transition: all var(--transition-duration) ease;
        position: relative;
        z-index: 2;
    }

    .department-card:hover .dept-icon {
        background: linear-gradient(135deg, var(--secondary-color), #9bc600);
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(176, 215, 1, 0.4);
    }

    /* Enhanced FAQ Section */
    .faq-section {
        padding: 6rem 0;
        background: white;
    }

    .faq-item {
        background: var(--background-color);
        border-radius: var(--border-radius);
        margin-bottom: 1rem;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all var(--transition-duration) ease;
        box-shadow: 0 2px 8px rgba(0, 84, 142, 0.05);
    }

    .faq-item:hover {
        box-shadow: 0 4px 16px rgba(0, 84, 142, 0.1);
        border-color: rgba(0, 84, 142, 0.2);
    }

    .faq-question {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        padding: 1.25rem 1.5rem;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-color);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all var(--transition-duration) ease;
    }

    .faq-question:hover {
        background: rgba(0, 84, 142, 0.05);
        color: var(--primary-color);
    }

    .faq-question i {
        transition: transform var(--transition-duration) ease;
        color: var(--primary-color);
    }

    .faq-answer {
        padding: 0 1.5rem 1.25rem;
        color: var(--text-muted);
        line-height: 1.7;
        font-size: 1.1rem;
        display: none;
        margin-top: 1rem;
    }

    .faq-answer.active {
        display: block;
        animation: fadeInDown 0.3s ease;
    }

    /* Enhanced Floating Contact */
    .floating-contact {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        z-index: 1000;
    }

    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--secondary-color), #9bc600);
        color: white;
        border: none;
        box-shadow: 0 8px 24px rgba(176, 215, 1, 0.4);
        font-size: 1.5rem;
        cursor: pointer;
        transition: all var(--transition-duration) ease;
        position: relative;
        animation: pulse 2s infinite;
    }

    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 32px rgba(176, 215, 1, 0.5);
    }

    /* Animations */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-in {
        animation: slideUp 0.8s ease-out;
    }

    /* Enhanced Responsive Design */
    @media (max-width: 1024px) {
        .contact-hero {
            padding: 6rem 0 4rem;
        }

        .contact-methods,
        .contact-form-section,
        .departments-section,
        .faq-section {
            padding: 4rem 0;
        }
    }

    @media (max-width: 768px) {
        .contact-hero {
            /* margin-top: 70px; */
            padding: 5rem 0 3rem;
        }

        .contact-hero h1 {
            font-size: 2.25rem;
            line-height: 1.1;
            margin-bottom: 1rem;
        }

        .contact-hero .lead {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .hero-stats {
            margin-top: 2rem;
            padding: 1.5rem;
        }

        .stat-item {
            margin-bottom: 1rem;
        }

        .stat-item::after {
            display: none;
        }

        .stat-number {
            font-size: 2rem;
        }

        .contact-methods,
        .contact-form-section,
        .departments-section,
        .faq-section {
            padding: 3rem 0;
        }

        .section-title {
            font-size: 2.25rem;
            margin-bottom: 1rem;
        }

        .section-description {
            font-size: 1.05rem;
            margin-bottom: 2rem;
        }

        .contact-method-card,
        .department-card {
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .method-icon,
        .dept-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-header,
        .form-body {
            padding: 2rem 1.5rem;
        }

        .form-control,
        .form-select {
            padding: 1rem;
            font-size: 1rem;
        }

        .send-message {
            padding: 1.125rem 2rem;
            font-size: 1rem;
        }
        .floating-contact {
            left: 1rem;
            right: auto;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .faq-question {
            font-size: 1.1rem;
            padding: 1.25rem 1.5rem;
        }

        .faq-answer {
            padding: 0 1.5rem 1.25rem;
            font-size: 1rem;
        }

        /* Better touch targets for mobile */
        .btn,
        .method-action,
        .contact-action,
        .send-message {
            min-height: 44px;
            padding: 1rem 1.5rem;
        }

        /* Improved form layout for mobile */
        .form-group {
            margin-bottom: 1.25rem;
        }

        /* Better spacing */
        .container {
            padding: 0 1rem;
        }
    }

    @media (max-width: 480px) {
        .contact-hero {
            padding: 4rem 0 2.5rem;
            /* margin-top: 60px; */
        }

        .contact-hero h1 {
            font-size: 1.9rem;
            line-height: 1.1;
            margin-bottom: 0.75rem;
        }

        .contact-hero .lead {
            font-size: 1rem;
            margin-bottom: 1.25rem;
        }

        .hero-stats {
            padding: 1.25rem;
            margin-top: 1.5rem;
        }

        .stat-number {
            font-size: 1.75rem;
        }

        .stat-item {
            margin-bottom: 0.75rem;
        }

        .contact-methods,
        .contact-form-section,
        .departments-section,
        .faq-section {
            padding: 2.5rem 0;
        }

        .section-title {
            font-size: 1.9rem;
            margin-bottom: 0.75rem;
        }

        .section-description {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .contact-method-card,
        .department-card {
            padding: 1.5rem 1.25rem;
            margin-bottom: 1.25rem;
        }

        .method-icon,
        .dept-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .form-header {
            padding: 1.75rem 1.25rem 1.5rem;
        }

        .form-body {
            padding: 1.75rem 1.25rem;
        }

        .form-control,
        .form-select {
            padding: 0.875rem;
            font-size: 0.95rem;
        }

        .send-message {
            padding: 1rem 1.75rem;
            font-size: 0.95rem;
        }

        .faq-question {
            font-size: 1rem;
            padding: 1.125rem 1.25rem;
        }

        .faq-answer {
            padding: 0 1.25rem 1.125rem;
            font-size: 0.9rem;
        }

        .method-action,
        .contact-action {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }

        .floating-btn {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }

        /* Enhanced mobile layouts */
        .container {
            padding: 0 0.75rem;
        }

        .row.g-4 {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }

        /* Better readability */
        body {
            font-size: 15px;
            line-height: 1.6;
        }

        /* Optimize touch targets */
        .btn,
        .method-action,
        .contact-action,
        .send-message,
        .floating-btn {
            min-height: 44px;
        }
    }

    /* Ultra-small screens */
    @media (max-width: 360px) {
        .contact-hero h1 {
            font-size: 1.7rem;
        }

        .section-title {
            font-size: 1.7rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .contact-method-card,
        .department-card {
            padding: 1.25rem 1rem;
        }

        .method-icon,
        .dept-icon {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }

        .form-header,
        .form-body {
            padding: 1.5rem 1rem;
        }

        .container {
            padding: 0 0.5rem;
        }
    }

    /* Landscape mobile orientation */
    @media (max-width: 768px) and (orientation: landscape) {
        .contact-hero {
            padding: 3rem 0 2rem;
        }

        .hero-stats {
            margin-top: 1.5rem;
        }

        .stat-item::after {
            display: block;
        }

        .contact-methods,
        .contact-form-section,
        .departments-section,
        .faq-section {
            padding: 2.5rem 0;
        }
    }

    /* High DPI displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .method-icon,
        .dept-icon,
        .contact-icon {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
    }

    /* Enhanced RTL Support */
    [dir="rtl"] {
        text-align: right;
    }

    [dir="rtl"] .contact-hero {
        text-align: center;
    }

    [dir="rtl"] .hero-content {
        text-align: center;
    }

    [dir="rtl"] .stat-item {
        text-align: center;
    }

    [dir="rtl"] .stat-item::after {
        right: auto;
        left: 0;
    }

    [dir="rtl"] .contact-method-card,
    [dir="rtl"] .department-card {
        text-align: center;
    }

    [dir="rtl"] .form-label {
        text-align: right;
    }

    [dir="rtl"] .form-control,
    [dir="rtl"] .form-select {
        text-align: right;
        direction: rtl;
    }

    [dir="rtl"] .form-control::placeholder {
        text-align: right;
    }

    [dir="rtl"] .faq-question {
        text-align: right;
        flex-direction: row-reverse;
    }

    [dir="rtl"] .faq-answer {
        text-align: right;
    }

    [dir="rtl"] .floating-contact {
        right: auto;
        left: 2rem;
    }

    [dir="rtl"] .method-action,
    [dir="rtl"] .send-message {
        direction: rtl;
    }

    [dir="rtl"] .method-action i,
    [dir="rtl"] .send-message i {
        margin-right: 0;
        margin-left: 0.5rem;
    }

    [dir="rtl"] .btn i {
        margin-right: 0;
        margin-left: 0.5rem;
    }

    /* Enhanced Responsive Design */
    @media (max-width: 1200px) {
        .contact-hero {
            padding: 6rem 0 4rem;
        }

        .contact-methods,
        .contact-form-section,
        .departments-section,
        .faq-section {
            padding: 4rem 0;
        }

        .section-title {
            font-size: 2.75rem;
        }

        .section-description {
            font-size: 1.15rem;
        }
    }

    /* Print Styles */
    @media print {
        .contact-hero {
            background: white !important;
            color: black !important;
            padding: 2rem 0 !important;
        }

        .floating-contact {
            display: none !important;
        }

        .contact-method-card,
        .department-card,
        .faq-item {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
            break-inside: avoid;
        }
    }

    /* Accessibility Enhancements */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Focus States */
    .contact-method-card:focus-within,
    .department-card:focus-within,
    .faq-item:focus-within {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }

    .method-action:focus,
    .send-message:focus,
    .floating-btn:focus {
        outline: 2px solid var(--secondary-color);
        outline-offset: 4px;
    }

    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .contact-method-card,
        .department-card,
        .faq-item {
            border: 2px solid var(--text-color);
        }

        .section-title {
            color: var(--text-color);
        }
    }
</style>
@endpush

@section('content')
    <!-- Enhanced Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="hero-content animate-slide-in">
                        <h1 class="display-3 fw-bold mb-4">
                            {{ __('common.get_in_touch') }}
                        </h1>
                        <p class="lead mb-4">
                            {{ __('common.ready_to_transform') }}
                        </p>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center mb-4">
                            <a href="#contact-form" class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('common.send_message') }}
                            </a>
                            <a href="tel:+201112696961" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                                <i class="fas fa-phone me-2"></i>{{ __('common.call_now') }}
                            </a>
                        </div>

                        <!-- Enhanced Stats -->
                        <div class="hero-stats">
                            <div class="row g-4">
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">{{ __('common.support_numbers') }}</span>
                                        <span class="fw-semibold">{{ __('common.support') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">{{ __('common.project_numbers') }}</span>
                                        <span class="fw-semibold">{{ __('common.projects') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">{{ __('common.country_numbers') }}</span>
                                        <span class="fw-semibold">{{ __('common.countries') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <span class="stat-number">{{ __('common.years_experience') }}</span>
                                        <span class="fw-semibold">{{ __('common.years') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Contact Methods -->
    <section class="contact-methods">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('common.multiple_ways_to_reach_us') }}</h2>
                <p class="section-description">{{ __('common.choose_contact_method') }}</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.call_us') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.speak_directly_with_experts') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">{{ __('common.phone_no') }}</strong>
                            <small class="text-muted">{{ __('common.emergency_support') }}</small>
                        </div>
                        <a href="tel:+15551234567" class="method-action">
                            <i class="fas fa-phone me-2"></i>{{ __('common.call_now') }}
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.email_us') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.send_detailed_inquiries') }}</p>
                        <div class="mb-3">
                            <a href="mailto:Info@soosanegypt.com"><strong class="d-block">Info@soosanegypt.com</strong></a>
                            <a href="mailto:Support@soosanegypt.com"><strong class="d-block">Support@soosanegypt.com</strong></a>
                            <small class="text-muted">{{ __('common.response_within_24_hours') }}</small>
                        </div>
                        <a href="mailto:Info@soosanegypt.com" class="method-action">
                            <i class="fas fa-envelope me-2"></i>{{ __('common.send_email') }}
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="method-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.whatsapp') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.quick_messaging') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">{{ __('common.phone_no') }}</strong>
                            <small class="text-muted">{{ __('common.mon_fri_8am_6pm') }}</small>
                        </div>
                        <a href="https://wa.me/201112696961" class="method-action" target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>{{ __('common.chat_now') }}
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="contact-method-card">
                        <div class="method-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.visit_us') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.come_see_showroom') }}</p>
                        <div class="mb-3">
                            <strong class="d-block">{{ __('common.industrial_district') }}</strong>
                            <small class="text-muted">{{ __('common.st_address') }}</small>
                        </div>
                        <a href="https://maps.app.goo.gl/3CeG29sE5xK5uTBp6" class="method-action" target="_blank">
                            <i class="fas fa-directions me-2"></i>{{ __('common.get_directions') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Contact Form -->
    <section class="contact-form-section" id="contact-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-form-container">
                        <div class="form-header">
                            <h2 class="display-6 fw-bold mb-3">{{ __('common.send_us_a_message') }}</h2>
                            <p class="fs-5 text-muted mb-0">{{ __('common.fill_out_form_24_hours') }}</p>
                        </div>
                        <div class="form-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ __('common.contact_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">
                                                {{ __('common.first_name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="first_name" name="first_name" required
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name') }}"
                                                placeholder="{{ __('common.enter_first_name') }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" class="form-label">
                                                {{ __('common.last_name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="last_name" name="last_name" required
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name') }}"
                                                placeholder="{{ __('common.enter_last_name') }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                {{ __('common.email_address') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" required
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}"
                                                placeholder="{{ __('common.your_email_placeholder') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">
                                                {{ __('common.phone_number') }}
                                            </label>
                                            <input type="tel" id="phone" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}"
                                                placeholder="{{ __('common.phone_placeholder') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company" class="form-label">
                                                {{ __('common.company_name') }}
                                            </label>
                                            <input type="text" id="company" name="company"
                                                class="form-control @error('company') is-invalid @enderror"
                                                value="{{ old('company') }}"
                                                placeholder="{{ __('common.your_company_name') }}">
                                            @error('company')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="form-label">
                                                {{ __('common.subject') }} <span class="text-danger">*</span>
                                            </label>
                                            <select id="subject" name="subject" required
                                                class="form-select @error('subject') is-invalid @enderror">
                                                <option value="">{{ __('common.choose_a_subject') }}</option>
                                                <option value="sales" {{ old('subject') == 'sales' ? 'selected' : '' }}>
                                                    {{ __('common.sales_inquiry') }}</option>
                                                <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>
                                                    {{ __('common.technical_support') }}</option>
                                                <option value="parts" {{ old('subject') == 'parts' ? 'selected' : '' }}>
                                                    {{ __('common.parts_service') }}</option>
                                                <option value="warranty" {{ old('subject') == 'warranty' ? 'selected' : '' }}>
                                                    {{ __('common.warranty_claim') }}</option>
                                                <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>
                                                    {{ __('common.partnership_opportunity') }}</option>
                                                <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>
                                                    {{ __('common.other') }}</option>
                                            </select>
                                            @error('subject')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="message" class="form-label">
                                                {{ __('common.message') }} <span class="text-danger">*</span>
                                            </label>
                                            <textarea id="message" name="message" rows="6" required
                                                placeholder="{{ __('common.message_placeholder') }}"
                                                class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn py-3 send-message">
                                                <i class="fas fa-paper-plane me-2"></i>{{ __('common.send_message') }}
                                            </button>
                                        </div>
                                        <p class="text-center text-muted mt-3 mb-0">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            {{ __('common.information_secure') }}
                                        </p>
                                        <p class="text-center text-muted mt-2">
                                            {!! __('common.if_you_want_to_buy_email_us') !!}
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Departments -->
    <section class="departments-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('common.specialized_departments') }}</h2>
                <p class="section-description">{{ __('common.connect_directly_with_teams') }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.sales_team') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.equipment_quotes_pricing') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.technical_support') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.equipment_troubleshooting') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.parts_service') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.spare_parts_maintenance') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="department-card">
                        <div class="dept-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">{{ __('common.customer_service') }}</h3>
                        <p class="text-muted mb-3">{{ __('common.general_inquiries_account') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-header">
                        <h2 class="section-title">{{ __('common.frequently_asked_questions') }}</h2>
                        <p class="section-description">{{ __('common.quick_answers_common_questions') }}</p>
                    </div>

                    <div class="faq-container">
                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_types_drilling_equipment') }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.we_offer_comprehensive_range') }}
                            </div>
                        </div>

                        <!-- <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.do_you_provide_international_shipping') }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.yes_we_ship_worldwide') }}
                            </div>
                        </div> -->

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.what_warranty_do_you_offer') }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.all_equipment_comes_with_warranty') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.do_you_provide_training') }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                {{ __('common.absolutely_we_provide_training') }}
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" onclick="toggleFAQ(this)">
                                <span>{{ __('common.how_can_i_get_quote') }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                {{!! __('common.you_can_request_quote') !!}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Floating Contact Button -->
    <div class="floating-contact">
        <button class="floating-btn" onclick="scrollToForm()" title="{{ __('common.send_message') }}">
            <i class="fas fa-comment"></i>
        </button>
    </div>

@endsection

@push('scripts')
<script>
    // Enhanced FAQ Toggle
    function toggleFAQ(button) {
        const answer = button.nextElementSibling;
        const icon = button.querySelector('i');
        const isActive = answer.classList.contains('active');

        // Close all other FAQ items with smooth animation
        document.querySelectorAll('.faq-answer.active').forEach(item => {
            if (item !== answer) {
                item.classList.remove('active');
                const otherIcon = item.previousElementSibling.querySelector('i');
                otherIcon.style.transform = 'rotate(0deg)';
                item.previousElementSibling.style.background = '';
            }
        });

        // Toggle current item with enhanced animation
        if (isActive) {
            answer.classList.remove('active');
            icon.style.transform = 'rotate(0deg)';
            button.style.background = '';
        } else {
            answer.classList.add('active');
            icon.style.transform = 'rotate(180deg)';
            button.style.background = 'rgba(0, 84, 142, 0.05)';
        }
    }

    // Enhanced scroll to form
    function scrollToForm() {
        const formSection = document.getElementById('contact-form');
        if (formSection) {
            formSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            // Add focus to first form input
            setTimeout(() => {
                const firstInput = formSection.querySelector('input[type="text"]');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 800);
        }
    }

    // Enhanced form validation
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();

                    // Focus on first invalid field
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
                form.classList.add('was-validated');
            });
        });

        // Enhanced input animations
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
                if (this.value) {
                    this.parentElement.classList.add('filled');
                } else {
                    this.parentElement.classList.remove('filled');
                }
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = `${index * 0.1}s`;
                    entry.target.classList.add('animate-slide-in');
                }
            });
        }, observerOptions);

        // Observe all animatable elements
        document.querySelectorAll('.contact-method-card, .department-card, .faq-item').forEach(element => {
            observer.observe(element);
        });

        // Enhanced floating button behavior
        let lastScrollY = window.scrollY;
        const floatingBtn = document.querySelector('.floating-btn');

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                // Scrolling down
                floatingBtn.style.transform = 'scale(0.8)';
                floatingBtn.style.opacity = '0.7';
            } else {
                // Scrolling up
                floatingBtn.style.transform = 'scale(1)';
                floatingBtn.style.opacity = '1';
            }

            lastScrollY = currentScrollY;
        });

        // Enhanced error handling
        window.addEventListener('error', function(e) {
            console.warn('Contact page error:', e.error);
        });

        // Enhanced performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(() => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    if (perfData && perfData.loadEventEnd > 3000) {
                        console.warn('Contact page loaded slowly:', perfData.loadEventEnd + 'ms');
                    }
                }, 0);
            });
        }
    });
</script>
@endpush
