@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', $isEn ? 'About Us — ALEX MARINE' : 'عن الشركة — أليكس مارين')
@section('meta_description', $isEn ? 'ALEX MARINE is an Egyptian company specialized in commercial marine supplies, industrial safety PPE, and fire fighting equipment.' : 'شركة أليكس مارين متخصصة في التوريدات البحرية ومهمات الأمن الصناعي والسلامة المهنية وصيانة معدات الإطفاء.')

@section('content')

{{-- ═══════════════════════════════════════════════
     ABOUT HERO (SOLID NAVY CORPORATE)
═══════════════════════════════════════════════ --}}
<section class="about-hero">
    <div class="container">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-alex">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-white-50">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">
                    {{ $isEn ? 'About Us' : 'من نحن' }}
                </li>
            </ol>
        </nav>

        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-up">
             
                <h1 class="display-hero text-white mb-3">
                    {{ $isEn ? 'ALEX MARINE Supplies & Safety' : 'شركة أليكس مارين للتوريدات والأمن الصناعي' }}
                </h1>
                <p class="fs-5 text-white-50 mb-0" style="max-width: 620px; line-height: 1.7;">
                    {{ $isEn
                        ? 'Egypt\'s trusted partner for commercial marine logistics, industrial safety PPE, and firefighting equipment certified to international SOLAS and ISO standards.'
                        : 'شريكك الموثوق في مصر للتوريدات البحرية ومهمات الأمن الصناعي وصيانة معدات الإطفاء والسلامة المهنية وفق أحدث معايير الجودة الدولية.' }}
                </p>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     COMPANY STORY & OVERVIEW
═══════════════════════════════════════════════ --}}
<section class="section-py" style="background:#ffffff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-up">
              
                <h2 class="display-section mt-2 mb-3">
                    {{ $isEn ? 'Commercial Marine & Industrial Supplies' : 'توريدات بحرية ومهمات أمن صناعي معتمدة' }}
                </h2>
                <p class="text-muted mb-3" style="line-height:1.75;">
                    {{ $isEn
                        ? 'ALEX MARINE is an Egyptian enterprise established in Alexandria to deliver integrated supply solutions for shipping agencies, vessels, marine contractors, and industrial plants across Egypt and the Mediterranean basin.'
                        : 'شركة أليكس مارين هي شركة مصرية مقرها الإسكندرية، متخصصة في توفير حلول التوريد المتكاملة لشركات الملاحة، السفن التجارية، التوكيلات الملاحية، والمصانع والمنشآت البترولية والصناعية في مصر.' }}
                </p>
                <p class="text-muted mb-4" style="line-height:1.75;">
                    {{ $isEn
                        ? 'We maintain full compliance with international maritime requirements including SOLAS Chapter II & III, MED directives, and ISO quality guidelines. In addition to supply, we operate technical inspection and maintenance services for firefighting gear and breathing apparatus.'
                        : 'نلتزم بالمعايير والمتطلبات البحرية الدولية مثل معايير SOLAS وشهادات الاتحاد الأوروبي MED وتوجيهات ISO. كما نوفر خدمات المعايرة والفحص الفني واختبارات الضغط لأجهزة التنفس ومعدات الإطفاء.' }}
                </p>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn-alex-primary">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        {{ $isEn ? 'View Products' : 'تصفح المنتجات' }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn-alex-outline">
                        {{ $isEn ? 'Contact Technical Team' : 'تواصل مع الفريق الفني' }}
                    </a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="80">
                <div class="alex-card overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=900&q=80"
                         alt="Alex Marine Operations"
                         style="width:100%; height:380px; object-fit:cover;">
                    <div class="p-3 bg-light border-top d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-dark fs-7">
                            <i class="bi bi-geo-alt-fill text-warning me-1"></i>
                            {{ $isEn ? 'Alexandria Port Operations' : 'عمليات ميناء الإسكندرية والمناطق الجمركية' }}
                        </span>
                        <span class="badge bg-navy-dark text-white px-2.5 py-1.5" style="background:var(--alex-navy-dark);">SOLAS Certified</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════
     OUR CORE VALUES
