@extends('layouts.app')

@php
    use App\Models\Setting;
    use Illuminate\Support\Str;

    $isEn = app()->getLocale() == 'en';
    $locale = app()->getLocale();

    // CMS & Setting variables with sensible defaults
    $heroBgImageRaw = Setting::get('hero_bg_image', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1920&q=85');
    $heroBgImage    = Str::startsWith($heroBgImageRaw, ['http://', 'https://']) ? $heroBgImageRaw : asset($heroBgImageRaw);

    $heroTagline    = Setting::get('hero_tagline_'.$locale, 'ALEX MARINE');
    $heroTitle      = Setting::get('hero_title_'.$locale, $isEn ? 'Your Trusted Partner in Marine Supplies & Industrial Safety' : 'شريكك الموثوق في التوريدات البحرية والأمن الصناعي البحري');
    $heroDesc       = Setting::get('hero_desc_'.$locale, $isEn ? 'We provide top-tier marine safety equipment and offshore supplies with long-standing expertise serving the maritime navigation and marine industry.' : 'نوفر لك أفضل معدات السلامة والتوريدات البحرية بجودة عالية وخبرة طويلة في خدمة قطاع الملاحة البحرية والصناعات المرتبطة بها');
    $heroCtaText    = Setting::get('hero_cta_text_'.$locale, $isEn ? 'Browse Products' : 'تصفح المنتجات');

    $contactWhatsapp = Setting::get('contact_whatsapp', '+201200001122');
    $contactPhone    = Setting::get('contact_phone', '+20 120 455 7190');
    $contactEmail    = Setting::get('contact_email', 'info@alexmarine.eg');
    $siteLogo        = Setting::get('site_logo_header', '/uploads/Alex-marin.svg');
    $siteLogoSrc     = !empty($siteLogo) ? (Str::startsWith($siteLogo, ['http://', 'https://']) ? $siteLogo : asset($siteLogo)) : '';

    // Default high quality category mock data matching the UX design
    $defaultCategories = [
        [
            'slug' => 'fire-fighting-systems',
            'name_ar' => 'أنظمة مكافحة الحريق',
            'name_en' => 'Fire Fighting Systems',
            'icon' => 'bi-fire',
            'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'operation-maintenance',
            'name_ar' => 'مستلزمات التشغيل والصيانة',
            'name_en' => 'Operation & Maintenance Supplies',
            'icon' => 'bi-gear-wide-connected',
            'image' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'navigation-communication',
            'name_ar' => 'معدات الملاحة والاتصالات',
            'name_en' => 'Navigation & Communication Equipment',
            'icon' => 'bi-broadcast-pin',
            'image' => 'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'marine-safety',
            'name_ar' => 'معدات السلامة البحرية',
            'name_en' => 'Marine Safety Equipment',
            'icon' => 'bi-life-preserver',
            'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'industrial-safety',
            'name_ar' => 'معدات الأمن الصناعي البحري',
            'name_en' => 'Marine Industrial Safety',
            'icon' => 'bi-shield-shaded',
            'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'electrical-electronic',
            'name_ar' => 'القطع الكهربائية والإلكترونية',
            'name_en' => 'Electrical & Electronic Parts',
            'icon' => 'bi-lightning-charge',
            'image' => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'ropes-rigging',
            'name_ar' => 'الحبال والتجهيزات البحرية',
            'name_en' => 'Ropes & Marine Rigging',
            'icon' => 'bi-link-45deg',
            'image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=600&q=80'
        ],
        [
            'slug' => 'survival-ppe',
            'name_ar' => 'ملابس النجاة والحماية الشخصية',
            'name_en' => 'Survival & Personal PPE',
            'icon' => 'bi-person-badge',
            'image' => 'https://images.unsplash.com/photo-1584634731339-252c581abfc5?auto=format&fit=crop&w=600&q=80'
        ],
    ];

    // Merge DB categories with default UX catalog if count < 8
    $categoryGridList = [];
    if (isset($categories) && $categories->count() >= 8) {
        $categoryGridList = $categories->take(8);
    } else {
        $dbCats = isset($categories) ? $categories->keyBy('slug') : collect();
        foreach ($defaultCategories as $def) {
            if ($dbCats->has($def['slug'])) {
                $categoryGridList[] = $dbCats->get($def['slug']);
            } else {
                $mockCat = new \App\Models\Category([
                    'slug' => $def['slug'],
                    'name_ar' => $def['name_ar'],
                    'name_en' => $def['name_en'],
                    'icon' => $def['icon'],
                    'image' => $def['image']
                ]);
                $mockCat->slug = $def['slug'];
                $categoryGridList[] = $mockCat;
            }
        }
    }
@endphp

@section('title', $isEn ? 'ALEX MARINE — Marine Supplies & Industrial Safety' : 'أليكس مارين — التوريدات البحرية والأمن الصناعي البحري')

@section('content')

{{-- ═══════════════════════════════════════════════
     1. HERO SECTION (OCEAN SUNSET CARGO VESSEL)
═══════════════════════════════════════════════ --}}
<section class="alex-ux-hero position-relative overflow-hidden" id="hero-section">
    {{-- Background Image --}}
    <div class="alex-hero-bg-layer" style="background-image: url('{{ $heroBgImage }}');"></div>
    <div class="alex-hero-overlay"></div>

    <div class="container position-relative z-3 h-100 d-flex flex-column justify-content-between py-4 py-lg-5">
        {{-- Empty top space for header breathing room --}}
        <div class="pt-4 pt-lg-5"></div>

        {{-- Hero Main Content --}}
        <div class="row align-items-center my-auto py-5">
            <div class="col-lg-8 col-xl-7 text-white" data-aos="fade-up" data-aos-duration="900">
                {{-- Golden Tagline Badge --}}
                <div class="alex-hero-badge mb-3 d-inline-flex align-items-center">
                    <span>{{ !empty($heroTagline) ? $heroTagline : 'ALEX MARINE' }}</span>
                </div>

                {{-- Hero Headline --}}
                <h1 class="alex-hero-headline fw-black mb-3">
                    {{ $heroTitle }}
                </h1>

                {{-- Hero Subtitle --}}
                <p class="alex-hero-subtitle text-white-50 mb-4 pb-2">
                    {{ $heroDesc }}
                </p>

                {{-- CTA Buttons --}}
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn-alex-gold-pill">
                        <span>{{ $heroCtaText }}</span>
                        <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="btn-alex-ghost-pill">
                        <span>{{ $isEn ? 'Contact Us' : 'تواصل معنا' }}</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Hero Bottom Slider Pagination --}}
        <div class="d-flex align-items-center justify-content-end text-white gap-3 pt-3" data-aos="fade-left">
            <div class="alex-hero-carousel-ctrls d-flex align-items-center gap-2">
                <button type="button" class="alex-hero-arrow-btn" aria-label="Previous slide"><i class="bi bi-chevron-{{ $isEn ? 'left' : 'right' }}"></i></button>
                <span class="alex-hero-slide-num fw-bold fs-8">01 / 03</span>
                <button type="button" class="alex-hero-arrow-btn" aria-label="Next slide"><i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }}"></i></button>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     2. FOUR PILLARS FEATURE BAR (DARK NAVY STRIP)
