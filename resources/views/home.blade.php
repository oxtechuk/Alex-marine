@extends('layouts.app')

@php
    use App\Models\Setting;

    $isEn = app()->getLocale() == 'en';
    $locale = app()->getLocale();

    // CMS Hero Settings
    $heroMediaType      = Setting::get('hero_media_type', 'image');
    $heroBgImageRaw     = Setting::get('hero_bg_image', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80');
    $heroBgImage        = \Illuminate\Support\Str::startsWith($heroBgImageRaw, ['http://', 'https://']) ? $heroBgImageRaw : asset($heroBgImageRaw);
    $heroBgVideoRaw     = Setting::get('hero_bg_video', 'https://assets.mixkit.co/videos/preview/mixkit-cargo-container-ship-in-the-sea-41584-large.mp4');
    $heroBgVideo        = \Illuminate\Support\Str::startsWith($heroBgVideoRaw, ['http://', 'https://']) ? $heroBgVideoRaw : asset($heroBgVideoRaw);
    $heroYoutubeRaw     = Setting::get('hero_youtube_id', '5W_s42HhVLE');
    $heroYoutubeId      = '5W_s42HhVLE';
    if (!empty($heroYoutubeRaw)) {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $heroYoutubeRaw, $match)) {
            $heroYoutubeId = $match[1];
        } else {
            $heroYoutubeId = trim($heroYoutubeRaw);
        }
    }

    $heroTaglineRaw        = Setting::get('hero_tagline_'.$locale, '');
    $heroTagline           = trim($heroTaglineRaw, " .\t\n\r\0\x0B");

    $heroTitleWhiteRaw     = Setting::get('hero_title_white_'.$locale, '');
    $heroTitleWhite        = trim($heroTitleWhiteRaw, " .\t\n\r\0\x0B");

    $heroTitleHighlightRaw = Setting::get('hero_title_highlight_'.$locale, '');
    $heroTitleHighlight    = trim($heroTitleHighlightRaw, " .\t\n\r\0\x0B");

    $heroDescRaw           = Setting::get('hero_desc_'.$locale, '');
    $heroDesc              = trim($heroDescRaw, " .\t\n\r\0\x0B");

    $heroCtaText           = Setting::get('hero_cta_text_'.$locale, $isEn ? 'Explore Catalog' : 'تصفح خدماتنا ومنتجاتنا');
    $heroCtaText           = trim($heroCtaText, " .\t\n\r\0\x0B");

    // Stats
    $stat1Num   = Setting::get('hero_stat1_number', '50');
    $stat1Label = Setting::get('hero_stat1_label_'.$locale, $isEn ? 'Ports & Vessels Served' : 'موانئ وسفن مخدومة');
    $stat2Num   = Setting::get('hero_stat2_number', '2000000');
    $stat2Label = Setting::get('hero_stat2_label_'.$locale, $isEn ? 'Safety Items Deployed' : 'معدات سلامة موردة');
    $stat3Num   = Setting::get('hero_stat3_number', '99');
    $stat3Label = Setting::get('hero_stat3_label_'.$locale, $isEn ? 'On-Time Delivery Rate' : 'نسبة التوريد الفوري');

    // Section Toggles
    $secHero      = Setting::get('section_hero_active',     '1') == '1';
    $secFleet     = Setting::get('section_fleet_active',    '1') == '1';
    $secFeature   = Setting::get('section_feature_active',  '1') == '1';
    $secStats     = Setting::get('section_stats_active',    '1') == '1';
    $secGallery   = Setting::get('section_gallery_active',  '1') == '1';
    $secSpotlight = Setting::get('section_spotlight_active','1') == '1';
    $secCta       = Setting::get('section_cta_active',      '1') == '1';

    $contactWhatsapp = Setting::get('contact_whatsapp', '+201200001122');
@endphp

@section('title', $isEn ? 'ALEX MARINE — Marine & Industrial Safety Supplies' : 'أليكس مارين — التوريدات البحرية والأمن الصناعي')

@section('content')