═══════════════════════════════════════════════ --}}
<section class="section-py" style="background:var(--alex-light-bg);">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
         
            <h2>{{ $isEn ? 'Quality & Reliability Commitment' : 'التزامنا بالجودة والموثوقية' }}</h2>
            <div class="section-divider"></div>
            <p>{{ $isEn ? 'Standard operational pillars governing our supply chain, customer service, and technical inspections.' : 'ركائز العمل التي تحكم عمليات التوريد وخدمة العملاء والفحص الفني.' }}</p>
        </div>

        <div class="row g-4">
            @php
            $values = [
                ['bi-shield-check', $isEn ? 'Strict Safety Compliance' : 'السلامة والامتثال التام', $isEn ? 'Every safety product supplied is verified against certified international standards.' : 'جميع مهمات السلامة ومعدات الإنقاذ مطابقة للمعايير والشهادات الدولية المعتمدة.'],
                ['bi-truck', $isEn ? 'Emergency Port Delivery' : 'سرعة التوريد للأرصفة', $isEn ? 'Immediate response and direct delivery to Egyptian ports and customs zones.' : 'استجابة سريعة وتوصيل فوري مباشر لكافة الموانئ والمناطق الجمركية والمصانع.'],
                ['bi-patch-check', $isEn ? 'Quality Sourced Goods' : 'جودة المواد والمصادر', $isEn ? 'Direct cooperation with verified manufacturers of marine and safety equipment.' : 'توريد من مصنعين معتمدين مباشرة لضمان أعلى أداء وعمر تشغيلي.'],
                ['bi-file-earmark-ruled', $isEn ? 'Documented Pricing' : 'تسعير رسمي شفاف', $isEn ? 'Detailed technical specifications and itemized official quotation sheets.' : 'عروض أسعار رسمية مفصلة مع شهادات المطابقة والبيانات الفنية.'],
                ['bi-tools', $isEn ? 'Technical Maintenance' : 'فحص وصيانة معتمدة', $isEn ? 'Certified hydrostatic testing, SCBA inspection, and fire extinguisher maintenance.' : 'اختبارات الضغط الهيدروستاتيكي، صيانة أجهزة التنفس، وتعبئة الطفايات.'],
                ['bi-headset', $isEn ? 'Dedicated Support' : 'دعم فني متخصص', $isEn ? 'Experienced marine technical advisors ready to assist with procurement orders.' : 'فريق متخصص في المشتريات البحرية والأمن الصناعي للرد على استفساراتكم.'],
            ];
            @endphp

            @foreach($values as $i => [$icon, $title, $desc])
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 60 }}">
                <div class="value-card">
                    <div class="value-icon-wrap">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <h5 class="value-title">{{ $title }}</h5>
                    <p class="value-desc">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



{{-- ═══════════════════════════════════════════════
     CTA BOTTOM
═══════════════════════════════════════════════ --}}
<section class="cta-section">
    <div class="container text-center" data-aos="fade-up">
        <h2 class="cta-title">
            {{ $isEn ? 'Need Marine Supplies or Safety Gear?' : 'هل تبحث عن توريدات بحرية أو مهمات سلامة؟' }}
        </h2>
        <p class="cta-desc mx-auto mb-4">
            {{ $isEn
                ? 'Contact our procurement and technical team today to request quotation sheets or discuss vessel requirements.'
                : 'تواصل مع فريق المبيعات والفحص الفني لطلب عروض الأسعار الرسمية أو ترتيب التوريد لسفينتك أو موقعك.' }}
        </p>
        <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
            <a href="{{ route('contact') }}" class="btn-alex-gold px-4 py-2.5">
                <i class="bi bi-telephone-fill"></i>
                {{ $isEn ? 'Contact Us' : 'تواصل معنا' }}
            </a>
            <a href="{{ route('quote.index') }}" class="btn-alex-outline-white px-4 py-2.5">
                <i class="bi bi-file-earmark-plus"></i>
                {{ $isEn ? 'Request a Quote' : 'اطلب عرض سعر' }}
            </a>
        </div>
    </div>
</section>

@endsection