═══════════════════════════════════════════════ --}}
<section class="alex-features-strip py-4">
    <div class="container">
        <div class="row g-4 text-white text-center text-md-start align-items-center justify-content-between">
            {{-- Pillar 1: Customer Service --}}
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="50">
                <div class="alex-feature-pillar d-flex align-items-center gap-3">
                    <div class="alex-pillar-icon-box flex-shrink-0">
                        <i class="bi bi-headset"></i>
                    </div>
                    <div>
                        <h6 class="alex-pillar-title fw-bold m-0">{{ $isEn ? 'Premium Customer Care' : 'خدمة عملاء متميزة' }}</h6>
                        <small class="alex-pillar-sub text-white-50 fs-8">{{ $isEn ? 'Technical support & advice' : 'دعم فني واستشارات متخصصة' }}</small>
                    </div>
                </div>
            </div>

            {{-- Pillar 2: Fast Delivery --}}
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="alex-feature-pillar d-flex align-items-center gap-3">
                    <div class="alex-pillar-icon-box flex-shrink-0">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h6 class="alex-pillar-title fw-bold m-0">{{ $isEn ? 'Fast Delivery' : 'توصيل سريع' }}</h6>
                        <small class="alex-pillar-sub text-white-50 fs-8">{{ $isEn ? 'To all ports & locations' : 'لجميع المناطق والموانئ' }}</small>
                    </div>
                </div>
            </div>

            {{-- Pillar 3: Expertise --}}
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                <div class="alex-feature-pillar d-flex align-items-center gap-3">
                    <div class="alex-pillar-icon-box flex-shrink-0">
                        <i class="bi bi-compass"></i>
                    </div>
                    <div>
                        <h6 class="alex-pillar-title fw-bold m-0">{{ $isEn ? 'Domain Expertise' : 'خبرة في المجال' }}</h6>
                        <small class="alex-pillar-sub text-white-50 fs-8">{{ $isEn ? 'Years of maritime leadership' : 'سنوات من الخبرة البحرية' }}</small>
                    </div>
                </div>
            </div>

            {{-- Pillar 4: Guaranteed Quality --}}
            <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="alex-feature-pillar d-flex align-items-center gap-3">
                    <div class="alex-pillar-icon-box flex-shrink-0">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h6 class="alex-pillar-title fw-bold m-0">{{ $isEn ? 'Guaranteed Quality' : 'جودة مضمونة' }}</h6>
                        <small class="alex-pillar-sub text-white-50 fs-8">{{ $isEn ? 'Certified genuine supplies' : 'منتجات أصلية ومعتمدة' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     3. MAIN PRODUCT CATEGORIES (8 CARDS GRID)
═══════════════════════════════════════════════ --}}
<section class="alex-categories-section py-5" style="background:#F8FAFC;">
    <div class="container py-3">
        {{-- Section Header --}}
        <div class="d-flex align-items-end justify-content-between mb-4 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="text-gold fw-bold fs-7 d-block mb-1">{{ $isEn ? 'Our Products' : 'منتجاتنا' }}</span>
                <h2 class="alex-section-heading text-navy fw-black m-0">{{ $isEn ? 'Main Product Categories' : 'أقسام المنتجات الرئيسية' }}</h2>
            </div>
            <a href="{{ route('products.index') }}" class="alex-view-all-link text-decoration-none fw-bold fs-7 d-flex align-items-center gap-2">
                <span>{{ $isEn ? 'View All Products' : 'عرض جميع المنتجات' }}</span>
                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
            </a>
        </div>

        {{-- 8 Cards Grid --}}
        <div class="row g-3 g-lg-4">
            @foreach($categoryGridList as $idx => $cat)
                @php
                    $catTitle = $isEn ? ($cat->name_en ?: $cat->name_ar) : $cat->name_ar;
                    $catImg = !empty($cat->image) ? (Str::startsWith($cat->image, ['http://', 'https://']) ? $cat->image : asset($cat->image)) : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=600&q=80';
                    $catIcon = !empty($cat->icon) ? $cat->icon : 'bi-box-seam';
                @endphp
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $idx * 60 }}">
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="alex-category-card d-block text-decoration-none h-100">
                        <div class="alex-category-card-img-box position-relative overflow-hidden rounded-4">
                            <img src="{{ $catImg }}" alt="{{ $catTitle }}" class="alex-category-card-img w-100 h-100 object-fit-cover" loading="lazy">
                        </div>
                        <div class="alex-category-card-body d-flex align-items-center justify-content-between mt-3 px-1">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="alex-cat-badge-icon rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                    <i class="bi {{ $catIcon }}"></i>
                                </div>
                                <h6 class="alex-cat-card-title text-navy fw-bold m-0">{{ $catTitle }}</h6>
                            </div>
                            <div class="alex-cat-arrow-btn rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     4. ABOUT US (SPLIT DECK IMAGE & NAVY WATERMARK)
