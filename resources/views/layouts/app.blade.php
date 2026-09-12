@php
    use App\Models\Setting;

    $siteHeaderLogo = Setting::get('site_logo_header', '');
    $siteFooterLogo = Setting::get('site_logo_footer', '');
    $siteFavicon = Setting::get('site_favicon', '');
    $sitePrimaryColor = Setting::get('site_primary_color', '#0A1D37');
    $siteSecondaryColor = Setting::get('site_secondary_color', '#0D3B66');
    $siteAccentColor = Setting::get('site_accent_color', '#E5A919');
    $siteMarineColor = Setting::get('site_marine_color', '#1E6FAE');
    $contactFacebook = Setting::get('contact_facebook', 'https://facebook.com');
    $contactInstagram = Setting::get('contact_instagram', 'https://instagram.com');
    $contactYoutube = Setting::get('contact_youtube', 'https://youtube.com');
    $contactLinkedin = Setting::get('contact_linkedin', 'https://linkedin.com');
    $contactWhatsapp = Setting::get('contact_whatsapp', '+201200001122');
    $contactPhone = Setting::get('contact_phone', '+20 120 000 1122');
    $contactEmail = Setting::get('contact_email', 'info@alexmarine.eg');
    $contactAddress = Setting::get('contact_address', app()->getLocale() == 'en' ? 'Alexandria Customs Zone - Port of Alexandria, Egypt' : 'المنطقة الجمركية - ميناء الإسكندرية، مصر');
    $isEn = app()->getLocale() == 'en';
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $isEn ? 'ALEX MARINE — Marine & Industrial Safety Supplies' : 'أليكس مارين — التوريدات البحرية ومهمات الأمن الصناعي')</title>
    <meta name="description" content="@yield('meta_description', $isEn ? 'ALEX MARINE specializes in commercial marine supplies, industrial safety PPE, and fire fighting equipment maintenance.' : 'شركة أليكس مارين متخصصة في التوريدات البحرية، معدات السلامة والأمن الصناعي، وصيانة معدات الإطفاء وأجهزة التنفس.')">

    @if(!empty($siteFavicon))
        <link rel="icon" href="{{ $siteFavicon }}" type="image/x-icon">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- AOS — Animate on Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Dynamic Brand Colors & Refined UI Styles -->
    <style>
        @font-face {
            font-family: 'Bahij TheSansArabic';
            src: url('{{ asset("fonts/Bahij_TheSansArabic-Bold.ttf") }}') format('truetype');
            font-weight: 700 900;
            font-style: normal;
            font-display: swap;
        }
        :root {
            --font-heading: 'Bahij TheSansArabic', 'Cairo', 'Tajawal', sans-serif;
            --font-primary: 'Cairo', 'Tajawal', 'Bahij TheSansArabic', sans-serif;
            --font-en:      'Inter', sans-serif;
            --font-num:     'Inter', 'Cairo', sans-serif;
            --alex-navy-dark:   {{ $sitePrimaryColor }};
            --alex-navy-med:    {{ $siteSecondaryColor }};
            --alex-gold:        {{ $siteAccentColor }};
            --alex-gold-gradient: linear-gradient(135deg, #FAD961 0%, #F7B731 35%, #D49B23 70%, #B37D14 100%);
            --alex-gold-gradient-hover: linear-gradient(135deg, #FFF0B3 0%, #FCD04B 40%, #E5A315 75%, #C48712 100%);
            --alex-gold-text-gradient: linear-gradient(135deg, #FFF3C4 0%, #FAD961 25%, #E5A919 65%, #C28B15 100%);
            --alex-gold-glow:    0 4px 18px rgba(229, 169, 25, 0.38);
            --alex-blue-marine: {{ $siteMarineColor }};
        }
        html, body {
            overflow-x: hidden !important;
            max-width: 100% !important;
            width: 100% !important;
            position: relative;
        }
        body, button, input, select, textarea {
            font-family: var(--font-primary);
            font-feature-settings: "lnum" 1;
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .fw-bold, .fw-extrabold {
            font-family: var(--font-heading);
        }
        .num-tabular, .product-card-sku, .showroom-product-sub, .price-val, .badge-num {
            font-family: var(--font-num);
            font-variant-numeric: tabular-nums;
            font-feature-settings: "lnum" 1, "tnum" 1;
        }
        [dir="ltr"] body, body[dir="ltr"],
        [dir="ltr"] button, [dir="ltr"] input, [dir="ltr"] select, [dir="ltr"] textarea,
        [dir="ltr"] h1, [dir="ltr"] h2, [dir="ltr"] h3, [dir="ltr"] h4, [dir="ltr"] h5, [dir="ltr"] h6,
        .font-inter body, body.font-inter,
        .font-inter button, .font-inter input {
            font-family: var(--font-en) !important;
        }

        /* ════════════════════════════════════════════
           UNIFIED LUXURY MOTION SYSTEM (AOS & TRANSITIONS)
        ════════════════════════════════════════════ */
        :root {
            --ease-luxury: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-luxury-soft: cubic-bezier(0.22, 1, 0.36, 1);
            --motion-duration-base: 600ms;
        }

        [data-aos] {
            pointer-events: auto !important;
            transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        /* Calm luxury vertical reveal: subtle 16px serene glide */
        [data-aos="fade-up"] {
            transform: translate3d(0, 16px, 0) !important;
            opacity: 0;
            transition-property: transform, opacity !important;
        }
        [data-aos="fade-down"] {
            transform: translate3d(0, -16px, 0) !important;
            opacity: 0;
            transition-property: transform, opacity !important;
        }
        /* Subtle lateral glides - gentle and harmonic across RTL/LTR */
        [data-aos="fade-right"] {
            transform: translate3d(14px, 0, 0) !important;
            opacity: 0;
            transition-property: transform, opacity !important;
        }
        [data-aos="fade-left"] {
            transform: translate3d(-14px, 0, 0) !important;
            opacity: 0;
            transition-property: transform, opacity !important;
        }
        [data-aos].aos-animate {
            transform: translate3d(0, 0, 0) !important;
            opacity: 1 !important;
        }

        /* Luxury Scroll-triggered animations for custom elements */
        .anim-fade-up {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .anim-fade-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Luxury WhatsApp Floating Widget */
        .alex-wa-widget {
            position: fixed;
            bottom: 25px;
            left: 25px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        [dir="ltr"] .alex-wa-widget {
            left: auto;
            right: 25px;
            flex-direction: row-reverse;
        }
        .alex-wa-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.85rem;
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.35);
            position: relative;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .alex-wa-btn::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #25D366;
            opacity: 0.45;
            animation: waPulseLuxury 3.2s infinite cubic-bezier(0.16, 1, 0.3, 1);
            z-index: -1;
        }
        @keyframes waPulseLuxury {
            0% { transform: scale(0.98); opacity: 0.55; }
            50% { transform: scale(1.22); opacity: 0.12; }
            100% { transform: scale(1.36); opacity: 0; }
        }
        .alex-wa-badge {
            background: #ffffff;
            color: #0A192F;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(37, 211, 102, 0.3);
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            transition: all 0.3s ease;
        }
        .alex-wa-badge .wa-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #25D366;
            display: inline-block;
            box-shadow: 0 0 6px #25D366;
        }
        .alex-wa-widget:hover .alex-wa-btn {
            transform: scale(1.08) translateY(-3px);
            box-shadow: 0 12px 30px rgba(37, 211, 102, 0.6);
        }
        .alex-wa-widget:hover .alex-wa-badge {
            background: #0A192F;
            color: #ffffff;
            border-color: #D4AF37;
            transform: translateY(-2px);
        }

        /* Luxury Header Action Buttons (Uniform Sizing, Pixel-Perfect Padding) */
        .alex-nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .no-caret::after {
            display: none !important;
        }
        .alex-nav-btn {
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border-radius: 10px;
            background: #F8FAFC;
            color: #0A1D37;
            border: 1px solid #E2E8F0;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            line-height: 1;
        }
        .alex-nav-btn i {
            font-size: 1.1rem;
            color: #475569;
            transition: color 0.2s ease;
        }
        .alex-nav-btn:hover {
            background: #FFFFFF;
            color: #0A1D37;
            border-color: #D4AF37;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(10, 29, 55, 0.08);
        }
        .alex-nav-btn:hover i {
            color: #D4AF37;
        }
        .alex-nav-btn-icon {
            width: 40px;
            padding: 0;
        }
        .alex-nav-btn-lang {
            padding: 0 14px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .alex-nav-btn-mobile-cart {
            background: #FFFDF5;
            border-color: #F3D270;
            color: #B37D14;
        }
        .alex-nav-btn-mobile-cart i {
            color: #D4AF37;
        }
        .alex-nav-btn-mobile-cart .alex-nav-cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #0A1D37;
            color: #FFFFFF;
            font-size: 0.65rem;
            font-weight: 800;
            height: 18px;
            min-width: 18px;
            padding: 0 4px;
            border-radius: 9px;
            border: 1.5px solid #FFFFFF;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        [dir="ltr"] .alex-nav-btn-mobile-cart .alex-nav-cart-badge {
            right: auto;
            left: -5px;
        }
        .alex-mobile-toggle-btn {
            background: #0A1D37 !important;
            color: #FFFFFF !important;
            border: 1px solid #0A1D37 !important;
        }
        .alex-mobile-toggle-btn i {
            color: #FFFFFF !important;
            font-size: 1.25rem;
        }
        .alex-mobile-toggle-btn:hover {
            background: #0D3B66 !important;
            border-color: #D4AF37 !important;
        }
        .alex-mobile-toggle-btn:hover i {
            color: #D4AF37 !important;
        }

        .alex-nav-cart {
            height: 40px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 16px;
            border-radius: 10px;
            background: linear-gradient(135deg, #FAD961 0%, #D49B23 100%);
            color: #0A1D37 !important;
            border: 1px solid #D4AF37;
            font-size: 0.88rem;
            font-weight: 800;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(212, 175, 55, 0.28);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            line-height: 1;
        }
        .alex-nav-cart i {
            font-size: 1.1rem;
            color: #0A1D37;
        }
        .alex-nav-cart:hover {
            background: linear-gradient(135deg, #FFF0B3 0%, #E5A315 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(212, 175, 55, 0.4);
            color: #000000 !important;
        }
        .alex-nav-cart-badge {
            background: #0A1D37;
            color: #FFFFFF;
            font-size: 0.72rem;
            font-weight: 800;
            height: 20px;
            min-width: 20px;
            padding: 0 5px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Luxury Mega Menu Refinements */
        .freshio-mega-menu {
            border-radius: 16px !important;
            background: #FFFFFF !important;
            box-shadow: 0 20px 50px rgba(10, 25, 47, 0.12) !important;
            border: 1px solid #E2E8F0 !important;
            margin-top: 0.5rem;
            z-index: 1100;
        }
        .mega-cat-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mega-cat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #D4AF37;
            font-size: 1.15rem;
            flex-shrink: 0;
            transition: all 0.25s ease;
        }
        .mega-cat-card:hover {
            background-color: #FFFFFF;
            border-color: #D4AF37;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(10, 25, 47, 0.08);
        }
        .mega-cat-card:hover .mega-cat-icon {
            background: #0A192F;
            color: #D4AF37;
            border-color: #0A192F;
        }
        .mega-cat-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #0A192F;
            margin-bottom: 2px;
            transition: color 0.2s ease;
        }
        .mega-cat-card:hover .mega-cat-title {
            color: #B8860B;
        }
        .mega-cat-desc {
            font-size: 0.76rem;
            color: #64748B;
            line-height: 1.35;
        }

        /* ─────────────────────────────────────────────────────────────
           LUXURY MOBILE OFFCANVAS DRAWER STYLING
        ───────────────────────────────────────────────────────────── */
        .alex-mobile-offcanvas {
            width: 330px !important;
            background-color: #FFFFFF;
            z-index: 10600;
            box-shadow: 0 0 35px rgba(0, 0, 0, 0.35);
        }
        .drawer-header {
            background: linear-gradient(135deg, #0A1D37 0%, #0D3B66 100%);
            border-bottom: 2.5px solid #D4AF37 !important;
            padding: 1.1rem 1.25rem;
        }
        .drawer-close-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .drawer-close-btn:hover {
            background: rgba(212, 175, 55, 0.3);
            border-color: #D4AF37;
            transform: rotate(90deg);
        }
        .drawer-auth-card {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 1rem;
        }
        .mobile-search-box {
            position: relative;
            margin-bottom: 1.1rem;
        }
        .mobile-search-input {
            width: 100%;
            padding: 10px 42px 10px 14px;
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            color: #0A1D37;
            outline: none;
            transition: all 0.2s ease;
        }
        [dir="ltr"] .mobile-search-input {
            padding: 10px 14px 10px 42px;
        }
        .mobile-search-input:focus {
            background: #FFFFFF;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }
        .mobile-search-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 8px;
            background: transparent;
            border: none;
            color: #64748B;
            font-size: 1.1rem;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        [dir="ltr"] .mobile-search-btn {
            right: auto;
            left: 8px;
        }
        .mobile-nav-menu {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .mobile-nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-radius: 10px;
            color: #0A1D37;
            font-size: 0.92rem;
            font-weight: 700;
            text-decoration: none;
            background: #FFFFFF;
            border: 1px solid transparent;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mobile-nav-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .mobile-nav-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #F1F5F9;
            color: #0A1D37;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .mobile-nav-item:hover {
            background: #F8FAFC;
            border-color: #E2E8F0;
            color: #0A1D37;
            transform: translateX(-3px);
        }
        [dir="ltr"] .mobile-nav-item:hover {
            transform: translateX(3px);
        }
        .mobile-nav-item.active {
            background: #0A1D37;
            color: #FFFFFF;
            border-color: #0A1D37;
            box-shadow: 0 4px 14px rgba(10, 29, 55, 0.2);
        }
        .mobile-nav-item.active .mobile-nav-icon-box {
            background: rgba(212, 175, 55, 0.25);
            color: #FAD961;
        }
        .mobile-nav-item.active .bi-chevron-left,
        .mobile-nav-item.active .bi-chevron-right {
            color: #D4AF37 !important;
        }

        /* ─────────────────────────────────────────────────────────────
           LUXURY MOBILE BOTTOM NAVIGATION BAR & RESPONSIVE STYLING
        ───────────────────────────────────────────────────────────── */
        .alex-mobile-bottom-nav {
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            background: #0A1D37 !important;
            background: linear-gradient(180deg, #0A1D37 0%, #061122 100%) !important;
            border-top: 2px solid #D4AF37 !important;
            box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.45) !important;
            z-index: 99999 !important;
            padding-bottom: env(safe-area-inset-bottom, 0px) !important;
            display: block !important;
        }

        @media (min-width: 992px) {
            .alex-mobile-bottom-nav {
                display: none !important;
            }
        }
        .bottom-nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-around;
            height: 60px;
            max-width: 600px;
            margin: 0 auto;
            padding: 0 4px;
        }
        .bottom-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            color: rgba(255, 255, 255, 0.65) !important;
            text-decoration: none;
            position: relative;
            padding: 6px 2px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            border: none;
            background: transparent;
            cursor: pointer;
        }
        .bottom-nav-item:hover, .bottom-nav-item.active {
            color: var(--alex-gold, #D4AF37) !important;
            transform: translateY(-2px);
        }
        .bottom-nav-item.active::after {
            content: '';
            position: absolute;
            bottom: 2px;
            width: 14px;
            height: 3px;
            border-radius: 2px;
            background: var(--alex-gold, #D4AF37);
            box-shadow: 0 0 8px var(--alex-gold, #D4AF37);
        }
        .bottom-nav-icon {
            position: relative;
            font-size: 1.25rem;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .bottom-nav-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            line-height: 1;
        }
        .bottom-nav-cart .bottom-nav-icon .alex-nav-cart-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: linear-gradient(135deg, #FAD961 0%, #D49B23 100%);
            color: #0A1D37;
            font-weight: 900;
            font-size: 0.66rem;
            height: 18px;
            min-width: 18px;
            padding: 0 4px;
            border-radius: 9px;
            border: 1.5px solid #0A1D37;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }
        [dir="ltr"] .bottom-nav-cart .bottom-nav-icon .alex-nav-cart-badge {
            right: auto;
            left: -10px;
        }

        @media (max-width: 991.98px) {
            body {
                padding-bottom: 74px !important;
            }
            .navbar-alex {
                padding: 0.55rem 0 !important;
                background: #FFFFFF !important;
                border-bottom: 1px solid #E2E8F0 !important;
                box-shadow: 0 2px 10px rgba(10, 29, 55, 0.04) !important;
            }
            .alex-wa-widget {
                bottom: 78px !important;
                left: 16px !important;
                z-index: 1030;
            }
            [dir="ltr"] .alex-wa-widget {
                left: auto !important;
                right: 16px !important;
            }
            .alex-wa-btn {
                width: 48px;
                height: 48px;
                font-size: 1.5rem;
            }
            .alex-wa-badge {
                display: none !important;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand-title {
                font-size: 0.98rem !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="{{ $isEn ? 'font-inter' : '' }}">

    <!-- ════════════════════════════════════════════
         MAIN NAVBAR — Freshio E-Commerce Style Header
    ════════════════════════════════════════════ -->
    <header id="main-navbar" class="navbar-alex {{ request()->routeIs('home') ? 'home-navbar-auto-hide' : '' }}">
        <div class="container-fluid px-3 px-sm-4 px-lg-5">
            <nav class="navbar navbar-expand-lg py-0 w-100 align-items-center justify-content-between flex-nowrap">

                <!-- Brand Logo (Official Alex Marine Logo) -->
                <a class="navbar-brand d-flex align-items-center py-0 my-0 me-0" href="{{ route('home') }}">
                    @php
                        $headerBrandLogo = !empty($siteHeaderLogo) ? $siteHeaderLogo : (file_exists(public_path('uploads/Alex-marin.svg')) ? '/uploads/Alex-marin.svg' : '');
                    @endphp
                    @if(!empty($headerBrandLogo))
                        <img src="{{ \Illuminate\Support\Str::startsWith($headerBrandLogo, ['http://', 'https://']) ? $headerBrandLogo : asset($headerBrandLogo) }}"
                             alt="ALEX MARINE"
                             class="brand-logo-img"
                             style="max-height: 40px; width: auto; max-width: 170px; object-fit: contain;">
                    @else
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:38px;height:38px;background:var(--alex-navy-dark, #0A1D37);border:1.5px solid var(--alex-gold, #D4AF37);">
                                <i class="bi bi-anchor" style="font-size:1.2rem;color:var(--alex-gold, #D4AF37);"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="navbar-brand-title fw-bold" style="color:var(--alex-navy-dark, #0A1D37); font-size:1.08rem; line-height:1.1; letter-spacing:-0.2px;">ALEX MARINE</div>
                                <div class="navbar-brand-subtitle text-muted d-none d-sm-block" style="font-size:0.66rem; font-weight:600;">{{ $isEn ? 'Marine Supplies' : 'للتوريدات البحرية' }}</div>
                            </div>
                        </div>
                    @endif
                </a>

                <!-- Desktop Center Navigation Links (>= 992px) -->
                <div class="collapse navbar-collapse justify-content-center d-none d-lg-flex" id="mainNavbar">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center freshio-nav-links">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                {{ $isEn ? 'Home' : 'الرئيسية' }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                {{ $isEn ? 'About Us' : 'من نحن' }}
                            </a>
                        </li>

                        <!-- Products Mega Menu (Wide) -->
                        <li class="nav-item dropdown dropdown-mega position-static">
                            <a class="nav-link dropdown-toggle d-inline-flex align-items-center gap-1 {{ request()->routeIs('products.*') ? 'active' : '' }}"
                               href="{{ route('products.index') }}"
                               id="navProductsDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <span>{{ $isEn ? 'Products' : 'المنتجات' }}</span>
                                <i class="bi bi-chevron-down nav-chevron-icon"></i>
                            </a>
                            <div class="dropdown-menu freshio-mega-menu border-0 p-0 shadow-lg" aria-labelledby="navProductsDropdown">
                                <div class="p-4">
                                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom flex-wrap gap-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $isEn ? 'All Product Departments' : 'أقسام وتوريدات المنتجات الرئيسية' }}</h6>
                                            <small class="text-muted fs-8">{{ $isEn ? 'Explore all certified supplies and marine equipment.' : 'استكشف قائمة المنتجات والتوريدات الجاهزة للتوريد الفوري' }}</small>
                                        </div>
                                        <a href="{{ route('products.index') }}" class="btn-alex-gold px-3 py-1 fs-8 text-decoration-none">
                                            <span>{{ $isEn ? 'View Full Catalog' : 'عرض دليل المنتجات بالكامل' }}</span>
                                            <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
                                        </a>
                                    </div>

                                    @php
                                        $catsToDisplay = isset($navCategories) && count($navCategories) > 0
                                            ? $navCategories
                                             : \App\Models\Category::where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->get();
                                        if($catsToDisplay->isEmpty()) {
                                            $catsToDisplay = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(6)->get();
                                        }
                                    @endphp
                                    <div class="row g-3">
                                        @foreach($catsToDisplay as $navCat)
                                            <div class="col-md-6 col-lg-4">
                                                <a href="{{ route('products.index', ['category' => $navCat->slug]) }}" class="mega-cat-card">
                                                    <div class="mega-cat-icon">
                                                        <i class="bi {{ $navCat->icon ?: 'bi-box-seam' }}"></i>
                                                    </div>
                                                    <div class="text-truncate" style="min-width: 0;">
                                                        <div class="mega-cat-title text-truncate">
                                                            {{ $isEn ? ($navCat->name_en ?: $navCat->name_ar) : $navCat->name_ar }}
                                                        </div>
                                                        @if(!empty($navCat->description_ar) || !empty($navCat->description_en))
                                                            <div class="mega-cat-desc text-truncate">
                                                                {{ Str::limit($isEn ? ($navCat->description_en ?: $navCat->description_ar) : $navCat->description_ar, 45) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mega-bottom-bar mt-3 pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted fs-8">
                                        <div>
                                            <a href="{{ route('quote.index') }}" class="text-primary text-decoration-none fw-bold">
                                                {{ $isEn ? 'Need Custom Order? Request Quote' : 'طلب توريد خاص؟ اطلب عرض سعر' }} &larr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                                {{ $isEn ? 'Services' : 'الخدمات' }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                                {{ $isEn ? 'Projects & Cases' : 'مشاريعنا' }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                {{ $isEn ? 'Contact' : 'تواصل معنا' }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Right Action Buttons (Search, User, Lang, Basket / Mobile Actions) -->
                @php $quoteCount = count(session('quote_cart', [])); @endphp
                <div class="alex-nav-actions d-flex align-items-center gap-2 flex-nowrap ms-auto ms-lg-0">

                    <!-- Search Button Trigger (Available on all screens) -->
                    <button type="button" class="alex-nav-btn alex-nav-btn-icon" data-bs-toggle="modal" data-bs-target="#navSearchModal" title="{{ $isEn ? 'Search Products' : 'بحث في المنتجات' }}" aria-label="Search">
                        <i class="bi bi-search"></i>
                    </button>

                    <!-- Mobile Quote Cart Icon Button (< 992px) -->
                    <a href="{{ route('quote.index') }}" class="alex-nav-btn alex-nav-btn-icon alex-nav-btn-mobile-cart position-relative d-lg-none" title="{{ $isEn ? 'Quote Cart' : 'سلة طلبات التسعير' }}" aria-label="Quote Cart">
                        <i class="bi bi-basket2-fill"></i>
                        <span class="alex-nav-cart-badge js-quote-header-count">{{ $quoteCount }}</span>
                    </a>

                    <!-- Language Switcher (Desktop Only) -->
                    <a href="{{ route('lang.switch', $isEn ? 'ar' : 'en') }}" class="alex-nav-btn alex-nav-btn-lang d-none d-lg-inline-flex" title="{{ $isEn ? 'Switch to Arabic' : 'Switch to English' }}">
                        <span>{{ $isEn ? 'عربي' : 'EN' }}</span>
                    </a>

                    <!-- User / Account Button (Desktop Only) -->
                    @auth
                        <div class="dropdown d-none d-lg-block">
                            <button class="alex-nav-btn alex-nav-btn-icon dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" title="{{ Auth::user()->name }}">
                                <i class="bi bi-person-fill" style="color: #D4AF37;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 py-2" style="min-width:210px;">
                                <li class="px-3 py-2 border-bottom">
                                    <strong class="d-block text-dark fs-7">{{ Auth::user()->name }}</strong>
                                    <small class="text-muted fs-8">{{ Auth::user()->email }}</small>
                                </li>
                                <li><a class="dropdown-item py-2" href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i>{{ $isEn ? 'Dashboard' : 'لوحة التحكم' }}</a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-lock me-2 text-warning"></i>{{ $isEn ? 'Admin Panel' : 'لوحة الإدارة' }}</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-left me-2"></i>{{ $isEn ? 'Logout' : 'تسجيل الخروج' }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="alex-nav-btn alex-nav-btn-icon d-none d-lg-inline-flex" title="{{ $isEn ? 'Login' : 'تسجيل الدخول' }}">
                            <i class="bi bi-person"></i>
                        </a>
                    @endauth

                    <!-- Quote Cart / RFQ Button (Desktop Gold Pill with Count Badge) -->
                    <a href="{{ route('quote.index') }}" class="alex-nav-cart d-none d-lg-inline-flex" title="{{ $isEn ? 'Quote Cart' : 'سلة طلبات التسعير' }}">
                        <i class="bi bi-basket2-fill"></i>
                        <span>{{ $isEn ? 'Quote Cart' : 'طلب تسعير' }}</span>
                        <span class="alex-nav-cart-badge js-quote-header-count">{{ $quoteCount }}</span>
                    </a>

                    <!-- Mobile Drawer Toggle Button (< 992px) -->
                    <button class="alex-nav-btn alex-nav-btn-icon alex-mobile-toggle-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainMobileNavbar" aria-controls="mainMobileNavbar" aria-label="Toggle navigation">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- ════════════════════════════════════════════
         LUXURY OFFCANVAS MOBILE NAVIGATION DRAWER
    ════════════════════════════════════════════ -->
    <div class="offcanvas offcanvas-{{ $isEn ? 'start' : 'end' }} alex-mobile-offcanvas d-lg-none" tabindex="-1" id="mainMobileNavbar" aria-labelledby="mainMobileNavbarLabel">
        <!-- Drawer Header -->
        <div class="drawer-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 min-w-0">
                @php
                    $drawerLogo = !empty($siteHeaderLogo) ? $siteHeaderLogo : (file_exists(public_path('uploads/Alex-marin.svg')) ? '/uploads/Alex-marin.svg' : '');
                @endphp
                @if(!empty($drawerLogo))
                    <img src="{{ \Illuminate\Support\Str::startsWith($drawerLogo, ['http://', 'https://']) ? $drawerLogo : asset($drawerLogo) }}"
                         alt="ALEX MARINE"
                         style="max-height: 38px; width: auto; max-width: 155px; object-fit: contain;">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:36px;height:36px;background:rgba(212,175,55,0.2);border:1.5px solid var(--alex-gold, #D4AF37);">
                        <i class="bi bi-anchor" style="font-size:1.15rem;color:var(--alex-gold, #D4AF37);"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-white" style="font-size:1.05rem; line-height:1.1;">ALEX MARINE</div>
                        <div class="text-white-50" style="font-size:0.68rem;">{{ $isEn ? 'Marine & Industrial Supplies' : 'التوريدات البحرية المعتمدة' }}</div>
                    </div>
                @endif
            </div>
            <button type="button" class="drawer-close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-x-lg" style="font-size: 1rem;"></i>
            </button>
        </div>

        <div class="offcanvas-body p-3 d-flex flex-column justify-content-between">
            <div>
                <!-- User Profile / Auth Area -->
                @auth
                    <div class="drawer-auth-card d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2 min-w-0">
                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px;height:36px;">
                                <i class="bi bi-person-fill fs-5" style="color:var(--alex-gold, #D4AF37);"></i>
                            </div>
                            <div class="text-truncate">
                                <strong class="d-block text-dark fs-7 text-truncate">{{ Auth::user()->name }}</strong>
                                <small class="text-muted fs-8 text-truncate d-block">{{ Auth::user()->email }}</small>
                            </div>
                        </div>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-outline-dark fs-8 px-2 py-1 fw-bold flex-shrink-0">{{ $isEn ? 'Portal' : 'لوحتي' }}</a>
                    </div>
                @else
                    <div class="drawer-auth-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-person-circle text-warning fs-5"></i>
                            <div>
                                <span class="fw-bold text-dark fs-7 d-block">{{ $isEn ? 'Welcome to ALEX MARINE' : 'أهلاً بك في أليكس مارين' }}</span>
                                <small class="text-muted fs-8">{{ $isEn ? 'B2B Marine & Safety Supplies' : 'بوابتك للتوريدات والسلامة البحرية' }}</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-dark flex-grow-1 py-1-5 fw-bold fs-8">
                                <i class="bi bi-box-arrow-in-right me-1"></i> {{ $isEn ? 'Sign In' : 'تسجيل الدخول' }}
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-sm btn-alex-gold flex-grow-1 py-1-5 fw-bold fs-8">
                                <i class="bi bi-person-plus-fill me-1"></i> {{ $isEn ? 'Register' : 'حساب جديد' }}
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Search Input Form -->
                <div class="mobile-search-box">
                    <form action="{{ route('products.index') }}" method="GET">
                        <input type="text"
                               name="search"
                               class="mobile-search-input"
                               placeholder="{{ $isEn ? 'Search products, SKU...' : 'بحث في المنتجات، الكود...' }}"
                               autocomplete="off">
                        <button class="mobile-search-btn" type="submit" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Navigation Links List with Rich Visuals -->
                <div class="mobile-nav-menu mb-3">
                    <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <div class="mobile-nav-item-left">
                            <div class="mobile-nav-icon-box">
                                <i class="bi bi-house-door-fill"></i>
                            </div>
                            <span>{{ $isEn ? 'Home' : 'الرئيسية' }}</span>
                        </div>
                        <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} text-muted" style="font-size: 0.75rem;"></i>
                    </a>

                    <a href="{{ route('about') }}" class="mobile-nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <div class="mobile-nav-item-left">
                            <div class="mobile-nav-icon-box">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                            <span>{{ $isEn ? 'About Us' : 'من نحن' }}</span>
                        </div>
                        <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} text-muted" style="font-size: 0.75rem;"></i>
                    </a>

                    <a href="{{ route('products.index') }}" class="mobile-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <div class="mobile-nav-item-left">
                            <div class="mobile-nav-icon-box">
                                <i class="bi bi-box-seam-fill"></i>
                            </div>
                            <span>{{ $isEn ? 'Products Catalog' : 'دليل المنتجات والتوريدات' }}</span>
                        </div>
                        <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} text-muted" style="font-size: 0.75rem;"></i>
                    </a>

                    <a href="{{ route('services.index') }}" class="mobile-nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        <div class="mobile-nav-item-left">
                            <div class="mobile-nav-icon-box">
                                <i class="bi bi-gear-wide-connected"></i>
                            </div>
                            <span>{{ $isEn ? 'Services & Maintenance' : 'الخدمات والصيانة' }}</span>
                        </div>
                        <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} text-muted" style="font-size: 0.75rem;"></i>
                    </a>

                    <a href="{{ route('projects.index') }}" class="mobile-nav-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <div class="mobile-nav-item-left">
                            <div class="mobile-nav-icon-box">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <span>{{ $isEn ? 'Projects & Portfolio' : 'مشاريعنا وسابقة الأعمال' }}</span>
                        </div>
                        <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} text-muted" style="font-size: 0.75rem;"></i>
                    </a>

                    <a href="{{ route('contact') }}" class="mobile-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <div class="mobile-nav-item-left">
                            <div class="mobile-nav-icon-box">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <span>{{ $isEn ? 'Contact Us' : 'تواصل معنا' }}</span>
                        </div>
                        <i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }} text-muted" style="font-size: 0.75rem;"></i>
                    </a>
                </div>

                <!-- Categories Quick Pills -->
                <div class="pt-2 border-top">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted fw-bold fs-8 text-uppercase">{{ $isEn ? 'Key Categories' : 'الأقسام والتصنيفات' }}</span>
                        <a href="{{ route('products.index') }}" class="text-primary fs-8 text-decoration-none fw-bold">{{ $isEn ? 'All' : 'الكل' }} &larr;</a>
                    </div>
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        @foreach($catsToDisplay as $cat)
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="cat-pill py-1 px-2 fs-8 text-decoration-none">
                                <i class="bi {{ $cat->icon ?: 'bi-tag' }} me-1" style="font-size: 0.75rem; color: #D4AF37;"></i>
                                {{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Drawer Bottom: Language Switch & Hotline -->
            <div class="border-top pt-3 mt-2">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fs-8 text-muted fw-bold">{{ $isEn ? 'Language:' : 'اللغة:' }}</span>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('lang.switch', 'ar') }}" class="btn btn-outline-dark {{ !$isEn ? 'active fw-bold' : '' }} fs-8 py-1">عربي</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="btn btn-outline-dark {{ $isEn ? 'active fw-bold' : '' }} fs-8 py-1">EN</a>
                    </div>
                </div>
                <a href="https://wa.me/201200001122" target="_blank" class="btn btn-success w-100 py-2 fs-7 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm rounded-3">
                    <i class="bi bi-whatsapp fs-5"></i>
                    <span>{{ $isEn ? 'WhatsApp Direct' : 'تواصل عبر واتساب' }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-xl shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-xl shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @endif

    <!-- Page Content -->
    <main id="main-content">
        @yield('content')
    </main>

    <!-- ════════════════════════════════════════════
         FOOTER — Corporate Dark Navy
    ════════════════════════════════════════════ -->
    <footer class="footer-alex">

        <div class="footer-top">
            <div class="container footer-content">
                <div class="row g-5">

                    <!-- Brand Column -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-logo-area d-flex align-items-center gap-3">
                            @if(!empty($siteFooterLogo))
                                <img src="{{ $siteFooterLogo }}" alt="ALEX MARINE" style="max-height:120px; object-fit:contain;">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded-3"
                                     style="width:48px;height:48px;background:linear-gradient(135deg,var(--alex-navy-med),var(--alex-blue-marine)); flex-shrink:0;">
                                    <i class="bi bi-anchor fs-4" style="color:var(--alex-gold);"></i>
                                </div>
                                <div>
                                    <div class="footer-brand-title">ALEX MARINE</div>
                                    <div class="footer-brand-subtitle">{{ $isEn ? 'Marine & Industrial Supplies' : 'للتوريدات البحرية والصناعية' }}</div>
                                </div>
                            @endif
                        </div>

                        <p class="footer-desc mt-3">
                            {{ $isEn
                                ? 'ALEX MARINE specializes in marine supplies, industrial PPE, and fire fighting equipment. Certified to SOLAS, ISO & MED international standards.'
                                : 'أليكس مارين شركة مصرية متخصصة في التوريدات البحرية ومهمات الأمن الصناعي وصيانة معدات الإطفاء وفق أحدث معايير SOLAS و ISO الدولية.' }}
                        </p>

                        <!-- Social Icons -->
                        <div class="d-flex gap-2 flex-wrap">
                            @if(!empty($contactWhatsapp))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}" target="_blank" class="footer-social-link" title="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @endif
                            @if(!empty($contactFacebook))
                                <a href="{{ $contactFacebook }}" target="_blank" class="footer-social-link" title="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if(!empty($contactInstagram))
                                <a href="{{ $contactInstagram }}" target="_blank" class="footer-social-link" title="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if(!empty($contactYoutube))
                                <a href="{{ $contactYoutube }}" target="_blank" class="footer-social-link" title="YouTube">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            @endif
                            @if(!empty($contactLinkedin))
                                <a href="{{ $contactLinkedin }}" target="_blank" class="footer-social-link" title="LinkedIn">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            @endif
                            <a href="mailto:{{ $contactEmail }}" class="footer-social-link" title="Email">
                                <i class="bi bi-envelope-fill"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-6">
                        <h6 class="footer-col-title">{{ $isEn ? 'Quick Links' : 'روابط سريعة' }}</h6>
                        <nav class="d-flex flex-column">
                            <a class="footer-link" href="{{ route('home') }}">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
                            <a class="footer-link" href="{{ route('about') }}">{{ $isEn ? 'About Us' : 'من نحن' }}</a>
                            <a class="footer-link" href="{{ route('products.index') }}">{{ $isEn ? 'Products' : 'المنتجات' }}</a>
                            <a class="footer-link" href="{{ route('services.index') }}">{{ $isEn ? 'Services' : 'الخدمات' }}</a>
                            <a class="footer-link" href="{{ route('projects.index') }}">{{ $isEn ? 'Our Projects' : 'مشاريع الصيانة' }}</a>
                            <a class="footer-link" href="{{ route('contact') }}">{{ $isEn ? 'Contact' : 'تواصل معنا' }}</a>
                            <a class="footer-link" href="{{ route('quote.index') }}">{{ $isEn ? 'Request Quote' : 'طلب عرض سعر' }}</a>
                        </nav>
                    </div>

                    <!-- Categories -->
                    <div class="col-lg-3 col-6">
                        <h6 class="footer-col-title">{{ $isEn ? 'Product Categories' : 'تصنيفات المنتجات' }}</h6>
                        <nav class="d-flex flex-column">
                            <a class="footer-link" href="{{ route('products.index', ['category' => 'marine-supplies']) }}">{{ $isEn ? 'Marine Supplies' : 'التوريدات البحرية' }}</a>
                            <a class="footer-link" href="{{ route('products.index', ['category' => 'industrial-safety']) }}">{{ $isEn ? 'Industrial PPE' : 'مهمات الأمن الصناعي' }}</a>
                            <a class="footer-link" href="{{ route('products.index', ['category' => 'fire-fighting']) }}">{{ $isEn ? 'Fire Fighting' : 'معدات الإطفاء' }}</a>
                            <a class="footer-link" href="{{ route('products.index', ['category' => 'rescue-life-saving']) }}">{{ $isEn ? 'SOLAS Rescue Gear' : 'معدات الإنقاذ SOLAS' }}</a>
                            <a class="footer-link" href="{{ route('products.index', ['category' => 'respiratory-protection']) }}">{{ $isEn ? 'Respiratory SCBA' : 'أجهزة التنفس SCBA' }}</a>
                            <a class="footer-link" href="{{ route('products.index', ['category' => 'safety-signs']) }}">{{ $isEn ? 'Safety Signs' : 'العلامات واللافتات' }}</a>
                        </nav>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6">
                        <h6 class="footer-col-title">{{ $isEn ? 'Contact Info' : 'معلومات التواصل' }}</h6>
                        <div class="d-flex flex-column gap-1">
                            <div class="footer-contact-item">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>{{ $contactAddress }}</span>
                            </div>
                            <div class="footer-contact-item">
                                <i class="bi bi-telephone-fill"></i>
                                <span dir="ltr">{{ $contactPhone }}</span>
                            </div>
                            <div class="footer-contact-item">
                                <i class="bi bi-envelope-fill"></i>
                                <span>{{ $contactEmail }}</span>
                            </div>
                            @if(!empty($contactWhatsapp))
                            <div class="footer-contact-item">
                                <i class="bi bi-whatsapp"></i>
                                <span dir="ltr">{{ $contactWhatsapp }}</span>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>
                    © {{ date('Y') }} <strong style="color:rgba(255,255,255,0.6);">ALEX MARINE</strong>
                    — {{ $isEn ? 'All Rights Reserved.' : 'جميع الحقوق محفوظة.' }}
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" class="footer-bottom-link">{{ $isEn ? 'Privacy Policy' : 'سياسة الخصوصية' }}</a>
                    <span style="color:rgba(255,255,255,0.15);">|</span>
                    <span>{{ $isEn ? 'Marine Logistics & Industrial Safety' : 'حلول التوريدات والسلامة البحرية' }}</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Init Script -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Init AOS with calibrated luxury timing
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true,
            offset: 40,
            delay: 0,
        });

        // Navbar Glassmorphism on Scroll
        const navbar = document.getElementById('main-navbar');
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            if (scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            lastScroll = scrollY;
        }, { passive: true });

        // Scroll-triggered animations (for elements with .anim-* classes)
        const animEls = document.querySelectorAll('.anim-fade-up, .anim-fade-left, .anim-fade-right, .anim-scale-in');
        if (animEls.length) {
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
                });
            }, { threshold: 0.12 });
            animEls.forEach(el => io.observe(el));
        }

        // Animated CountUp for stat numbers
        function animateCount(el, target, suffix = '') {
            let start = 0;
            const duration = 2000;
            const step = (timestamp) => {
                if (!start) start = timestamp;
                const progress = Math.min((timestamp - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const val = Math.floor(eased * target);
                el.textContent = val.toLocaleString() + suffix;
                if (progress < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        }

        const countEls = document.querySelectorAll('[data-count]');
        if (countEls.length) {
            const countIO = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        const el = e.target;
                        const raw = el.dataset.count;
                        const suffix = el.dataset.suffix || '';
                        const num = parseInt(raw.replace(/\D/g, ''));
                        animateCount(el, num, suffix);
                        countIO.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });
            countEls.forEach(el => countIO.observe(el));
        }
    </script>
    <!-- Global Search Modal -->
    <div class="modal fade" id="navSearchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-navy"><i class="bi bi-search me-2 text-warning"></i>{{ $isEn ? 'Search Products & Supplies' : 'البحث في دليل المنتجات والتوريدات' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <input type="text" name="search" class="form-control rounded-start-pill ps-4" placeholder="{{ $isEn ? 'Enter product name, SKU code, or department...' : 'اكتب اسم المنتج، الكود، أو القسم...' }}" autofocus required>
                            <button class="btn btn-alex-gold rounded-end-pill px-4" type="submit">
                                <i class="bi bi-search me-1"></i>
                                <span>{{ $isEn ? 'Search' : 'بحث' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        $waHomeMsg = $isEn ? "Hello ALEX MARINE, I would like to inquire about marine supplies and services." : "مرحباً بكم في أليكس مارين، أود الاستفسار عن التوريدات والمهمات والخدمات البحرية.";
        $waHomeLink = \App\Helpers\WhatsAppHelper::link($contactWhatsapp ?: $contactPhone, $waHomeMsg);
    @endphp

    <!-- Floating WhatsApp Luxury Widget -->
    <a href="{{ $waHomeLink }}" target="_blank" class="alex-wa-widget" title="{{ $isEn ? 'Chat with us on WhatsApp' : 'تحدث معنا مباشرة عبر الواتساب' }}" aria-label="WhatsApp Chat">
        <div class="alex-wa-badge">
            <span class="wa-dot"></span>
            <span>{{ $isEn ? 'Chat with us' : 'تواصل معنا واتساب' }}</span>
        </div>
        <div class="alex-wa-btn">
            <i class="bi bi-whatsapp"></i>
        </div>
    </a>

    <!-- ════════════════════════════════════════════
         LUXURY MOBILE BOTTOM NAVIGATION BAR (< 992px)
    ════════════════════════════════════════════ -->
    <nav class="alex-mobile-bottom-nav d-lg-none" aria-label="Mobile Navigation">
        <div class="bottom-nav-inner">
            <!-- 1. Home -->
            <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="bi bi-house-door{{ request()->routeIs('home') ? '-fill' : '' }}"></i>
                </div>
                <span class="bottom-nav-label">{{ $isEn ? 'Home' : 'الرئيسية' }}</span>
            </a>

            <!-- 2. Products Catalog -->
            <a href="{{ route('products.index') }}" class="bottom-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="bi bi-grid{{ request()->routeIs('products.*') ? '-fill' : '' }}"></i>
                </div>
                <span class="bottom-nav-label">{{ $isEn ? 'Products' : 'المنتجات' }}</span>
            </a>

            <!-- 3. Quote Cart (Center Item with Badge) -->
            <a href="{{ route('quote.index') }}" class="bottom-nav-item bottom-nav-cart {{ request()->routeIs('quote.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="bi bi-basket2{{ request()->routeIs('quote.*') ? '-fill' : '' }}"></i>
                    <span class="alex-nav-cart-badge js-quote-bottom-count">{{ $quoteCount }}</span>
                </div>
                <span class="bottom-nav-label">{{ $isEn ? 'Quote' : 'التسعير' }}</span>
            </a>

            <!-- 4. Services -->
            <a href="{{ route('services.index') }}" class="bottom-nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <span class="bottom-nav-label">{{ $isEn ? 'Services' : 'الخدمات' }}</span>
            </a>

            <!-- 5. Drawer Menu Trigger -->
            <button type="button" class="bottom-nav-item bottom-nav-btn" data-bs-toggle="offcanvas" data-bs-target="#mainMobileNavbar" aria-controls="mainMobileNavbar" aria-label="Open Navigation Menu">
                <div class="bottom-nav-icon">
                    <i class="bi bi-list"></i>
                </div>
                <span class="bottom-nav-label">{{ $isEn ? 'Menu' : 'المزيد' }}</span>
            </button>
        </div>
    </nav>

    @stack('scripts')
</body>
</html>
