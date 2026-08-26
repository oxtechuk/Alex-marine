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
     3. ABOUT US & DEPARTMENTS (CLICKABLE CATEGORIES)
═══════════════════════════════════════════════ --}}
{{-- ═══════════════════════════════════════════════
     3. ABOUT US & DEPARTMENTS (INTERACTIVE COVER CARDS)
═══════════════════════════════════════════════ --}}
@if($secFeature)
<section class="section-py" style="background:#ffffff;" id="about-departments-section">
    <div class="container">
        <div class="row align-items-center g-5">

            {{-- Left Content: About Us --}}
            <div class="col-lg-5" data-aos="fade-right">
                @php
                    $aboutTagline = !empty($settings['about_tagline_'.$locale]) ? trim($settings['about_tagline_'.$locale], " .\t\n\r\0\x0B") : '';
                    $aboutTitle   = !empty($settings['about_title_'.$locale]) ? trim($settings['about_title_'.$locale], " .\t\n\r\0\x0B") : '';
                    $aboutDesc    = !empty($settings['about_desc_'.$locale]) ? trim($settings['about_desc_'.$locale], " .\t\n\r\0\x0B") : '';
                @endphp

                @if(!empty($aboutTagline))
                <div class="section-tag section-tag-gold mb-2">
                    <i class="bi bi-building"></i>
                    {{ $aboutTagline }}
                </div>
                @endif

                {{-- Custom Logo / Section Image from Settings --}}
                @php
                    $aboutLogo = !empty($settings['about_section_image'])
                        ? $settings['about_section_image']
                        : (!empty($settings['site_logo_header']) ? $settings['site_logo_header'] : null);
                @endphp
                @if($aboutLogo)
                    <div class="my-2">
                        <img src="{{ \Illuminate\Support\Str::startsWith($aboutLogo, ['http://', 'https://']) ? $aboutLogo : asset($aboutLogo) }}"
                             alt="Company Logo"
                             class="img-fluid"
                             style="max-height: 52px; width: auto; object-fit: contain;">
                    </div>
                @endif

                @if(!empty($aboutTitle))
                <h2 class="display-section mt-2 mb-3">
                    {{ $aboutTitle }}
                </h2>
                @endif

                @if(!empty($aboutDesc))
                <p class="mb-4 text-muted" style="line-height:1.75;">
                    {{ $aboutDesc }}
                </p>
                @endif

                {{-- Benefit Points --}}
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach([
                        [$isEn ? 'Direct B2B Pricing' : 'تسعير مباشر ومنافس', $isEn ? 'Official itemized quotation sheets.' : 'عروض أسعار رسمية فورية وموثقة.', 'bi-tag-fill', 'var(--alex-gold)'],
                        [$isEn ? 'Port Emergency Supply' : 'ضمان التوريد السريع', $isEn ? 'Direct delivery to all Egyptian ports and zones.' : 'توصيل طوارئ مباشر لكافة الموانئ والمواقع الجمركية.', 'bi-truck-front-fill', 'var(--alex-navy-dark)'],
                        [$isEn ? 'Certified to SOLAS & ISO' : 'معايير دولية معتمدة', $isEn ? 'Fully compliant with SOLAS and ISO quality systems.' : 'مطابقة تامة لمواصفات SOLAS و ISO الدولية.', 'bi-patch-check-fill', '#047857'],
                    ] as [$title, $desc, $icon, $color])
                    <div class="d-flex align-items-start gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded flex-shrink-0"
                             style="width:38px;height:38px;background:#F2F4F7;border:1px solid #E5E7EB;">
                            <i class="bi {{ $icon }}" style="color:{{ $color }};font-size:1rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold mb-0 text-dark" style="font-size:0.92rem;">{{ $title }}</div>
                            <div class="text-muted" style="font-size:0.82rem;">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('about') }}" class="btn-alex-primary px-4 py-2.5">
                        <i class="bi bi-info-circle"></i>
                        {{ $isEn ? 'More About Us' : 'تعرف علينا أكثر' }}
                    </a>
                    <a href="{{ route('quote.index') }}" class="btn-alex-gold px-4 py-2.5">
                        <i class="bi bi-file-earmark-plus"></i>
                        {{ $isEn ? 'Request Quote' : 'اطلب عرض سعر' }}
                    </a>
                </div>
            </div>

            {{-- Right: Interactive Category Cover Cards (Hover reveals details) --}}
            <div class="col-lg-7">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold m-0 text-dark">
                        <i class="bi bi-grid-fill text-warning me-2"></i>
                        {{ $isEn ? 'Our Product Departments' : 'أقسام التوريدات والمنتجات' }}
                    </h5>
                    <span class="text-muted fs-8">
                        <i class="bi bi-cursor-fill me-1"></i> {{ $isEn ? 'Hover or click to explore' : 'مرر الماوس أو اضغط لاستكشاف القسم' }}
                    </span>
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
                               class="category-cover-card"
                               title="{{ $isEn ? 'View ' . ($cat->name_en ?: $cat->name_ar) . ' Products' : 'عرض منتجات ' . $cat->name_ar }}">
                                
                                {{-- Background Cover Image --}}
                                <img src="{{ \Illuminate\Support\Str::startsWith($coverImg, ['http://', 'https://']) ? $coverImg : asset($coverImg) }}"
                                     alt="{{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}"
                                     class="category-cover-bg"
                                     loading="lazy">
                                
                                {{-- Dark Overlay Gradient --}}
                                <div class="category-cover-overlay"></div>

                                {{-- Top Badge --}}
                                <span class="category-cover-badge">
                                    <i class="bi bi-patch-check-fill text-warning me-1"></i>{{ $isEn ? 'Certified' : 'قسم معتمد' }}
                                </span>

                                {{-- Content & On-Hover Details --}}
                                <div class="category-cover-content">
                                    <div class="category-cover-icon">
                                        <i class="bi {{ $icon }}"></i>
                                    </div>
                                    <h5 class="category-cover-title">
                                        {{ $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar }}
                                    </h5>
                                    
                                    {{-- Hidden Details (Revealed on Hover) --}}
                                    <div class="category-cover-details">
                                        <p class="category-cover-desc">{{ $desc }}</p>
                                        <div class="category-cover-cta">
                                            <span>{{ $isEn ? 'Browse Products' : 'تصفح منتجات القسم' }}</span>
                                            <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                                        </div>
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
     5. OPERATIONS / FIELD SHOWCASE