{{-- ═══════════════════════════════════════════════
     1. HERO SECTION (MASKED / FRAMED COSMIC LOOK)
═══════════════════════════════════════════════ --}}
@if($secHero)
<div class="econ-hero-frame-wrap">
    <section class="econ-hero-container" id="hero-section">

        {{-- Background Media --}}
        <div class="econ-hero-media-wrapper">
            @if($heroMediaType === 'video' && !empty($heroBgVideo))
                <video class="econ-hero-bg-video" autoplay loop muted playsinline>
                    <source src="{{ $heroBgVideo }}" type="video/mp4">
                </video>
            @elseif($heroMediaType === 'youtube' && !empty($heroYoutubeId))
                <iframe class="econ-hero-youtube-iframe"
                        src="https://www.youtube-nocookie.com/embed/{{ $heroYoutubeId }}?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&playlist={{ $heroYoutubeId }}&playsinline=1"
                        frameborder="0"
                        allow="autoplay; encrypted-media; picture-in-picture"
                        allowfullscreen>
                </iframe>
            @else
                <div class="econ-hero-bg-img" style="background-image: url('{{ $heroBgImage }}');"></div>
            @endif
        </div>

        {{-- Overlay Gradient --}}
        <div class="econ-hero-overlay"></div>

        {{-- Top Integrated Header Bar --}}
        <div class="econ-hero-top-bar">
            {{-- Brand Logo --}}
            <a href="{{ route('home') }}" class="econ-hero-brand">
                @php
                    $hLogo = !empty($settings['site_logo_header'])
                        ? $settings['site_logo_header']
                        : Setting::get('site_logo_header', '/uploads/Alex-marin.svg');
                    if (empty($hLogo) && file_exists(public_path('uploads/Alex-marin.svg'))) {
                        $hLogo = '/uploads/Alex-marin.svg';
                    }
                @endphp
                @if(!empty($hLogo))
                    @php
                        $hLogoSrc = \Illuminate\Support\Str::startsWith($hLogo, ['http://', 'https://']) ? $hLogo : asset($hLogo);
                    @endphp
                    <img src="{{ $hLogoSrc }}" alt="ALEX MARINE" style="max-height: 50px; max-width: 220px; object-fit: contain;">
                @else
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:42px;height:42px;background:var(--alex-gold);color:#061325;">
                            <i class="bi bi-anchor fs-4"></i>
                        </div>
                        <div>
                            <div class="text-white fw-black fs-5" style="letter-spacing:0.04em;">ALEX MARINE</div>
                            <div class="text-white-50 fs-8">{{ $isEn ? 'Marine Supplies' : 'للتوريدات البحرية' }}</div>
                        </div>
                    </div>
                @endif
            </a>

            {{-- Floating Pill Menu --}}
            <div class="econ-hero-nav-pill-wrapper">
                <nav class="econ-hero-nav-pills">
                    <a href="{{ route('home') }}" class="econ-hero-nav-link active">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
                    <a href="{{ route('about') }}" class="econ-hero-nav-link">{{ $isEn ? 'About' : 'من نحن' }}</a>
                    <a href="{{ route('products.index') }}" class="econ-hero-nav-link">{{ $isEn ? 'Products' : 'المنتجات' }}</a>
                    <a href="{{ route('services.index') }}" class="econ-hero-nav-link">{{ $isEn ? 'Services' : 'خدماتنا' }}</a>
                    <a href="{{ route('contact') }}" class="econ-hero-nav-link">{{ $isEn ? 'Contact' : 'تواصل معنا' }}</a>
                </nav>

                {{-- Language Switcher & Quote Cart --}}
                <div class="d-flex align-items-center gap-2">
                    <div class="hero-lang-switch">
                        <a href="{{ route('lang.switch', 'ar') }}" class="hero-lang-btn {{ !$isEn ? 'active' : '' }}">عربي</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="hero-lang-btn {{ $isEn ? 'active' : '' }}">EN</a>
                    </div>
                    <a href="{{ route('quote.index') }}" class="hero-quote-btn" title="{{ $isEn ? 'Quote Cart' : 'سلة الطلبات' }}">
                        <i class="bi bi-file-earmark-plus"></i>
                        @if(count(session('quote_cart', [])) > 0)
                            <span class="hero-quote-badge">{{ count(session('quote_cart', [])) }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        {{-- Center / Middle Content Area --}}
        <div class="econ-hero-middle-content">
            <div class="row">
                <div class="col-lg-9 col-xl-8">
                    {{-- Tagline (Only if provided) --}}
                    @if(!empty($heroTagline))
                        <div class="hero-tagline-badge mb-3">
                            <i class="bi bi-shield-check"></i>
                            <span>{{ $heroTagline }}</span>
                        </div>
                    @endif

                    {{-- Main Headline --}}
                    @if(!empty($heroTitleWhite) || !empty($heroTitleHighlight))
                        <h1 class="econ-hero-mockup-title">
                            @if(!empty($heroTitleWhite))
                                <span class="hero-title-white-part">{{ $heroTitleWhite }}</span>
                            @endif
                            @if(!empty($heroTitleHighlight))
                                <span class="hero-title-gold-part">{{ $heroTitleHighlight }}</span>
                            @endif
                        </h1>
                    @endif

                    {{-- Description (Only if provided) --}}
                    @if(!empty($heroDesc))
                        <p class="econ-hero-mockup-desc">
                            {{ $heroDesc }}
                        </p>
                    @endif

                    {{-- Action Pill Buttons --}}
                    <div class="d-flex align-items-center gap-3 flex-wrap mt-4">
                        <a href="{{ route('quote.index') }}" class="btn-hero-pill-gold">
                            <i class="bi bi-file-earmark-plus"></i>
                            <span>{{ $isEn ? 'Request Quote' : 'اطلب عرض سعر' }}</span>
                        </a>
                        <a href="{{ route('products.index') }}" class="btn-hero-pill-glass">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                            <span>{{ !empty($heroCtaText) ? $heroCtaText : ($isEn ? 'Our Products' : 'تصفح خدماتنا ومنتجاتنا') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Bar: Floating Social Circles --}}
        <div class="econ-hero-bottom-bar">
            <div class="d-flex align-items-center gap-2">
                <a href="https://facebook.com" target="_blank" class="hero-social-circle" title="Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://x.com" target="_blank" class="hero-social-circle" title="X (Twitter)">
                    <i class="bi bi-twitter-x"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="hero-social-circle" title="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://youtube.com" target="_blank" class="hero-social-circle" title="YouTube">
                    <i class="bi bi-youtube"></i>
                </a>
                @if(!empty($contactWhatsapp))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}" target="_blank" class="hero-social-circle" title="WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>
                @endif
            </div>

            <div class="text-white-50 fs-8 d-none d-md-flex align-items-center gap-2">
                <i class="bi bi-patch-check-fill text-warning"></i>
                <span>{{ $isEn ? 'Certified SOLAS, ISO 9001 & Marine Equipment' : 'توريدات بحرية ومهمات سلامة معتمدة دولياً' }}</span>
            </div>
        </div>
    </section>
