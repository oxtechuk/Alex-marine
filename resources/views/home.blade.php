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
        <div class="econ-hero-top-bar hero-anim-nav">
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

            {{-- Floating Pill Menu (Desktop only, hidden on mobile) --}}
            <div class="econ-hero-nav-pill-wrapper d-none d-lg-flex">
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

            {{-- Mobile Quick Actions on Hero (visible < 992px) --}}
            <div class="d-flex align-items-center gap-2 d-lg-none">
                <a href="{{ route('quote.index') }}" class="hero-quote-btn" title="{{ $isEn ? 'Quote Cart' : 'سلة الطلبات' }}">
                    <i class="bi bi-basket2-fill"></i>
                    @if(count(session('quote_cart', [])) > 0)
                        <span class="hero-quote-badge">{{ count(session('quote_cart', [])) }}</span>
                    @endif
                </a>
                <button class="btn btn-outline-light rounded-pill px-3 py-1 fs-8 fw-bold" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainMobileNavbar">
                    <i class="bi bi-list me-1"></i> {{ $isEn ? 'Menu' : 'القائمة' }}
                </button>
            </div>
        </div>

        {{-- Center / Middle Content Area --}}
        <div class="econ-hero-middle-content">
            <div class="row">
                <div class="col-lg-9 col-xl-8">
                    {{-- Tagline (Only if provided) --}}
                    @if(!empty($heroTagline))
                        <div class="hero-tagline-badge mb-3 hero-anim-tagline">
                            <i class="bi bi-shield-check"></i>
                            <span>{{ $heroTagline }}</span>
                        </div>
                    @endif

                    {{-- Main Headline --}}
                    @if(!empty($heroTitleWhite) || !empty($heroTitleHighlight))
                        <h1 class="econ-hero-mockup-title hero-anim-title">
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
                        <p class="econ-hero-mockup-desc hero-anim-desc">
                            {{ $heroDesc }}
                        </p>
                    @endif

                    {{-- Action Pill Buttons --}}
                    <div class="d-flex align-items-center gap-3 flex-wrap mt-4 hero-anim-actions">
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
        <div class="econ-hero-bottom-bar hero-anim-footer">
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

        {{-- Category Pill Filter (Horizontal Scroller on Mobile, Centered on Desktop) --}}
        <div class="category-pills-wrap mb-3 mb-md-4" data-aos="fade-up">
            <div class="category-pills-scroller fleet-pills-scroller justify-content-lg-center" id="fleet-category-pills">
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

            {{-- Right Content (in RTL): Rich About Us, Vision, Pillars & Interactive Arrow --}}
            <div class="col-lg-5" data-aos="fade-up">
                @php
                    $aboutTagline = !empty($settings['about_tagline_'.$locale]) ? trim($settings['about_tagline_'.$locale], " .\t\n\r\0\x0B") : ($isEn ? 'About Alex Marine' : 'من نحن ورؤيتنا');
                    $aboutTitle   = !empty($settings['about_title_'.$locale]) ? trim($settings['about_title_'.$locale], " .\t\n\r\0\x0B") : ($isEn ? 'Alex Marine for Marine Supplies & Industrial Safety' : 'شركة أليكس مارين للتوريدات البحرية والأمن الصناعي');
                    $aboutDesc    = !empty($settings['about_desc_'.$locale]) ? trim($settings['about_desc_'.$locale], " .\t\n\r\0\x0B") : ($isEn ? 'We provide certified marine equipment, offshore supplies, SOLAS life-saving gear, and specialized maintenance for shipping lines and industrial facilities across all ports.' : 'شريكك المعتمد لحلول التوريدات البحرية المتكاملة، مهمات الأمن الصناعي، وصيانة معدات السلامة ومحطات الإطفاء للسفن والموانئ والشركات الملاحية بأعلى معايير الجودة العالمية.');
                    $aboutLogo    = !empty($settings['about_section_image']) ? $settings['about_section_image'] : (!empty($settings['site_logo_header']) ? $settings['site_logo_header'] : 'uploads/Alex-marin.svg');
                @endphp

                <!-- Top Badge & Company Brand Logo -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                  
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
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
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
                        <div class="col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($idx % 2) * 60 }}">
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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 mb-lg-5" data-aos="fade-up">
            <div>
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-extrabold tracking-widest text-uppercase fs-8 shadow-sm mb-2 d-inline-flex align-items-center gap-1">
                    <i class="bi bi-sliders"></i> {{ $isEn ? 'INTERACTIVE BEFORE & AFTER' : 'مقارنة تفاعلية قبل وبعد الصيانة' }}
                </span>
                <h2 class="display-section text-white mt-1 mb-2 fw-extrabold" style="letter-spacing: -0.5px;">
                    {{ $isEn ? 'Marine Maintenance & Inspection Cases' : 'مشاريع وحالات الصيانة البحرية المعتمدة' }}
                </h2>
                <p class="text-white-50 m-0 fs-6" style="max-width: 650px;">
                    {{ $isEn ? 'Inspect verified technical overhauls and SOLAS certifications executed by our marine engineers.' : 'اختر أي مشروع من القائمة الجانبية لمعاينة حالة المعدات التفاعلية قبل وبعد الصيانة والتأهيل.' }}
                </p>
            </div>
            
            <a href="{{ route('projects.index') }}" class="btn btn-case-gold rounded-pill px-4 py-2.5 fw-bold mt-3 mt-md-0 shadow-lg text-decoration-none d-flex align-items-center gap-2 align-self-start align-self-md-auto">
                <span>{{ $isEn ? 'View All Projects' : 'استعراض كافة المشاريع' }}</span>
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
            </a>
        </div>

        @php
            $firstProj = $maintenanceProjects->first();
        @endphp

        @if($maintenanceProjects->isNotEmpty())
        <!-- Interactive Split Section: Sidebar (Projects List) + Interactive Before/After Showcase -->
        <div class="row g-4 align-items-stretch" id="homeMaintenanceShowcase" data-aos="fade-up">
            
            <!-- SIDEBAR: List of Projects -->
            <div class="col-lg-4 col-xl-4 order-2 order-lg-1">
                <div class="showcase-sidebar rounded-4 p-3 border border-secondary border-opacity-25 h-100 d-flex flex-column justify-content-between" style="background: rgba(16, 25, 38, 0.9); backdrop-filter: blur(14px); box-shadow: 0 16px 36px rgba(0,0,0,0.5);">
                    
                    <div>
                        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom border-secondary border-opacity-20 px-2">
                            <span class="text-white fw-bold fs-7 d-flex align-items-center gap-2">
                                <i class="bi bi-collection-play-fill text-warning"></i>
                                {{ $isEn ? 'Select Project Case' : 'قائمة مشروعات الصيانة' }}
                            </span>
                            <span class="badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-30 rounded-pill px-2.5 py-1 fs-8 fw-bold">
                                {{ count($maintenanceProjects) }} {{ $isEn ? 'Projects' : 'مشروعات' }}
                            </span>
                        </div>

                        <!-- Sidebar Projects List -->
                        <div class="showcase-project-list d-flex flex-column gap-2.5">
                            @foreach($maintenanceProjects as $idx => $p)
                                @php
                                    $isFirst = $idx === 0;
                                @endphp
                                <div class="showcase-project-item rounded-3 p-3 transition-all {{ $isFirst ? 'active' : '' }}"
                                     data-project-id="{{ $p->id }}"
                                     data-title="{{ $p->title }}"
                                     data-url="{{ route('projects.show', $p->slug) }}"
                                     data-before="{{ $p->before_image_url }}"
                                     data-after="{{ $p->after_image_url }}"
                                     data-service="{{ $p->service ? $p->service->name : ($isEn ? 'Marine Maintenance' : 'صيانة بحرية') }}"
                                     data-service-icon="{{ $p->service?->icon ?? 'bi-gear' }}"
                                     data-location="{{ $p->location ?? '' }}"
                                     data-duration="{{ $p->duration ?? '' }}"
                                     data-vessel="{{ $p->vessel_type ?? '' }}"
                                     data-desc="{{ $p->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($p->description), 110) }}">
                                    
                                    <div class="d-flex align-items-start gap-3">
                                        <!-- Mini Thumb -->
                                        <div class="showcase-thumb-box rounded-2 overflow-hidden flex-shrink-0 position-relative" style="width: 60px; height: 60px; background: #0A1D37;">
                                            <img src="{{ $p->main_image_url }}" alt="{{ $p->title }}" class="w-100 h-100 object-fit-cover">
                                            <span class="position-absolute bottom-0 inset-x-0 bg-warning text-dark text-center fw-bold" style="font-size: 8px; line-height: 13px;">B / A</span>
                                        </div>

                                        <div class="flex-grow-1 min-w-0">
                                            <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                                <span class="badge bg-secondary bg-opacity-25 text-white-50 fs-9 rounded-pill px-2 py-0.5 text-truncate" style="max-width: 140px;">
                                                    <i class="bi {{ $p->service?->icon ?? 'bi-gear' }} me-1 text-warning"></i>
                                                    {{ $p->service ? $p->service->name : ($isEn ? 'Marine Maintenance' : 'صيانة بحرية') }}
                                                </span>
                                                <i class="bi bi-chevron-left showcase-item-arrow fs-8 text-white-50"></i>
                                            </div>

                                            <!-- Clickable Project Title that goes to project show page -->
                                            <h6 class="showcase-item-title fw-bold mb-1 text-truncate">
                                                <a href="{{ route('projects.show', $p->slug) }}" class="text-white text-decoration-none hover-gold transition-colors" title="{{ $isEn ? 'Open project details' : 'فتح تفاصيل المشروع' }}">
                                                    {{ $p->title }}
                                                </a>
                                            </h6>

                                            <div class="d-flex align-items-center gap-2 text-white-50 fs-9">
                                                @if($p->location)
                                                    <span><i class="bi bi-geo-alt text-warning me-0.5"></i> {{ $p->location }}</span>
                                                @endif
                                                @if($p->duration)
                                                    <span><i class="bi bi-clock-history text-warning me-0.5"></i> {{ $p->duration }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sidebar Bottom Link -->
                    <div class="pt-3 mt-3 border-top border-secondary border-opacity-20 px-2 d-flex align-items-center justify-content-between">
                        <span class="text-white-50 fs-8">{{ $isEn ? 'Inspect technical cases' : 'فحص الحالات المعتمدة' }}</span>
                        <a href="{{ route('projects.index') }}" class="text-warning text-decoration-none fs-8 fw-bold d-flex align-items-center gap-1 hover-underline">
                            <span>{{ $isEn ? 'View all cases' : 'عرض كافة الحالات' }}</span>
                            <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- MAIN SHOWCASE AREA: Interactive Before / After Slider -->
            <div class="col-lg-8 col-xl-8 order-1 order-lg-2">
                @if($firstProj)
                <div class="showcase-viewer-card rounded-4 overflow-hidden border border-secondary border-opacity-30 position-relative shadow-2xl h-100 d-flex flex-column" style="background: #0D1522; min-height: 520px;">
                    
                    <!-- Top Info Header of Active Project -->
                    <div class="showcase-viewer-header p-3.5 px-4 border-bottom border-secondary border-opacity-20 d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #111A28;">
                        <div class="min-w-0">
                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                <span id="showcaseActiveServiceBadge" class="badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-30 px-2.5 py-1 rounded-pill fs-8 fw-bold">
                                    <i id="showcaseActiveServiceIcon" class="bi {{ $firstProj->service?->icon ?? 'bi-gear' }} me-1"></i>
                                    <span id="showcaseActiveServiceText">{{ $firstProj->service?->name ?? ($isEn ? 'Marine Maintenance' : 'صيانة بحرية') }}</span>
                                </span>
                                <span id="showcaseActiveMetaLocation" class="text-white-50 fs-8 d-flex align-items-center gap-1 {{ empty($firstProj->location) ? 'd-none' : '' }}">
                                    <i class="bi bi-geo-alt-fill text-danger"></i> <span id="showcaseActiveLocationText">{{ $firstProj->location }}</span>
                                </span>
                                <span id="showcaseActiveMetaDuration" class="text-white-50 fs-8 d-flex align-items-center gap-1 {{ empty($firstProj->duration) ? 'd-none' : '' }}">
                                    <i class="bi bi-stopwatch text-warning"></i> <span id="showcaseActiveDurationText">{{ $firstProj->duration }}</span>
                                </span>
                            </div>
                            <!-- Clickable Title in Viewer -->
                            <h4 class="fw-extrabold text-white m-0 text-truncate">
                                <a id="showcaseActiveTitleLink" href="{{ route('projects.show', $firstProj->slug) }}" class="text-white text-decoration-none hover-gold transition-colors" title="{{ $isEn ? 'Click to view full case study' : 'اضغط لعرض تفاصيل دراسة الحالة' }}">
                                    {{ $firstProj->title }}
                                </a>
                            </h4>
                        </div>

                        <!-- CTA Button to Project Details -->
                        <a id="showcaseActiveBtnLink" href="{{ route('projects.show', $firstProj->slug) }}" class="btn btn-case-gold rounded-pill px-3.5 py-2 fs-7 fw-bold d-flex align-items-center gap-1.5 shadow-sm text-nowrap">
                            <span>{{ $isEn ? 'View Case Details' : 'عرض تفاصيل المشروع' }}</span>
                            <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                        </a>
                    </div>

                    <!-- Interactive Before / After Slider Box -->
                    <div class="showcase-slider-container position-relative flex-grow-1 overflow-hidden" style="min-height: 400px; height: 440px; direction: ltr !important; text-align: left; user-select: none;">
                        
                        <!-- AFTER Background Image (Full Width Underneath) -->
                        <img id="showcaseAfterImg" src="{{ $firstProj->after_image_url }}" alt="After Maintenance" class="showcase-img position-absolute w-100 h-100 object-fit-cover user-select-none" style="top: 0; left: 0;">

                        <!-- AFTER Label Pill (Bottom Right) -->
                        <div class="case-pill-badge position-absolute bottom-0 end-0 m-3.5 badge bg-black bg-opacity-80 text-white border border-secondary border-opacity-50 px-3.5 py-2 rounded-pill fs-8 fw-bold letter-spacing-1 shadow-lg" style="direction: {{ $isEn ? 'ltr' : 'rtl' }}; z-index: 5;">
                            <i class="bi bi-check2-circle text-success me-1"></i> AFTER (بعد الصيانة)
                        </div>

                        <!-- BEFORE Foreground Clipped Image Container -->
                        <div id="showcaseBeforeContainer" class="position-absolute overflow-hidden" style="top: 0; bottom: 0; left: 0; width: 50%; z-index: 10;">
                            <img id="showcaseBeforeImg" src="{{ $firstProj->before_image_url }}" alt="Before Maintenance" class="showcase-img position-absolute user-select-none" style="top: 0; left: 0; height: 100%; object-fit: cover;">

                            <!-- BEFORE Label Pill (Bottom Left) -->
                            <div class="case-pill-badge position-absolute bottom-0 start-0 m-3.5 badge bg-black bg-opacity-80 text-white border border-secondary border-opacity-50 px-3.5 py-2 rounded-pill fs-8 fw-bold letter-spacing-1 shadow-lg" style="direction: {{ $isEn ? 'ltr' : 'rtl' }}; z-index: 15;">
                                <i class="bi bi-clock-history text-danger me-1"></i> BEFORE (قبل الصيانة)
                            </div>
                        </div>

                        <!-- Drag Handle -->
                        <div id="showcaseHandle" class="case-slider-handle position-absolute top-0 bottom-0 d-flex align-items-center justify-content-center" style="left: 50%; width: 4px; background: #E5A919; cursor: ew-resize; z-index: 25; transform: translateX(-50%);">
                            <div class="case-handle-circle rounded-circle d-flex align-items-center justify-content-center shadow-2xl" style="width: 44px; height: 44px; background: #0A1D37; border: 2.5px solid #E5A919; color: #E5A919;">
                                <i class="bi bi-arrows fs-5"></i>
                            </div>
                        </div>

                        <!-- Interactive Drag Hint Overlay (fades out on interaction) -->
                        <div id="showcaseDragHint" class="position-absolute top-0 start-50 translate-middle-x mt-3 badge bg-black bg-opacity-75 text-warning border border-warning border-opacity-30 rounded-pill px-3 py-1.5 fs-8 pointer-events-none shadow-lg d-flex align-items-center gap-1.5" style="z-index: 30; transition: opacity 0.5s ease;">
                            <i class="bi bi-arrows-expand"></i>
                            <span>{{ $isEn ? 'Drag slider to compare Before & After' : 'اسحب المؤشر للمقارنة قبل وبعد الصيانة' }}</span>
                        </div>

                    </div>

                    <!-- Viewer Footer Note / Short Desc -->
                    <div class="p-3 px-4 bg-dark bg-opacity-70 border-top border-secondary border-opacity-20 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <p id="showcaseActiveDesc" class="text-white-50 fs-8 m-0 line-clamp-2" style="max-width: 680px;">
                            {{ $firstProj->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($firstProj->description), 110) }}
                        </p>
                        <span id="showcaseActiveVessel" class="text-warning fs-8 fw-bold text-nowrap {{ empty($firstProj->vessel_type) ? 'd-none' : '' }}">
                            <i class="bi bi-shield-check me-1"></i> <span id="showcaseActiveVesselText">{{ $firstProj->vessel_type }}</span>
                        </span>
                    </div>

                </div>
                @endif
            </div>

        </div>
        @else
        <div class="py-5 text-center text-white-50">
            <p>{{ $isEn ? 'No maintenance cases published yet.' : 'جاري إضافة وتوثيق مشاريع الصيانة قريباً.' }}</p>
        </div>
        @endif

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
             
                <h2 class="display-section mt-1 mb-0">
                    {{ $isEn ? 'Top-Rated Marine & Safety Products' : 'أبرز المنتجات المعتمدة للتوريد' }}
                </h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn-alex-outline mt-3 mt-md-0 align-self-start">
                {{ $isEn ? 'View All Catalog' : 'عرض الكتالوج بالكامل' }}
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($featuredProducts as $i => $prod)
            @php
                $prodCatSlug = $prod->category?->slug ?? 'general';
                $prodCatName = $prod->category ? ($isEn ? ($prod->category->name_en ?: $prod->category->name_ar) : $prod->category->name_ar) : ($isEn ? 'Marine Supplies' : 'توريدات بحرية');
                $prodUrl = route('products.show', ['category_slug' => $prodCatSlug, 'product_slug' => $prod->slug]);
            @endphp
            <div class="col-6 col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ ($i % 4) * 60 }}">
                <div class="product-card">
                    <div class="product-card-img-wrap">
                        <span class="product-badge-category">{{ $prodCatName }}</span>
                        <img src="{{ $prod->image ?: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=500&q=80' }}"
                             alt="{{ $prod->name_ar }}"
                             loading="lazy">
                    </div>
                    <div class="product-card-body">
                        <a href="{{ $prodUrl }}"
                           class="product-card-title">
                            {{ $isEn ? ($prod->name_en ?: $prod->name_ar) : $prod->name_ar }}
                        </a>
                        <div class="product-card-sku">SKU: {{ $prod->sku }}</div>
                        <div class="product-card-footer">
                            
                            <a href="{{ $prodUrl }}"
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

            // Silk smooth opacity and transform transition
            gridWrapper.style.transition = 'opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1)';
            gridWrapper.style.opacity = '0.35';
            gridWrapper.style.transform = 'translateY(6px)';

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
                requestAnimationFrame(() => {
                    gridWrapper.style.opacity = '1';
                    gridWrapper.style.transform = 'translateY(0)';
                });

                // Update URL in browser history without reload or page jumping
                window.history.pushState(null, '', url);
            })
            .catch(err => {
                console.error('Failed to load category products:', err);
                gridWrapper.style.opacity = '1';
                gridWrapper.style.transform = 'translateY(0)';
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
    // ═════════════════════════════════════════════════════════════
    // HOME MAINTENANCE SHOWCASE: SIDEBAR SWITCHING & BEFORE/AFTER SLIDER
    // ═════════════════════════════════════════════════════════════
    const showcaseItems = document.querySelectorAll('.showcase-project-item');
    const showcaseContainer = document.querySelector('.showcase-slider-container');
    const showcaseBeforeContainer = document.getElementById('showcaseBeforeContainer');
    const showcaseBeforeImg = document.getElementById('showcaseBeforeImg');
    const showcaseAfterImg = document.getElementById('showcaseAfterImg');
    const showcaseHandle = document.getElementById('showcaseHandle');
    const showcaseHint = document.getElementById('showcaseDragHint');

    // Text & Link elements
    const titleLink = document.getElementById('showcaseActiveTitleLink');
    const btnLink = document.getElementById('showcaseActiveBtnLink');
    const serviceIcon = document.getElementById('showcaseActiveServiceIcon');
    const serviceText = document.getElementById('showcaseActiveServiceText');
    const metaLocation = document.getElementById('showcaseActiveMetaLocation');
    const textLocation = document.getElementById('showcaseActiveLocationText');
    const metaDuration = document.getElementById('showcaseActiveMetaDuration');
    const textDuration = document.getElementById('showcaseActiveDurationText');
    const metaVessel = document.getElementById('showcaseActiveVessel');
    const textVessel = document.getElementById('showcaseActiveVesselText');
    const textDesc = document.getElementById('showcaseActiveDesc');

    function syncShowcaseImgWidth() {
        if (!showcaseContainer || !showcaseBeforeImg) return;
        const w = showcaseContainer.clientWidth;
        if (w > 0) {
            showcaseBeforeImg.style.width = w + 'px';
            showcaseBeforeImg.style.maxWidth = w + 'px';
        }
    }

    function activateShowcaseProject(item) {
        if (!item) return;
        showcaseItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');

        const d = item.dataset;
        if (titleLink) {
            titleLink.textContent = d.title;
            titleLink.href = d.url;
        }
        if (btnLink) {
            btnLink.href = d.url;
        }
        if (serviceText) {
            serviceText.textContent = d.service;
        }
        if (serviceIcon && d.serviceIcon) {
            serviceIcon.className = 'bi ' + d.serviceIcon + ' me-1';
        }
        if (textLocation && metaLocation) {
            if (d.location) {
                textLocation.textContent = d.location;
                metaLocation.classList.remove('d-none');
            } else {
                metaLocation.classList.add('d-none');
            }
        }
        if (textDuration && metaDuration) {
            if (d.duration) {
                textDuration.textContent = d.duration;
                metaDuration.classList.remove('d-none');
            } else {
                metaDuration.classList.add('d-none');
            }
        }
        if (textVessel && metaVessel) {
            if (d.vessel) {
                textVessel.textContent = d.vessel;
                metaVessel.classList.remove('d-none');
            } else {
                metaVessel.classList.add('d-none');
            }
        }
        if (textDesc) {
            textDesc.textContent = d.desc;
        }

        if (showcaseBeforeImg && d.before) {
            showcaseBeforeImg.src = d.before;
        }
        if (showcaseAfterImg && d.after) {
            showcaseAfterImg.src = d.after;
        }

        // Reset handle to center 50%
        if (showcaseBeforeContainer && showcaseHandle) {
            showcaseBeforeContainer.style.width = '50%';
            showcaseHandle.style.left = '50%';
        }
        syncShowcaseImgWidth();
    }

    showcaseItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // If clicking directly on the title link, let normal link navigation proceed!
            if (e.target.closest('a')) {
                return;
            }
            activateShowcaseProject(this);
        });

        // Also switch on hover for fast interactive feedback
        item.addEventListener('mouseenter', function() {
            activateShowcaseProject(this);
        });
    });

    if (showcaseContainer && showcaseBeforeContainer && showcaseHandle) {
        let isShowcaseDragging = false;

        function updateShowcaseSlider(clientX) {
            const rect = showcaseContainer.getBoundingClientRect();
            let posX = clientX - rect.left;
            if (posX < 0) posX = 0;
            if (posX > rect.width) posX = rect.width;

            const pct = Math.max(0, Math.min(100, (posX / rect.width) * 100));
            showcaseBeforeContainer.style.width = pct + '%';
            showcaseHandle.style.left = pct + '%';

            if (showcaseHint) {
                showcaseHint.style.opacity = '0';
            }
        }

        showcaseContainer.addEventListener('mousedown', function(e) {
            isShowcaseDragging = true;
            updateShowcaseSlider(e.clientX);
        });

        window.addEventListener('mouseup', function() {
            isShowcaseDragging = false;
        });

        window.addEventListener('mousemove', function(e) {
            if (!isShowcaseDragging) return;
            updateShowcaseSlider(e.clientX);
        });

        showcaseContainer.addEventListener('touchstart', function(e) {
            isShowcaseDragging = true;
            if (e.touches && e.touches.length > 0) {
                updateShowcaseSlider(e.touches[0].clientX);
            }
        }, { passive: true });

        window.addEventListener('touchend', function() {
            isShowcaseDragging = false;
        });

        window.addEventListener('touchmove', function(e) {
            if (!isShowcaseDragging || !e.touches || e.touches.length === 0) return;
            updateShowcaseSlider(e.touches[0].clientX);
        }, { passive: true });

        syncShowcaseImgWidth();
        window.addEventListener('resize', syncShowcaseImgWidth);
        if (showcaseBeforeImg) {
            showcaseBeforeImg.addEventListener('load', syncShowcaseImgWidth);
        }
    }
});
</script>
<style>
.showcase-project-item {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.07);
    cursor: pointer;
    transition: background-color 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.showcase-project-item:hover {
    background: rgba(229, 169, 25, 0.08);
    border-color: rgba(229, 169, 25, 0.35);
    transform: translateX(-3px);
}
[dir="ltr"] .showcase-project-item:hover {
    transform: translateX(3px);
}
.showcase-project-item.active {
    background: linear-gradient(135deg, rgba(229, 169, 25, 0.16) 0%, rgba(10, 29, 55, 0.95) 100%);
    border-color: #E5A919 !important;
    box-shadow: 0 6px 20px rgba(229, 169, 25, 0.2);
}
.showcase-project-item.active .showcase-item-title a {
    color: #E5A919 !important;
}
.showcase-project-item.active .showcase-item-arrow {
    color: #E5A919 !important;
    transform: scale(1.15);
}
.showcase-thumb-box img {
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.showcase-project-item:hover .showcase-thumb-box img {
    transform: scale(1.05);
}
.case-slider-handle {
    touch-action: none;
}
.case-handle-circle {
    transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.case-slider-handle:hover .case-handle-circle,
.case-slider-handle:active .case-handle-circle {
    transform: scale(1.08);
    box-shadow: 0 0 20px rgba(229, 169, 25, 0.8) !important;
}
.btn-case-gold {
    background: linear-gradient(135deg, #FAD961 0%, #F7B731 35%, #D49B23 70%, #B37D14 100%);
    color: #061325 !important;
    border: none;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.btn-case-gold:hover {
    background: linear-gradient(135deg, #FFF0B3 0%, #FCD04B 40%, #E5A315 75%, #C48712 100%);
    color: #000000 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(229, 169, 25, 0.4) !important;
}
.project-card-hover {
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.project-card-hover:hover {
    transform: translateY(-4px);
    border-color: rgba(229, 169, 25, 0.5) !important;
    box-shadow: 0 16px 32px rgba(0,0,0,0.5) !important;
}
.project-card-hover:hover .transition-transform {
    transform: scale(1.04);
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
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ════════════════════════════════════════════
   LUXURY CHOREOGRAPHED HERO ENTRANCE
════════════════════════════════════════════ */
@keyframes luxuryHeroEntrance {
    0% {
        opacity: 0;
        transform: translateY(16px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes luxuryNavEntrance {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.hero-anim-nav {
    animation: luxuryNavEntrance 0.55s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: 0s;
}
.hero-anim-tagline {
    animation: luxuryHeroEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: 0.08s;
}
.hero-anim-title {
    animation: luxuryHeroEntrance 0.65s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: 0.16s;
}
.hero-anim-desc {
    animation: luxuryHeroEntrance 0.65s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: 0.24s;
}
.hero-anim-actions {
    animation: luxuryHeroEntrance 0.65s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: 0.32s;
}
.hero-anim-footer {
    animation: luxuryHeroEntrance 0.65s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: 0.40s;
}

/* Redesigned Clean Category Cards with High Photo Clarity & Luxury Transitions */
.category-cover-card-clean {
    height: 240px;
    background-color: #0A1D37;
    border: 1px solid rgba(10, 29, 55, 0.12);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.category-cover-bg-clean {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), filter 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
/* Subtle low-opacity gradient so photos are crisp and vibrant */
.category-cover-overlay-clean {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0) 35%, rgba(6, 19, 37, 0.45) 65%, rgba(6, 19, 37, 0.9) 100%);
    transition: background 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.category-cover-hover-details {
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1), margin-top 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    margin-top: 0;
}
.category-cover-card-clean:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(10, 29, 55, 0.20) !important;
    border-color: var(--alex-gold) !important;
}
.category-cover-card-clean:hover .category-cover-bg-clean {
    transform: scale(1.04);
}
.category-cover-card-clean:hover .category-cover-overlay-clean {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.05) 15%, rgba(6, 19, 37, 0.6) 55%, rgba(6, 19, 37, 0.95) 100%);
}
.category-cover-card-clean:hover .category-cover-hover-details {
    max-height: 80px;
    opacity: 1;
    margin-top: 0.35rem;
}

@media (max-width: 576px) {
    .category-cover-card-clean {
        height: 135px !important;
        border-radius: 12px !important;
    }
    .category-cover-content-clean {
        padding: 0.65rem !important;
    }
    .category-cover-title-clean {
        font-size: 0.82rem !important;
    }
    .category-cover-mini-icon {
        width: 26px !important;
        height: 26px !important;
    }
    .category-cover-mini-icon i {
        font-size: 0.75rem !important;
    }
}

.hover-translate {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.hover-translate:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(10, 29, 55, 0.10) !important;
}

/* Interactive Directional SVG Arrow (Subtle Luxury Hover Glide — No Twitching) */
.explore-arrow-link {
    transition: color 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.animated-arrow-icon {
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.explore-arrow-link:hover .animated-arrow-icon {
    transform: translateX(-5px);
}
[dir="ltr"] .explore-arrow-link:hover .animated-arrow-icon {
    transform: translateX(5px);
}
</style>
@endpush