═══════════════════════════════════════════════ --}}
@if($secGallery)
<section class="section-py" style="background:var(--alex-light-bg);" id="gallery-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
          
            <h2>{{ $isEn ? 'Operational Excellence at Sea & Docks' : 'عملياتنا وتجهيز السفن والموانئ' }}</h2>
            <div class="section-divider"></div>
            <p>{{ $isEn ? 'Technical inspections, port deliveries, and marine safety maintenance operations.' : 'لقطات من تجهيز الموانئ والتفتيش البحري الفني على معدات السلامة.' }}</p>
        </div>

        <div class="row g-4">
            @php
            $galleryItems = [
                ['https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=800&q=80', $isEn ? 'Commercial Vessel Supply' : 'تجهيز السفن التجارية', $isEn ? 'Complete mooring, safety, and operational deck equipment.' : 'تجهيز متكامل لحبال الرسو ومعدات السطح وسلامة الطاقم.', 'bi-anchor'],
                ['https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80', $isEn ? 'Technical SCBA Inspection' : 'فحص وصيانة أجهزة التنفس', $isEn ? 'Certified hydrostatic testing & pressure calibration.' : 'اختبارات الضغط والمعايرة المعتمدة لأجهزة التنفس الإطفائية.', 'bi-mask'],
                ['https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80', $isEn ? 'SOLAS Rescue Gear' : 'معدات الإنقاذ SOLAS', $isEn ? 'Certified life jackets, lifebuoys, and emergency beacons.' : 'سترات وطوافات نجاة معتمدة دولياً مع أجهزة الاستغاثة.', 'bi-life-preserver'],
            ];
            @endphp

            @foreach($galleryItems as $i => [$img, $title, $desc, $icon])
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                <div class="alex-card overflow-hidden h-100">
                    <div style="height:200px; overflow:hidden; border-bottom:1px solid var(--alex-border);">
                        <img src="{{ $img }}" class="w-100 h-100" style="object-fit:cover;"
                             alt="{{ $title }}" loading="lazy">
                    </div>
                    <div class="p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi {{ $icon }} text-warning fs-5"></i>
                            <h5 class="fw-bold m-0 text-dark">{{ $title }}</h5>
                        </div>
                        <p class="m-0 text-muted" style="font-size:0.87rem; line-height:1.6;">{{ $desc }}</p>
                    </div>
                </div>
            </div>
            @endforeach
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
@endpush