═══════════════════════════════════════════════ --}}
<section class="alex-about-split-section py-5" style="background:#07152B; color:#ffffff;">
    <div class="container py-3">
        <div class="row g-4 g-lg-5 align-items-center">
            {{-- Deck & Bollard Rope Image --}}
            <div class="col-lg-5" data-aos="fade-right">
                <div class="alex-about-photo-wrapper rounded-4 overflow-hidden position-relative shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1505705694340-019e1e335916?auto=format&fit=crop&w=1000&q=80"
                         alt="Alex Marine Deck"
                         class="w-100 h-100 object-fit-cover alex-about-deck-img"
                         loading="lazy">
                </div>
            </div>

            {{-- Dark Navy Content Box with Anchor Watermark --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="alex-about-content-box position-relative p-4 p-md-5 rounded-4 overflow-hidden">
                    {{-- Anchor Line-art Watermark --}}
                    <div class="alex-anchor-watermark position-absolute">
                        <i class="bi bi-anchor"></i>
                    </div>

                    <div class="position-relative z-2">
                        <span class="text-gold fw-bold fs-7 d-block mb-1">{{ $isEn ? 'About Us' : 'من نحن' }}</span>
                        <h2 class="alex-about-title text-white fw-black mb-3">ALEX MARINE</h2>
                        <p class="alex-about-desc text-white-50 leading-relaxed mb-4">
                            {{ $isEn
                                ? 'At Alex Marine, we specialize in supplying all maritime equipment, marine safety solutions, and industrial PPE for shipping lines and offshore vessels, strictly adhering to the highest global safety and quality standards.'
                                : 'نحن في أليكس مارين متخصصون في توريد جميع مستلزمات التجهيزات البحرية ومهمات السلامة والأمن الصناعي للقطاعات البحرية والملاحية مع التركيز على أعلى معايير الجودة والسلامة.' }}
                        </p>

                        {{-- 3 Features Row --}}
                        <div class="row g-3 pt-2 text-center text-md-start">
                            <div class="col-md-4">
                                <div class="alex-about-pill-box p-3 rounded-3">
                                    <div class="text-gold fs-4 mb-2"><i class="bi bi-people-fill"></i></div>
                                    <h6 class="text-white fw-bold fs-8 m-0">{{ $isEn ? 'Top Brand Partnerships' : 'شراكات مع أفضل الماركات العالمية' }}</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alex-about-pill-box p-3 rounded-3">
                                    <div class="text-gold fs-4 mb-2"><i class="bi bi-shield-check"></i></div>
                                    <h6 class="text-white fw-bold fs-8 m-0">{{ $isEn ? 'International Standards & Quality' : 'الالتزام بالجودة والمواصفات العالمية' }}</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="alex-about-pill-box p-3 rounded-3">
                                    <div class="text-gold fs-4 mb-2"><i class="bi bi-anchor"></i></div>
                                    <h6 class="text-white fw-bold fs-8 m-0">{{ $isEn ? 'Maritime Sector Service' : 'خدمة قطاع الملاحة البحرية' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     5. WHY CHOOSE US (EXPERIENCE & SAFETY)
═══════════════════════════════════════════════ --}}
<section class="alex-why-section py-5" style="background:#ffffff;">
    <div class="container py-4">
        <div class="row g-4 g-lg-5 align-items-center">
            {{-- Left: Text & CTA --}}
            <div class="col-lg-5" data-aos="fade-right">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge-gold-dot"></span>
                    <span class="text-gold fw-bold fs-7">{{ $isEn ? 'Why Choose Us?' : 'لماذا تختارنا؟' }}</span>
                </div>
                <h2 class="alex-section-heading text-navy fw-black mb-3">
                    {{ $isEn ? 'Experience and Quality Ensuring Your Safety at Sea' : 'خبرة وجودة تضمن سلامتك في البحر' }}
                </h2>
                <p class="text-muted leading-relaxed mb-4">
                    {{ $isEn
                        ? 'We provide integrated solutions and certified equipment to ensure the highest levels of safety and operational efficiency for our clients across the maritime and industrial sectors.'
                        : 'نقدم حلول متكاملة ومعدات معتمدة لضمان أعلى مستويات الأمان والكفاءة لعملائنا في القطاع البحري والصناعي.' }}
                </p>
                <a href="{{ route('about') }}" class="btn-alex-outline-navy">
                    <span>{{ $isEn ? 'Learn More About Us' : 'تعرف علينا أكثر' }}</span>
                    <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                </a>
            </div>

            {{-- Right: 3 Vertical Feature Cards with Photos --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="row g-3">
                    {{-- Card 1: Wide Coverage --}}
                    <div class="col-md-4">
                        <div class="alex-why-card h-100 rounded-4 overflow-hidden shadow-sm bg-white border">
                            <div class="alex-why-card-img" style="background-image: url('https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=500&q=80');"></div>
                            <div class="p-3 text-center">
                                <div class="alex-why-icon-bubble mx-auto mb-2"><i class="bi bi-globe2"></i></div>
                                <h6 class="fw-bold text-navy mb-1 fs-7">{{ $isEn ? 'Wide Coverage' : 'تغطية واسعة' }}</h6>
                                <p class="text-muted fs-8 m-0">{{ $isEn ? 'Reaching clients across all ports & regions' : 'نوصل لعملائنا في جميع الموانئ والمناطق' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Specialized Support --}}
                    <div class="col-md-4">
                        <div class="alex-why-card h-100 rounded-4 overflow-hidden shadow-sm bg-white border">
                            <div class="alex-why-card-img" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d0fbb186156f?auto=format&fit=crop&w=500&q=80');"></div>
                            <div class="p-3 text-center">
                                <div class="alex-why-icon-bubble mx-auto mb-2"><i class="bi bi-headset"></i></div>
                                <h6 class="fw-bold text-navy mb-1 fs-7">{{ $isEn ? 'Specialized Support' : 'دعم فني متخصص' }}</h6>
                                <p class="text-muted fs-8 m-0">{{ $isEn ? 'Custom consultations and solutions for every client' : 'استشارات وحلول مخصصة لكل عميل' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: High Quality --}}
                    <div class="col-md-4">
                        <div class="alex-why-card h-100 rounded-4 overflow-hidden shadow-sm bg-white border">
                            <div class="alex-why-card-img" style="background-image: url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=500&q=80');"></div>
                            <div class="p-3 text-center">
                                <div class="alex-why-icon-bubble mx-auto mb-2"><i class="bi bi-shield-check"></i></div>
                                <h6 class="fw-bold text-navy mb-1 fs-7">{{ $isEn ? 'High Quality' : 'جودة عالية' }}</h6>
                                <p class="text-muted fs-8 m-0">{{ $isEn ? 'Certified genuine products from leading global makers' : 'منتجات أصلية ومعتمدة من كبرى الشركات العالمية' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     6. FEATURED PRODUCTS (DARK OCEAN SLIDER)
═══════════════════════════════════════════════ --}}
<section class="alex-spotlight-products py-5 position-relative overflow-hidden" style="background: #0A1D37;">
    {{-- Decorative Background Ship Silhouette --}}
    <div class="alex-spotlight-bg-texture position-absolute inset-0"></div>

    <div class="container position-relative z-2 py-3">
        <div class="d-flex align-items-end justify-content-between mb-4 flex-wrap gap-2 text-white" data-aos="fade-up">
            <div>
                <span class="text-gold fw-bold fs-7 d-block mb-1">{{ $isEn ? 'Top Selection' : 'أبرز المنتجات' }}</span>
                <h2 class="alex-section-heading text-white fw-black m-0">{{ $isEn ? 'Featured Products' : 'منتجات مختارة' }}</h2>
            </div>
            <div class="alex-slider-arrows d-flex align-items-center gap-2">
                <button class="alex-slider-arrow-btn" id="prodPrev" aria-label="Previous"><i class="bi bi-chevron-{{ $isEn ? 'left' : 'right' }}"></i></button>
                <button class="alex-slider-arrow-btn" id="prodNext" aria-label="Next"><i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }}"></i></button>
            </div>
        </div>

        {{-- Products Grid / Carousel --}}
        @php
            $defaultSpotlightProducts = [
                ['name_ar' => 'مهمات حماية التنفس', 'name_en' => 'Respiratory Protection Equipment', 'img' => 'https://images.unsplash.com/photo-1584634731339-252c581abfc5?auto=format&fit=crop&w=400&q=80', 'slug' => 'respiratory'],
                ['name_ar' => 'سترات النجاة البحرية', 'name_en' => 'SOLAS Life Jackets', 'img' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=400&q=80', 'slug' => 'lifejackets'],
                ['name_ar' => 'أنظمة الإطفاء والطفايات', 'name_en' => 'Fire Extinguishing Systems', 'img' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=400&q=80', 'slug' => 'fire-extinguisher'],
                ['name_ar' => 'معدات السلامة الشخصية', 'name_en' => 'Personal Safety Helmets & Gear', 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=400&q=80', 'slug' => 'safety-helmets'],
            ];
            $displaySpotlight = (isset($featuredProducts) && $featuredProducts->count() > 0) ? $featuredProducts : $defaultSpotlightProducts;
        @endphp

        <div class="row g-3 g-lg-4" id="spotlightRow">
            @foreach($displaySpotlight as $i => $item)
                @php
                    $pName = is_object($item) ? ($isEn ? ($item->name_en ?: $item->name_ar) : $item->name_ar) : ($isEn ? $item['name_en'] : $item['name_ar']);
                    $pImg  = is_object($item) ? (!empty($item->image) ? (Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset($item->image)) : 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=400&q=80') : $item['img'];
                    $pUrl  = is_object($item) && isset($item->slug) ? route('products.show', ['category_slug' => $item->category?->slug ?? 'all', 'product_slug' => $item->slug]) : route('products.index');
                @endphp
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <div class="alex-spotlight-card rounded-4 p-3 bg-white h-100 d-flex flex-column justify-content-between position-relative shadow-lg">
                        <a href="{{ $pUrl }}" class="alex-spotlight-img-box d-block position-relative rounded-3 overflow-hidden text-center py-2">
                            <img src="{{ $pImg }}" alt="{{ $pName }}" class="alex-spotlight-img img-fluid" style="max-height: 160px; object-fit: contain;" loading="lazy">
                        </a>
                        <div class="alex-spotlight-card-footer mt-3 pt-2 border-top d-flex align-items-center justify-content-between">
                            <a href="{{ $pUrl }}" class="alex-spotlight-title text-navy fw-bold text-decoration-none fs-8 text-truncate" title="{{ $pName }}">
                                {{ $pName }}
                            </a>
                            <a href="{{ $pUrl }}" class="alex-spotlight-plus-btn rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" title="{{ $isEn ? 'View Product' : 'عرض المنتج' }}">
                                <i class="bi bi-plus-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     7. PROJECTS & STATISTICS (PART OF YOUR SUCCESS)
═══════════════════════════════════════════════ --}}
<section class="alex-projects-stats-section py-5" style="background:#F8FAFC;">
    <div class="container py-3">
        <div class="row g-4 g-lg-5 align-items-center">
            {{-- Crew at Port Image --}}
            <div class="col-lg-4" data-aos="fade-right">
                <div class="alex-stats-img-wrapper rounded-4 overflow-hidden shadow-md">
                    <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186156f?auto=format&fit=crop&w=700&q=80"
                         alt="Alex Marine Projects Crew"
                         class="w-100 h-100 object-fit-cover"
                         loading="lazy">
                </div>
            </div>

            {{-- Text & CTA --}}
            <div class="col-lg-5" data-aos="fade-up">
                <span class="text-gold fw-bold fs-7 d-block mb-1">{{ $isEn ? 'Our Projects' : 'مشاريعنا' }}</span>
                <h2 class="alex-section-heading text-navy fw-black mb-3">{{ $isEn ? 'We Are Part of Your Success' : 'نحن جزء من نجاحك' }}</h2>
                <p class="text-muted leading-relaxed mb-4">
                    {{ $isEn
                        ? 'We take pride in serving numerous maritime and industrial companies across diverse ports and projects, delivering reliable solutions that ensure operational continuity and crew safety.'
                        : 'نفخر بخدمة العديد من الشركات والمؤسسات البحرية والصناعية في مختلف المشاريع والموانئ، ونقدم حلولاً موثوقة تدعم استمرارية أعمالهم وأمان طاقمهم.' }}
                </p>
                <a href="{{ route('projects.index') }}" class="btn-alex-outline-navy">
                    <span>{{ $isEn ? 'Discover Our Projects' : 'اكتشف مشاريعنا' }}</span>
                    <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                </a>
            </div>

            {{-- Right: 3 Stats Counters --}}
            <div class="col-lg-3" data-aos="fade-left">
                <div class="d-flex flex-column gap-3">
                    {{-- Stat 1 --}}
                    <div class="alex-stat-card text-center p-3 rounded-4 bg-white border shadow-sm">
                        <div class="alex-stat-number text-navy fw-black" data-count="500" data-suffix="+">+500</div>
                        <div class="alex-stat-label text-muted fs-8 fw-bold">{{ $isEn ? 'Happy Clients' : 'عميل سعيد' }}</div>
                    </div>
                    {{-- Stat 2 --}}
                    <div class="alex-stat-card text-center p-3 rounded-4 bg-white border shadow-sm">
                        <div class="alex-stat-number text-navy fw-black" data-count="1200" data-suffix="+">+1200</div>
                        <div class="alex-stat-label text-muted fs-8 fw-bold">{{ $isEn ? 'Products Available' : 'منتج متوفر' }}</div>
                    </div>
                    {{-- Stat 3 --}}
                    <div class="alex-stat-card text-center p-3 rounded-4 bg-white border shadow-sm">
                        <div class="alex-stat-number text-navy fw-black" data-count="10" data-suffix="+">+10</div>
                        <div class="alex-stat-label text-muted fs-8 fw-bold">{{ $isEn ? 'Years of Experience' : 'سنوات من الخبرة' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     8. TESTIMONIALS (CLIENT REVIEWS CAROUSEL)
═══════════════════════════════════════════════ --}}
<section class="alex-testimonials-section py-5 text-white" style="background:#07152B;">
    <div class="container py-2 text-center position-relative">
        {{-- Navigation Arrow Buttons on Sides --}}
        <button class="alex-testi-arrow alex-testi-prev" aria-label="Previous"><i class="bi bi-chevron-{{ $isEn ? 'left' : 'right' }}"></i></button>
        <button class="alex-testi-arrow alex-testi-next" aria-label="Next"><i class="bi bi-chevron-{{ $isEn ? 'right' : 'left' }}"></i></button>

        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-8">
                <div class="text-gold fs-1 mb-2"><i class="bi bi-quote"></i></div>
                <p class="alex-testi-quote fs-6 leading-relaxed mb-3 fw-bold">
                    {{ $isEn
                        ? '"The punctuality and high quality of products from Alex Marine made a significant difference in our maritime operations across Egyptian ports."'
                        : '"الالتزام بالمواعيد وجودة المنتجات من أليكس مارين ميزت شراكتنا معهم في العديد من مشاريعنا وعملياتنا البحرية."' }}
                </p>
                <div class="alex-testi-author text-white-50 fs-8 fw-bold">
                    {{ $isEn ? 'Leading Maritime Shipping Company' : 'شركة بحرية وملاحية رائدة' }}
                </div>
                {{-- Carousel Dots Indicator --}}
                <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
                    <span class="alex-dot active"></span>
                    <span class="alex-dot"></span>
                    <span class="alex-dot"></span>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     9. CALL TO ACTION BANNER (SUNSET SUNBURST)
═══════════════════════════════════════════════ --}}
<section class="alex-cta-banner position-relative py-5 overflow-hidden">
    <div class="alex-cta-bg-layer position-absolute inset-0" style="background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80');"></div>
    <div class="alex-cta-overlay position-absolute inset-0"></div>

    <div class="container position-relative z-2 py-4 text-white">
        <div class="row align-items-center justify-content-between g-4">
            <div class="col-lg-7 text-center text-lg-start" data-aos="fade-right">
                <h2 class="alex-cta-title fw-black mb-2">{{ $isEn ? 'Contact Us Today' : 'تواصل معنا الآن' }}</h2>
                <p class="alex-cta-subtitle text-white-50 mb-4">{{ $isEn ? 'Get a consultation or order your certified marine supplies instantly' : 'للحصول على استشارة أو طلب منتجاتك وتوريداتك البحرية' }}</p>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="btn-alex-gold-pill d-inline-flex">
                    <i class="bi bi-telephone-fill"></i>
                    <span>{{ $isEn ? 'Call Us Now' : 'اتصل بنا' }}</span>
                </a>
            </div>

            <div class="col-lg-4 text-center text-lg-end" data-aos="fade-left">
                @if(!empty($siteLogoSrc))
                    <img src="{{ $siteLogoSrc }}" alt="ALEX MARINE" class="img-fluid" style="max-height: 85px; filter: drop-shadow(0 4px 12px rgba(0,0,0,0.5));">
                @else
                    <div class="d-inline-flex align-items-center gap-2 p-3 rounded-4 bg-navy-trans">
                        <i class="bi bi-anchor fs-2 text-gold"></i>
                        <span class="fs-4 fw-black text-white">ALEX MARINE</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ─────────────────────────────────────────────────────────────
   ALEX MARINE NEW LUXURY DESIGN SYSTEM (PIXEL-PERFECT UX)
───────────────────────────────────────────────────────────── */
:root {
    --alex-navy: #0A1D37;
    --alex-dark-navy: #07152B;
    --alex-gold: #E5A919;
    --alex-gold-gradient: linear-gradient(135deg, #FAD961 0%, #E5A919 100%);
    --alex-gold-hover: linear-gradient(135deg, #FFF0B3 0%, #D49B23 100%);
}

.text-gold { color: var(--alex-gold) !important; }
.text-navy { color: var(--alex-navy) !important; }

/* Hero Section */
.alex-ux-hero {
    min-height: 85vh;
    background-color: var(--alex-dark-navy);
}
.alex-hero-bg-layer {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
}
.alex-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(7, 21, 43, 0.95) 0%, rgba(7, 21, 43, 0.85) 45%, rgba(7, 21, 43, 0.4) 100%);
}
[dir="ltr"] .alex-hero-overlay {
    background: linear-gradient(90deg, rgba(7, 21, 43, 0.95) 0%, rgba(7, 21, 43, 0.85) 45%, rgba(7, 21, 43, 0.4) 100%);
}
.alex-hero-badge {
    background: rgba(229, 169, 25, 0.15);
    border: 1px solid rgba(229, 169, 25, 0.4);
    color: var(--alex-gold);
    font-size: 0.85rem;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 6px 16px;
    border-radius: 30px;
}
.alex-hero-headline {
    font-size: 2.75rem;
    line-height: 1.28;
    letter-spacing: -0.5px;
}
@media (max-width: 768px) {
    .alex-hero-headline {
        font-size: 1.85rem;
    }
}
.alex-hero-subtitle {
    font-size: 1.05rem;
    line-height: 1.7;
    max-width: 580px;
}

/* Luxury Pill Buttons */
.btn-alex-gold-pill {
    background: var(--alex-gold-gradient);
    color: #07152B !important;
    font-weight: 800;
    font-size: 0.95rem;
    padding: 12px 28px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(229, 169, 25, 0.35);
    transition: all 0.25s ease;
    border: none;
}
.btn-alex-gold-pill:hover {
    background: var(--alex-gold-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(229, 169, 25, 0.5);
    color: #000000 !important;
}
.btn-alex-ghost-pill {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 12px 28px;
    border-radius: 50px;
    border: 1.5px solid rgba(255, 255, 255, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.btn-alex-ghost-pill:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: #ffffff;
    transform: translateY(-2px);
}

.alex-hero-arrow-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}
.alex-hero-arrow-btn:hover {
    background: var(--alex-gold);
    color: #07152B;
    border-color: var(--alex-gold);
}

/* Features Strip */
.alex-features-strip {
    background: #061122;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}
.alex-pillar-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(229, 169, 25, 0.12);
    color: var(--alex-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.alex-pillar-title {
    font-size: 0.92rem;
}

/* Category Cards */
.alex-section-heading {
    font-size: 1.85rem;
    letter-spacing: -0.3px;
}
.alex-view-all-link {
    color: var(--alex-navy);
    transition: color 0.2s ease;
}
.alex-view-all-link:hover {
    color: var(--alex-gold);
}
.alex-category-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 10px;
    border: 1px solid #E2E8F0;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.alex-category-card-img-box {
    height: 150px;
}
.alex-category-card-img {
    transition: transform 0.4s ease;
}
.alex-category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(10, 29, 55, 0.1);
    border-color: var(--alex-gold);
}
.alex-category-card:hover .alex-category-card-img {
    transform: scale(1.06);
}
.alex-cat-badge-icon {
    width: 32px;
    height: 32px;
    background: #F1F5F9;
    color: var(--alex-navy);
    font-size: 0.95rem;
    transition: all 0.2s ease;
}
.alex-category-card:hover .alex-cat-badge-icon {
    background: var(--alex-navy);
    color: var(--alex-gold);
}
.alex-cat-card-title {
    font-size: 0.88rem;
    line-height: 1.3;
}
.alex-cat-arrow-btn {
    width: 26px;
    height: 26px;
    background: #07152B;
    color: #ffffff;
    font-size: 0.72rem;
    transition: all 0.2s ease;
}
.alex-category-card:hover .alex-cat-arrow-btn {
    background: var(--alex-gold);
    color: #07152B;
}

/* About Split Section */
.alex-about-photo-wrapper {
    height: 380px;
}
.alex-about-content-box {
    background: #0A1D37;
    border: 1px solid rgba(255, 255, 255, 0.08);
}
.alex-anchor-watermark {
    bottom: -40px;
    left: -20px;
    font-size: 16rem;
    color: rgba(255, 255, 255, 0.03);
    pointer-events: none;
    line-height: 1;
}
[dir="ltr"] .alex-anchor-watermark {
    left: auto;
    right: -20px;
}
.alex-about-pill-box {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: all 0.2s ease;
}
.alex-about-pill-box:hover {
    background: rgba(229, 169, 25, 0.1);
    border-color: var(--alex-gold);
}

/* Why Choose Us */
.badge-gold-dot {
    width: 8px;
    height: 8px;
    border-radius: 2px;
    background: var(--alex-gold);
    display: inline-block;
}
.btn-alex-outline-navy {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    border-radius: 50px;
    border: 1.5px solid var(--alex-navy);
    color: var(--alex-navy);
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-alex-outline-navy:hover {
    background: var(--alex-navy);
    color: #ffffff;
    transform: translateY(-2px);
}
.alex-why-card-img {
    height: 130px;
    background-size: cover;
    background-position: center;
}
.alex-why-icon-bubble {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #F1F5F9;
    color: var(--alex-navy);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    margin-top: -19px;
    border: 3px solid #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

/* Spotlight Products */
.alex-spotlight-bg-texture {
    background: radial-gradient(circle at center, rgba(13, 59, 102, 0.4) 0%, rgba(7, 21, 43, 0.95) 100%);
}
.alex-slider-arrow-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}
.alex-slider-arrow-btn:hover {
    background: var(--alex-gold);
    color: #07152B;
    border-color: var(--alex-gold);
}
.alex-spotlight-card {
    transition: all 0.3s ease;
}
.alex-spotlight-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25) !important;
}
.alex-spotlight-plus-btn {
    width: 28px;
    height: 28px;
    background: #F1F5F9;
    color: var(--alex-navy);
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s ease;
}
.alex-spotlight-card:hover .alex-spotlight-plus-btn {
    background: var(--alex-gold);
    color: #07152B;
}

/* Projects & Stats */
.alex-stats-img-wrapper {
    height: 260px;
}
.alex-stat-number {
    font-size: 2.2rem;
    line-height: 1.1;
    color: var(--alex-navy);
}

/* Testimonials */
.alex-testi-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}
.alex-testi-arrow:hover {
    background: var(--alex-gold);
    color: #07152B;
}
.alex-testi-prev { right: 15px; }
.alex-testi-next { left: 15px; }
[dir="ltr"] .alex-testi-prev { right: auto; left: 15px; }
[dir="ltr"] .alex-testi-next { left: auto; right: 15px; }
.alex-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    display: inline-block;
    cursor: pointer;
}
.alex-dot.active {
    background: var(--alex-gold);
    width: 22px;
    border-radius: 4px;
}

/* CTA Banner */
.alex-cta-bg-layer {
    background-size: cover;
    background-position: center;
}
.alex-cta-overlay {
    background: linear-gradient(90deg, rgba(7, 21, 43, 0.95) 0%, rgba(7, 21, 43, 0.8) 100%);
}
.bg-navy-trans {
    background: rgba(7, 21, 43, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.15);
}
</style>
@endpush
