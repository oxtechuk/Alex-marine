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

    <!-- Dynamic Brand Colors -->
    <style>
        :root {
            --font-primary: 'Cairo', 'Tajawal', sans-serif;
            --font-en:      'Inter', sans-serif;
            --alex-navy-dark:   {{ $sitePrimaryColor }};
            --alex-navy-med:    {{ $siteSecondaryColor }};
            --alex-gold:        {{ $siteAccentColor }};
            --alex-gold-gradient: linear-gradient(135deg, #FAD961 0%, #F7B731 35%, #D49B23 70%, #B37D14 100%);
            --alex-gold-gradient-hover: linear-gradient(135deg, #FFF0B3 0%, #FCD04B 40%, #E5A315 75%, #C48712 100%);
            --alex-gold-text-gradient: linear-gradient(135deg, #FFF3C4 0%, #FAD961 25%, #E5A919 65%, #C28B15 100%);
            --alex-gold-glow:    0 4px 18px rgba(229, 169, 25, 0.38);
            --alex-blue-marine: {{ $siteMarineColor }};
        }
        body, button, input, select, textarea {
            font-family: var(--font-primary);
        }
        .font-inter body, body.font-inter,
        .font-inter button, .font-inter input {
            font-family: var(--font-en) !important;
        }
    </style>
</head>
<body class="{{ $isEn ? 'font-inter' : '' }}">

    <!-- ════════════════════════════════════════════
         MAIN NAVBAR — Freshio E-Commerce Style Header
    ════════════════════════════════════════════ -->
    <header id="main-navbar" class="navbar-alex {{ request()->routeIs('home') ? 'home-navbar-auto-hide' : '' }}">
        <div class="container">
            <nav class="navbar navbar-expand-lg py-0 w-100 align-items-center justify-content-between">

                <!-- Brand Logo -->
                <a class="navbar-brand d-flex align-items-center py-0 me-0" href="{{ route('home') }}">
                    @php
                        $headerLogoSrc = !empty($siteHeaderLogo) ? (\Illuminate\Support\Str::startsWith($siteHeaderLogo, ['http://', 'https://']) ? $siteHeaderLogo : asset($siteHeaderLogo)) : asset('uploads/Alex-marin.svg');
                    @endphp
                    <img src="{{ $headerLogoSrc }}" alt="ALEX MARINE" class="navbar-brand-img"
                         onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none'); this.nextElementSibling.classList.add('d-flex');">
                    <div class="d-none align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:40px;height:40px;background:var(--alex-navy-dark);">
                            <i class="bi bi-anchor fs-5" style="color:var(--alex-gold);"></i>
                        </div>
                        <div>
                            <div class="navbar-brand-title">ALEX MARINE</div>
                            <div class="navbar-brand-subtitle">{{ $isEn ? 'Marine Supplies' : 'للتوريدات البحرية' }}</div>
                        </div>
                    </div>
                </a>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler border-0 p-2 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Center Navigation Links -->
                <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
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

                        <!-- Products Mega Menu (Wide & Icon-Free) -->
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
                                    {{-- Mega Menu Header --}}
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

                                    {{-- Dynamic Categories Grid (Icon-Free) --}}
                                    @php
                                        $catsToDisplay = isset($navCategories) && count($navCategories) > 0
                                            ? $navCategories
                                            : \App\Models\Category::where('is_active', true)->orderBy('sort_order')->get();
                                    @endphp
                                    <div class="row g-3">
                                        @foreach($catsToDisplay as $navCat)
                                            <div class="col-md-6 col-lg-4">
                                                <a href="{{ route('products.index', ['category' => $navCat->slug]) }}" class="mega-cat-item">
                                                    <div class="mega-cat-title">
                                                        {{ $isEn ? ($navCat->name_en ?: $navCat->name_ar) : $navCat->name_ar }}
                                                    </div>
                                                    @if(!empty($navCat->description_ar) || !empty($navCat->description_en))
                                                        <div class="mega-cat-desc">
                                                            {{ Str::limit($isEn ? ($navCat->description_en ?: $navCat->description_ar) : $navCat->description_ar, 55) }}
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Mega Menu Bottom Info Bar --}}
                                    <div class="mega-bottom-bar mt-3 pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted fs-8">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">{{ $isEn ? 'Certified' : 'معتمد دولياً' }}</span>
                                            <span>{{ $isEn ? 'Compliant with SOLAS, ISO 9001 and International Maritime Standards' : 'مطابق للمواصفات الدولية البحرية وأنظمة SOLAS' }}</span>
                                        </div>
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
                            <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                {{ $isEn ? 'Contact' : 'تواصل معنا' }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Right Action Circular Buttons (Search, User, Lang, Basket) -->
                <div class="d-flex align-items-center gap-2">

                    <!-- Search Button Trigger -->
                    <button type="button" class="freshio-circle-btn freshio-btn-search" data-bs-toggle="modal" data-bs-target="#navSearchModal" title="{{ $isEn ? 'Search Products' : 'بحث في المنتجات' }}">
                        <i class="bi bi-search"></i>
                    </button>

                    <!-- User / Account Button -->
                    @auth
                        <div class="dropdown">
                            <button class="freshio-circle-btn freshio-btn-user dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" title="{{ Auth::user()->name }}">
                                <i class="bi bi-person"></i>
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
                        <a href="{{ route('login') }}" class="freshio-circle-btn freshio-btn-user" title="{{ $isEn ? 'Login' : 'تسجيل الدخول' }}">
                            <i class="bi bi-person"></i>
                        </a>
                    @endauth

                    <!-- Language Switcher Pill -->
                    <a href="{{ route('lang.switch', $isEn ? 'ar' : 'en') }}" class="freshio-circle-btn freshio-btn-lang" title="{{ $isEn ? 'Switch to Arabic' : 'Switch to English' }}">
                        <span>{{ $isEn ? 'عربي' : 'EN' }}</span>
                    </a>

                    <!-- Quote Cart / Basket (Matching Freshio Style: Clean Circle + Adjacent Total Text) -->
                    @php $quoteCount = count(session('quote_cart', [])); @endphp
                    <a href="{{ route('quote.index') }}" class="freshio-basket-group" title="{{ $isEn ? 'Quote Cart' : 'سلة طلبات التسعير' }}">
                        <div class="freshio-circle-btn freshio-btn-basket">
                            <i class="bi bi-basket2"></i>
                            <span class="freshio-badge-count">{{ $quoteCount }}</span>
                        </div>
                        <div class="freshio-basket-text d-none d-md-flex flex-column">
                            <span class="freshio-basket-subtitle">{{ $isEn ? 'Quote Cart' : 'سلة التسعير' }}</span>
                            <span class="freshio-basket-title">{{ $quoteCount > 0 ? ($isEn ? $quoteCount.' Items' : $quoteCount.' منتجات') : ($isEn ? 'Request RFQ' : 'طلب تسعير') }}</span>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
    </header>

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
                                <img src="{{ $siteFooterLogo }}" alt="ALEX MARINE" style="max-height:50px; object-fit:contain; filter:brightness(0) invert(1);">
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

                        <!-- Certifications Badge Strip -->
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            @foreach(['SOLAS','ISO','MED','EN'] as $cert)
                                <span class="badge" style="background:rgba(212,160,23,0.12); color:var(--alex-gold); border:1px solid rgba(212,160,23,0.25); border-radius:6px; font-weight:800; font-size:0.72rem; padding:4px 10px;">
                                    {{ $cert }}
                                </span>
                            @endforeach
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
        // Init AOS
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80,
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

    @stack('scripts')
</body>
</html>