</div>
@endif


{{-- ═══════════════════════════════════════════════
     2. PRODUCTS CATALOG WITH INSTANT TABS
═══════════════════════════════════════════════ --}}
@if($secFleet)
<section class="section-py" style="background:var(--alex-light-bg);" id="categories-section">
    <div class="container">

        {{-- Section Header --}}
        <div class="section-header" data-aos="fade-up">
          
            <h2>{{ $isEn ? 'Marine & Safety Fleet Catalog' : 'أسطول التوريدات والمعدات البحرية' }}</h2>
            <div class="section-divider"></div>
            <p>{{ $isEn ? 'Explore our range of certified vessel supplies and safety gear for ports, ships and industries.' : 'استكشف قائمة المنتجات الجاهزة للتوريد الفوري للموانئ والشركات والسفن.' }}</p>
        </div>

        {{-- Category Pill Filter (Text Only - No Icons) --}}
        <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center mb-4" data-aos="fade-up" id="fleet-category-pills">
            <a href="{{ route('home', ['category' => 'all']) }}#categories-section"
               data-url="{{ route('home', ['category' => 'all']) }}"
               data-category="all"
               class="cat-pill {{ ($selectedCategorySlug ?? 'all') == 'all' ? 'active' : '' }}">
                {{ $isEn ? 'All Equipment' : 'جميع المعدات' }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('home', ['category' => $cat->slug]) }}#categories-section"
                   data-url="{{ route('home', ['category' => $cat->slug]) }}"
                   data-category="{{ $cat->slug }}"
                   class="cat-pill {{ ($selectedCategorySlug ?? '') == $cat->slug ? 'active' : '' }}">
                    {{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}
                </a>
            @endforeach
        </div>

        {{-- Products Grid Wrapper --}}
        <div id="fleet-grid-wrapper" style="min-height: 280px; transition: opacity 0.2s ease, transform 0.2s ease;">
            @include('partials.fleet-products-grid')
        </div>

        {{-- View All CTA --}}
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn-alex-outline px-4 py-2.5">
                {{ $isEn ? 'View Full Product Catalog' : 'عرض جميع المنتجات' }}
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════
     3. ABOUT US & DEPARTMENTS (FIXED & POLISHED)
═══════════════════════════════════════════════ --}}
@if($secFeature)
<section class="section-py position-relative overflow-hidden" style="background:#F8FAFC;" id="about-departments-section">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">

            {{-- Right Content (in RTL): Rich About Us, Vision, Pillars & Animated Arrow --}}
            <div class="col-lg-5" data-aos="fade-right">
                @php
                    $aboutTagline = !empty($settings['about_tagline_'.$locale]) ? trim($settings['about_tagline_'.$locale], " .\t\n\r\0\x0B") : ($isEn ? 'About Alex Marine' : 'من نحن ورؤيتنا');
                    $aboutTitle   = !empty($settings['about_title_'.$locale]) ? trim($settings['about_title_'.$locale], " .\t\n\r\0\x0B") : ($isEn ? 'Alex Marine for Marine Supplies & Industrial Safety' : 'شركة أليكس مارين للتوريدات البحرية والأمن الصناعي');
                    $aboutDesc    = !empty($settings['about_desc_'.$locale]) ? trim($settings['about_desc_'.$locale], " .\t\n\r\0\x0B") : ($isEn ? 'We provide certified marine equipment, offshore supplies, SOLAS life-saving gear, and specialized maintenance for shipping lines and industrial facilities across all ports.' : 'شريكك المعتمد لحلول التوريدات البحرية المتكاملة، مهمات الأمن الصناعي، وصيانة معدات السلامة ومحطات الإطفاء للسفن والموانئ والشركات الملاحية بأعلى معايير الجودة العالمية.');
                    $aboutLogo    = !empty($settings['about_section_image']) ? $settings['about_section_image'] : (!empty($settings['site_logo_header']) ? $settings['site_logo_header'] : 'uploads/Alex-marin.svg');
                @endphp

                <!-- Top Badge & Company Brand Logo -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div class="section-tag section-tag-gold m-0">
                        <i class="bi bi-shield-check text-warning"></i>
                        {{ $aboutTagline }}
                    </div>
                    @if($aboutLogo)
                        <img src="{{ \Illuminate\Support\Str::startsWith($aboutLogo, ['http://', 'https://']) ? $aboutLogo : asset($aboutLogo) }}"
                             alt="ALEX MARINE"
                             class="img-fluid"
                             style="max-height: 38px; width: auto; object-fit: contain;"
                             onerror="this.style.display='none'">
                    @endif
                </div>

                <!-- Main Heading -->
                <h2 class="display-section text-navy fw-extrabold mb-3" style="line-height: 1.35; letter-spacing: -0.5px;">
                    {{ $aboutTitle }}
                </h2>

                <!-- Core Description & Vision -->
                <p class="text-secondary leading-relaxed mb-4" style="font-size: 0.95rem; line-height: 1.75;">
                    {{ $aboutDesc }}
                </p>

                <!-- 3 Key Value Pillars (Clean & Well-Spaced) -->
                <div class="d-flex flex-column gap-3 mb-4">
                    
                    <!-- Item 1 -->
                    <div class="d-flex align-items-start gap-3 p-3 rounded-4 bg-white border border-light-subtle shadow-sm transition-all hover-translate">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 44px; height: 44px; background: #0A1D37; color: #E5A919;">
                            <i class="bi bi-anchor fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1 fs-6">{{ $isEn ? 'Certified Marine Supplies & Deck Gear' : 'توريدات بحرية ومعدات سطح معتمدة' }}</h6>
                            <p class="text-muted m-0 fs-8 leading-relaxed">{{ $isEn ? 'Mooring ropes, anchors, navigational & deck tools ready for prompt port delivery.' : 'حبال رسو، مراسي، ومستلزمات ملاحية جاهزة للتسليم الفوري بالأرصفة والموانئ.' }}</p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="d-flex align-items-start gap-3 p-3 rounded-4 bg-white border border-light-subtle shadow-sm transition-all hover-translate">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 44px; height: 44px; background: #1E6FAE; color: #ffffff;">
                            <i class="bi bi-shield-shaded fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1 fs-6">{{ $isEn ? 'Industrial Safety & SOLAS PPE' : 'مهمات الأمن الصناعي والسلامة SOLAS & ISO' }}</h6>
                            <p class="text-muted m-0 fs-8 leading-relaxed">{{ $isEn ? 'Certified life jackets, SCBA breathing apparatus, and personal protective equipment.' : 'سترات وطوافات نجاة، أجهزة تنفس SCBA، ومعدات وقاية شخصية معتمدة دولياً.' }}</p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="d-flex align-items-start gap-3 p-3 rounded-4 bg-white border border-light-subtle shadow-sm transition-all hover-translate">
                        <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 44px; height: 44px; background: linear-gradient(135deg, #FAD961, #E5A919); color: #0A1D37;">
                            <i class="bi bi-tools fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1 fs-6">{{ $isEn ? 'Certified Inspection & Maintenance' : 'صيانة وتفتيش فني معتمد لمحطات الإطفاء' }}</h6>
                            <p class="text-muted m-0 fs-8 leading-relaxed">{{ $isEn ? 'Hydrostatic testing & annual recertification for CO2 systems and life-saving craft.' : 'إعادة تأهيل واختبارات هيدروستاتيكية معتمدة لمنظومات الإطفاء والإنقاذ.' }}</p>
                        </div>
                    </div>

                </div>

                <!-- Action Buttons & Animated Directional Link -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-1">
                    <div class="d-flex gap-2.5 flex-wrap">
                        <a href="{{ route('about') }}" class="btn-alex-primary px-4 py-2.5 rounded-pill shadow-sm text-decoration-none fw-bold fs-7">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ $isEn ? 'More About Us' : 'تعرف علينا أكثر' }}
                        </a>
                        <a href="{{ route('quote.index') }}" class="btn-alex-gold px-4 py-2.5 rounded-pill shadow-sm text-decoration-none fw-bold fs-7">
                            <i class="bi bi-file-earmark-plus me-1"></i>
                            {{ $isEn ? 'Request Quote' : 'اطلب عرض سعر' }}
                        </a>
                    </div>

                    <!-- Animated Arrow pointing to Left -->
                    <a href="{{ route('products.index') }}" class="explore-arrow-link d-inline-flex align-items-center gap-2 text-decoration-none py-1">
                        <span class="fw-bold text-dark fs-8">{{ $isEn ? 'Explore Departments' : 'استكشف أقسامنا' }}</span>
                        <svg class="animated-arrow-icon" width="28" height="20" viewBox="0 0 28 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            @if($isEn)
                                <path d="M2 10H24M24 10L16 3M24 10L16 17" stroke="#E5A919" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            @else
                                <path d="M26 10H4M4 10L12 3M4 10L12 17" stroke="#E5A919" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            @endif
                        </svg>
                    </a>
                </div>

            </div>

            {{-- Left: Clean & High-Clarity Category Cards --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="d-flex align-items-center justify-content-between mb-3.5 pb-2 border-bottom">
                    <h5 class="fw-extrabold m-0 text-navy fs-6 d-flex align-items-center gap-2">
                        <i class="bi bi-grid-3x3-gap-fill text-warning"></i>
                        <span>{{ $isEn ? 'Our Product & Supply Departments' : 'أقسام التوريدات والمنتجات الرئيسية' }}</span>
                    </h5>
                    <a href="{{ route('products.index') }}" class="text-navy fs-8 fw-bold text-decoration-none hover-gold d-flex align-items-center gap-1">
                        <span>{{ $isEn ? 'View Full Catalog' : 'عرض الكتالوج بالكامل' }}</span>
                        <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                    </a>
                </div>

                <div class="row g-3">
                    @php
                    $deptFallbacks = [
                        'marine-supplies' => ['bi-anchor', 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=800&q=80', $isEn ? 'Mooring ropes, anchors, deck gear & nautical tools.' : 'حبال الرسو، المراسي، معدات السطح، والمستلزمات البحرية.'],
                        'industrial-safety' => ['bi-shield-check', 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80', $isEn ? 'Certified helmets, safety shoes, high-vis PPE & protective wear.' : 'خوذ الحماية، أحذية السلامة، والسترات ومهمات الوقاية الشخصية.'],
                        'fire-fighting' => ['bi-fire', 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80', $isEn ? 'Extinguishers, foam systems, cabinets, and certified inspection.' : 'طفايات الحريق، أنظمة الرغوة، الخراطيم، وخدمات الفحص المعتمدة.'],
                        'rescue-life-saving' => ['bi-life-preserver', 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80', $isEn ? 'SOLAS life jackets, lifebuoys, immersion suits, and beacons.' : 'سترات النجاة SOLAS، أطواق الإنقاذ، وبدلات الغمر وأجهزة الاستغاثة.'],
                        'respiratory-protection' => ['bi-mask', 'https://images.unsplash.com/photo-1584634731339-252c581abfc5?auto=format&fit=crop&w=800&q=80', $isEn ? 'SCBA breathing apparatus, escape hoods, and air cylinders.' : 'أجهزة التنفس الذاتي SCBA، أقنعة الهروب، واسطوانات الهواء.'],
                        'safety-signs' => ['bi-signpost-split', 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80', $isEn ? 'IMO safety signs, photoluminescent exit markers, and warnings.' : 'لوحات السلامة البحرية IMO، العلامات الفوسفورية، واللوحات الإرشادية.'],
                    ];
                    $displayCats = isset($featureCategories) && $featureCategories->count() > 0 ? $featureCategories : $categories->take(4);
                    @endphp

                    @foreach($displayCats as $idx => $cat)
                        @php
                            $fallback = $deptFallbacks[$cat->slug] ?? ['bi-box-seam', 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=800&q=80', $isEn ? 'Certified equipment and supplies.' : 'معدات وتوريدات معتمدة ومطابقة للمواصفات.'];
                            $icon = $cat->icon ?: $fallback[0];
                            $coverImg = $cat->image ?: $fallback[1];
                            $desc = $cat->description_ar ?: $fallback[2];
                            if ($isEn && !empty($cat->description_en)) {
                                $desc = $cat->description_en;
                            }
                        @endphp
                        <div class="col-sm-6" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                               class="category-cover-card-clean rounded-4 overflow-hidden position-relative d-block text-decoration-none shadow-sm"
                               title="{{ $isEn ? 'View ' . ($cat->name_en ?: $cat->name_ar) . ' Products' : 'عرض منتجات ' . $cat->name_ar }}">
                                
                                {{-- Background Cover Image (Clear & High Contrast) --}}
                                <img src="{{ \Illuminate\Support\Str::startsWith($coverImg, ['http://', 'https://']) ? $coverImg : asset($coverImg) }}"
                                     alt="{{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}"
                                     class="category-cover-bg-clean w-100 h-100 object-fit-cover"
                                     loading="lazy">
                                
                                {{-- Subtle Bottom Gradient for Maximum Photo Clarity --}}
                                <div class="category-cover-overlay-clean position-absolute inset-0"></div>

                                {{-- Content: Clean bottom title and icon --}}
                                <div class="category-cover-content-clean position-absolute bottom-0 inset-x-0 p-3 z-2 d-flex flex-column justify-content-end">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="category-cover-mini-icon d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 32px; height: 32px; background: #E5A919; color: #0A1D37;">
                                            <i class="bi {{ $icon }} fs-6"></i>
                                        </div>
                                        <h5 class="category-cover-title-clean fw-bold text-white m-0 fs-6" style="text-shadow: 0 2px 4px rgba(0,0,0,0.85);">
                                            {{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}
                                        </h5>
                                    </div>
                                    
                                    {{-- Smooth Slide-Up Details on Hover --}}
                                    <div class="category-cover-hover-details">
                                        <p class="text-white text-opacity-90 fs-8 m-0 mt-1 mb-1 line-clamp-2" style="line-height: 1.4; text-shadow: 0 1px 2px rgba(0,0,0,0.8);">{{ $desc }}</p>
                                        <span class="text-warning fs-8 fw-bold d-inline-flex align-items-center gap-1">
                                            <span>{{ $isEn ? 'Explore Catalog' : 'استكشف المنتجات' }}</span>
                                            <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif




{{-- ═══════════════════════════════════════════════
     5. MAINTENANCE PROJECTS & CASE STUDIES SHOWCASE
═══════════════════════════════════════════════ --}}
@if($secGallery)
<section class="section-py" style="background: linear-gradient(180deg, #0A1D37 0%, #060E1A 100%); color: #F0F4F8;" id="gallery-section">
    <div class="container">
        
        <!-- Section Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5" data-aos="fade-up">
            <div>
               
                <h2 class="display-section text-white mt-1 mb-2 fw-extrabold" style="letter-spacing: -0.5px;">
                    {{ $isEn ? 'Marine Maintenance & Inspection Cases' : 'مشاريع وحالات الصيانة البحرية المعتمدة' }}
                </h2>
                <p class="text-white-50 m-0 fs-6" style="max-width: 620px;">
                    {{ $isEn ? 'Technical inspections, life raft servicing, CO2 suppression overhauls, and SOLAS certifications executed by our marine engineers.' : 'توثيق لمشاريع الصيانة والتفتيش البحري وإعادة تأهيل معدات السلامة ومحطات الإطفاء لسفن وموانئ كبرى.' }}
                </p>
            </div>
            
            <a href="{{ route('projects.index') }}" class="btn btn-case-gold rounded-pill px-4 py-2.5 fw-bold mt-3 mt-md-0 shadow-lg text-decoration-none d-flex align-items-center gap-2 align-self-start align-self-md-auto">
                <span>{{ $isEn ? 'View All Projects' : 'استعراض كافة المشاريع' }}</span>
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
            </a>
        </div>

        <!-- Maintenance Cases Cards Grid -->
        <div class="row g-4">
            @forelse($maintenanceProjects as $i => $proj)
                @php
                    $projTitle = $proj->title;
                    $hasBA = !empty($proj->before_image) && !empty($proj->after_image);
                @endphp
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="card h-100 border border-secondary border-opacity-25 rounded-4 overflow-hidden shadow-2xl project-card-hover" style="background: #101926;">
                        
                        <!-- Media Cover Box -->
                        <div class="position-relative overflow-hidden" style="height: 240px;">
                            <img src="{{ $proj->main_image_url }}" alt="{{ $projTitle }}" class="w-100 h-100 object-fit-cover transition-transform" loading="lazy">
                            <div class="position-absolute inset-0" style="background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(6,14,26,0.9) 100%);"></div>

                            @if($proj->service)
                                <span class="position-absolute top-0 start-0 m-3 badge bg-black bg-opacity-75 text-warning border border-warning border-opacity-40 px-2.5 py-1.5 rounded-pill fs-8">
                                    <i class="bi {{ $proj->service->icon ?? 'bi-gear' }} me-1"></i> {{ $proj->service->name }}
                                </span>
                            @endif

                            @if($hasBA)
                                <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark px-2.5 py-1 rounded-pill fs-9 fw-bold shadow-sm">
                                    <i class="bi bi-sliders me-1"></i> Before / After
                                </span>
                            @endif

                            @if($proj->video_url)
                                <span class="position-absolute bottom-0 end-0 m-3 badge bg-danger text-white px-2 py-1 rounded-pill fs-9 shadow-sm">
                                    <i class="bi bi-play-fill me-1"></i> Video
                                </span>
                            @endif
                        </div>

                        <!-- Content Body -->
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <!-- Location & Vessel Subtitle -->
                                <div class="d-flex align-items-center justify-content-between text-white-50 fs-8 mb-2 pb-2 border-bottom border-secondary border-opacity-25">
                                    @if($proj->location)
                                        <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> {{ $proj->location }}</span>
                                    @endif
                                    @if($proj->duration)
                                        <span><i class="bi bi-stopwatch text-warning me-1"></i> {{ $proj->duration }}</span>
                                    @endif
                                </div>

                                <!-- Project Title -->
                                <h5 class="fw-bold text-white mb-2 leading-snug">
                                    <a href="{{ route('projects.show', $proj->slug) }}" class="text-white text-decoration-none hover-gold transition-colors">
                                        {{ $projTitle }}
                                    </a>
                                </h5>

                                <!-- Short Description -->
                                <p class="text-white-50 fs-7 line-clamp-2 mb-0" style="line-height: 1.6;">
                                    {{ $proj->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($proj->description), 110) }}
                                </p>
                            </div>

                            <!-- Card Footer Button -->
                            <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                                <a href="{{ route('projects.show', $proj->slug) }}" class="btn btn-outline-warning btn-sm rounded-pill px-3.5 py-1.5 fw-bold fs-7 d-flex align-items-center gap-1.5 hover-glow">
                                    <span>{{ $isEn ? 'View Case Details' : 'عرض دراسة الحالة' }}</span>
                                    <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                                </a>

                                @if($proj->vessel_type)
                                    <span class="text-white-50 fs-8"><i class="bi bi-shield-check text-warning me-1"></i> {{ \Illuminate\Support\Str::limit($proj->vessel_type, 18) }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 py-4 text-center text-white-50">
                    <p>{{ $isEn ? 'No maintenance cases published yet.' : 'جاري إضافة وتوثيق مشاريع الصيانة قريباً.' }}</p>
                </div>
            @endforelse
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════
     6. FEATURED SPOTLIGHT PRODUCTS
═══════════════════════════════════════════════ --}}
@if($secSpotlight)
<section class="section-py" style="background:#ffffff;" id="featured-section">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4" data-aos="fade-up">
            <div>
                <div class="section-tag section-tag-gold">
                    <i class="bi bi-star-fill"></i>
                    {{ $isEn ? 'Featured Products' : 'منتجات مختارة' }}
                </div>
                <h2 class="display-section mt-1 mb-0">
                    {{ $isEn ? 'Top-Rated Marine & Safety Products' : 'أبرز المنتجات المعتمدة للتوريد' }}
                </h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn-alex-outline mt-3 mt-md-0 align-self-start">
                {{ $isEn ? 'View All Catalog' : 'عرض الكتالوج بالكامل' }}
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $i => $prod)
            <div class="col-lg-3 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 80 }}">
                <div class="product-card">
                    <div class="product-card-img-wrap">
                        <span class="product-badge-category">{{ $isEn ? ($prod->category->name_en ?: $prod->category->name_ar) : $prod->category->name_ar }}</span>
                        <img src="{{ $prod->image ?: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=500&q=80' }}"
                             alt="{{ $prod->name_ar }}"
                             loading="lazy">
                    </div>
                    <div class="product-card-body">
                        <a href="{{ route('products.show', ['category_slug' => $prod->category->slug, 'product_slug' => $prod->slug]) }}"
                           class="product-card-title">
                            {{ $isEn ? ($prod->name_en ?: $prod->name_ar) : $prod->name_ar }}
                        </a>
                        <div class="product-card-sku">SKU: {{ $prod->sku }}</div>
                        <div class="product-card-footer">
                            <span class="product-availability-badge">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ $prod->availability_status }}
                            </span>
                            <a href="{{ route('products.show', ['category_slug' => $prod->category->slug, 'product_slug' => $prod->slug]) }}"
                               class="btn-alex-primary py-1 px-2.5" style="font-size:0.8rem;">
                                {{ $isEn ? 'Details' : 'تفاصيل' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif




{{-- ═══════════════════════════════════════════════
     8. CTA BANNER (SOLID NAVY — LETS TALK)
═══════════════════════════════════════════════ --}}
@if($secCta)
<section class="cta-section" id="cta-section">
    <div class="container text-center" data-aos="fade-up">
        <div class="section-tag section-tag-dark mb-3">
            <i class="bi bi-chat-dots-fill"></i>
            LETS TALK
        </div>
        <h2 class="cta-title">
            {{ $isEn ? 'Ready to Equip Your Vessel or Facility?' : 'جاهز لتجهيز سفينتك أو منشأتك الصناعية؟' }}
        </h2>
        <p class="cta-desc mx-auto mb-4">
            {{ $isEn
                ? 'Need certified marine supplies or emergency safety gear for your fleet? Reach out to our technical team now for an instant quote.'
                : 'هل تحتاج توريدات بحرية معتمدة أو مهمات سلامة عاجلة لشركتك؟ تواصل مع فريقنا الفني فوراً للحصول على عرض سعر سريع.' }}
        </p>
        <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}?text={{ urlencode($isEn ? 'Hello Alex Marine, I need a quote.' : 'مرحباً أليكس مارين، أود طلب عرض سعر') }}"
               target="_blank"
               class="btn-alex-gold px-4 py-2.5"
               id="cta-whatsapp">
                <i class="bi bi-whatsapp fs-5"></i>
                {{ $isEn ? 'Chat via WhatsApp' : 'تحدث عبر الواتساب' }}
            </a>
            <a href="{{ route('quote.index') }}"
               class="btn-alex-outline-white px-4 py-2.5"
               id="cta-quote">
                <i class="bi bi-file-earmark-plus fs-5"></i>
                {{ $isEn ? 'Request Instant Quote' : 'اطلب عرض سعر سريع' }}
            </a>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pills = document.querySelectorAll('#fleet-category-pills .cat-pill');
    const gridWrapper = document.getElementById('fleet-grid-wrapper');

    pills.forEach(pill => {
        pill.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url') || this.getAttribute('href');

            // Set active class
            pills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');

            if (!gridWrapper) return;

            // Subtle opacity change
            gridWrapper.style.opacity = '0.4';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.text();
            })
            .then(html => {
                gridWrapper.innerHTML = html;
                gridWrapper.style.opacity = '1';

                // Update URL in browser history without reload or page jumping
                window.history.pushState(null, '', url);

                if (typeof AOS !== 'undefined') {
                    AOS.refreshHard();
                }
            })
            .catch(err => {
                console.error('Failed to load category products:', err);
                gridWrapper.style.opacity = '1';
            });
        });
    });

    // Update carousel dot active styles on slide change
    document.addEventListener('slid.bs.carousel', function(e) {
        if (e.target.id === 'fleetProductsCarousel') {
            const dots = e.target.querySelectorAll('[data-bs-slide-to]');
            dots.forEach((dot, idx) => {
                if (idx === e.to) {
                    dot.className = 'btn p-0 rounded-circle border-0 bg-dark';
                } else {
                    dot.className = 'btn p-0 rounded-circle border-0 bg-secondary opacity-50';
                }
            });
        }
    });
});
</script>
<style>
.btn-case-gold {
    background: linear-gradient(135deg, #FAD961 0%, #F7B731 35%, #D49B23 70%, #B37D14 100%);
    color: #061325 !important;
    border: none;
    transition: all 0.3s ease;
}
.btn-case-gold:hover {
    background: linear-gradient(135deg, #FFF0B3 0%, #FCD04B 40%, #E5A315 75%, #C48712 100%);
    color: #000000 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(229, 169, 25, 0.4) !important;
}
.project-card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}
.project-card-hover:hover {
    transform: translateY(-6px);
    border-color: rgba(229, 169, 25, 0.5) !important;
    box-shadow: 0 16px 36px rgba(0,0,0,0.6) !important;
}
.project-card-hover:hover .transition-transform {
    transform: scale(1.06);
}
.hover-gold:hover {
    color: #E5A919 !important;
}
.hover-glow:hover {
    box-shadow: 0 0 14px rgba(229, 169, 25, 0.5);
    background-color: #E5A919;
    color: #0A1D37 !important;
}
.transition-transform {
    transition: transform 0.4s ease;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Redesigned Clean Category Cards with High Photo Clarity */
.category-cover-card-clean {
    height: 240px;
    background-color: #0A1D37;
    border: 1px solid rgba(10, 29, 55, 0.12);
    transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
}
.category-cover-bg-clean {
    transition: transform 0.5s ease, filter 0.4s ease;
}
/* Subtle low-opacity gradient so photos are crisp and vibrant */
.category-cover-overlay-clean {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0) 35%, rgba(6, 19, 37, 0.45) 65%, rgba(6, 19, 37, 0.9) 100%);
    transition: background 0.35s ease;
}
.category-cover-hover-details {
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, opacity 0.35s ease, margin-top 0.35s ease;
    margin-top: 0;
}
.category-cover-card-clean:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 30px rgba(10, 29, 55, 0.28) !important;
    border-color: var(--alex-gold) !important;
}
.category-cover-card-clean:hover .category-cover-bg-clean {
    transform: scale(1.08);
}
.category-cover-card-clean:hover .category-cover-overlay-clean {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.05) 15%, rgba(6, 19, 37, 0.6) 55%, rgba(6, 19, 37, 0.95) 100%);
}
.category-cover-card-clean:hover .category-cover-hover-details {
    max-height: 80px;
    opacity: 1;
    margin-top: 0.35rem;
}

.hover-translate {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.hover-translate:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(10, 29, 55, 0.08) !important;
}

/* Animated Directional SVG Arrow */
.explore-arrow-link:hover .animated-arrow-icon {
    transform: translateX(-5px);
}
[dir="ltr"] .explore-arrow-link:hover .animated-arrow-icon {
    transform: translateX(5px);
}
.animated-arrow-icon {
    animation: arrowPulse 1.4s infinite ease-in-out;
    transition: transform 0.2s ease;
}
@keyframes arrowPulse {
    0%, 100% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(-6px);
    }
}
[dir="ltr"] .animated-arrow-icon {
    animation: arrowPulseLtr 1.4s infinite ease-in-out;
}
@keyframes arrowPulseLtr {
    0%, 100% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(6px);
    }
}
</style>
@endpush
