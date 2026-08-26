@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
    $title = $project->title;
    $desc = $project->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($project->description), 160);
    $hasBeforeAfter = !empty($project->before_image) && !empty($project->after_image);
    $beforeUrl = !empty($project->before_image) ? (\Illuminate\Support\Str::startsWith($project->before_image, ['http://', 'https://']) ? $project->before_image : asset($project->before_image)) : $project->main_image_url;
    $afterUrl = !empty($project->after_image) ? (\Illuminate\Support\Str::startsWith($project->after_image, ['http://', 'https://']) ? $project->after_image : asset($project->after_image)) : $project->main_image_url;
@endphp

@section('title', $title . ' — ' . ($isEn ? 'ALEX MARINE Maintenance Cases' : 'حالات ومشاريع الصيانة'))
@section('meta_description', $desc)

@section('content')

<!-- Dark Luxury Theme Scope -->
<div class="project-case-study-page">

    <!-- ════════════════════════════════════════════
         1. PROJECT HEADER & TITLE
    ════════════════════════════════════════════ -->
    <section class="case-header-section pt-5 pb-3">
        <div class="container">
            
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb case-breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">{{ $isEn ? 'Home' : 'الرئيسية' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-white-50 text-decoration-none">{{ $isEn ? 'Our Projects' : 'مشاريع الصيانة' }}</a></li>
                    @if($project->service)
                        <li class="breadcrumb-item"><a href="{{ route('projects.index', ['service' => $project->service->slug]) }}" class="text-warning text-decoration-none">{{ $project->service->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ \Illuminate\Support\Str::limit($title, 40) }}</li>
                </ol>
            </nav>

            <!-- Main Title & Service / Vessel Info -->
            <div class="d-flex flex-column flex-md-row md-align-items-center justify-content-between gap-3">
                <div>
                    <h1 class="case-main-title text-white fw-bold display-5 mb-2">{{ $title }}</h1>
                    <div class="case-subtitle d-flex flex-wrap align-items-center gap-3 text-white-50 fs-6">
                        @if($project->service)
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-30 px-3 py-1.5 rounded-pill fs-7">
                                <i class="bi {{ $project->service->icon ?? 'bi-gear' }} me-1"></i> {{ $project->service->name }}
                            </span>
                        @endif
                        @if($project->location)
                            <span class="d-flex align-items-center gap-1.5"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $project->location }}</span>
                        @endif
                        @if($project->vessel_type)
                            <span class="d-flex align-items-center gap-1.5"><i class="bi bi-shield-check text-warning"></i> {{ $project->vessel_type }}</span>
                        @endif
                        @if($project->duration)
                            <span class="d-flex align-items-center gap-1.5"><i class="bi bi-stopwatch text-warning"></i> {{ $project->duration }}</span>
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="#request-cta" class="btn btn-case-gold rounded-pill px-4 py-2.5 fw-bold shadow-lg d-flex align-items-center gap-2">
                        <i class="bi bi-chat-quote-fill"></i>
                        <span>{{ $isEn ? 'Request Service' : 'طلب صيانة مماثلة' }}</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- ════════════════════════════════════════════
         2. INTERACTIVE BEFORE / AFTER COMPARISON (Replaced Gallery)
    ════════════════════════════════════════════ -->
    <section class="case-before-after-top-section py-4">
        <div class="container">
            
            <div class="text-center mb-3">
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-extrabold tracking-widest text-uppercase fs-8 shadow-sm">
                    <i class="bi bi-sliders me-1"></i> BEFORE / AFTER COMPARISON
                </span>
                <p class="text-white-50 fs-7 mt-2 mb-0">
                    {{ $isEn ? 'Drag the slider handle to inspect the equipment before and after maintenance' : 'اسحب المؤشر لليمين واليسار لمعاينة حالة المعدات قبل وبعد الصيانة والتأهيل' }}
                </p>
            </div>

            <!-- Split-Screen Interactive Comparison Box -->
            <div class="case-slider-wrapper mx-auto rounded-4 overflow-hidden position-relative shadow-2xl border border-secondary border-opacity-30" style="max-width: 1080px; height: 560px;">
                
                <!-- 1. Background Image: AFTER Image (Full Width Underneath) -->
                <img src="{{ $afterUrl }}" alt="After Maintenance" class="case-slider-img position-absolute inset-0 w-100 h-100 object-fit-cover user-select-none">
                
                <!-- AFTER Label Pill (Bottom Right) -->
                <div class="case-pill-badge position-absolute bottom-0 end-0 m-4 badge bg-black bg-opacity-75 text-white border border-secondary border-opacity-50 px-3.5 py-2 rounded-pill fs-7 fw-bold letter-spacing-1 shadow-lg">
                    <i class="bi bi-check2-circle text-success me-1"></i> AFTER
                </div>

                <!-- 2. Foreground Image: BEFORE Image (Clipped by Container Width) -->
                <div id="beforeImageContainer" class="position-absolute inset-y-0 start-0 overflow-hidden" style="width: 50%;">
                    <img src="{{ $beforeUrl }}" alt="Before Maintenance" class="case-slider-img position-absolute top-0 start-0 h-100 object-fit-cover user-select-none" style="width: 1080px; max-width: none;">
                    
                    <!-- BEFORE Label Pill (Bottom Left) -->
                    <div class="case-pill-badge position-absolute bottom-0 start-0 m-4 badge bg-black bg-opacity-75 text-white border border-secondary border-opacity-50 px-3.5 py-2 rounded-pill fs-7 fw-bold letter-spacing-1 shadow-lg">
                        <i class="bi bi-clock-history text-danger me-1"></i> BEFORE
                    </div>
                </div>

                <!-- 3. Drag Handle / Divider Line -->
                <div id="sliderHandle" class="case-slider-handle position-absolute top-0 bottom-0 d-flex align-items-center justify-content-center" style="left: 50%; width: 4px; background: rgba(229, 169, 25, 0.9); cursor: ew-resize; z-index: 20;">
                    <div class="case-handle-circle rounded-circle d-flex align-items-center justify-content-center shadow-2xl" style="width: 46px; height: 46px; background: #0A1D37; border: 2.5px solid #E5A919; color: #E5A919;">
                        <i class="bi bi-arrows fs-5"></i>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ════════════════════════════════════════════
         3. DESCRIPTION SECTION
    ════════════════════════════════════════════ -->
    <section class="case-details-section py-4">
        <div class="container">
            <div class="case-desc-card mx-auto rounded-4 p-4 p-md-5 border border-secondary border-opacity-25" style="max-width: 1080px; background: #101826;">
                
                <h3 class="case-gold-heading fw-bold fs-4 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-file-text-fill text-warning"></i>
                    <span>{{ $isEn ? 'Description & Scope of Work:' : 'تفاصيل ونطاق أعمال الصيانة:' }}</span>
                </h3>
                
                <div class="case-description-text text-light text-opacity-90 fs-6 leading-relaxed mb-0" style="line-height: 1.9; white-space: pre-line;">
                    {{ $project->description ?: ($project->short_desc ?: 'تم تنفيذ أعمال الصيانة والتأهيل الفني بدقة ووفقاً لأعلى معايير السلامة والجودة العالمية.') }}
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════
         4. CALL TO ACTION BANNER (As in reference image)
    ════════════════════════════════════════════ -->
    <section id="request-cta" class="case-cta-section py-4">
        <div class="container">
            <div class="case-cta-box rounded-4 p-5 text-center position-relative overflow-hidden shadow-2xl mx-auto" style="max-width: 1080px; background: linear-gradient(180deg, #101926 0%, #060B12 100%); border: 1px solid rgba(229, 169, 25, 0.3);">
                <div class="position-relative z-1">
                    <h3 class="text-white fw-bold display-6 mb-2">{{ $isEn ? 'Inspired by what you see?' : 'هل ترغب في صيانة أو فحص مماثل؟' }}</h3>
                    <p class="text-white-50 fs-5 mb-4">{{ $isEn ? "Let's bring it to life." : 'دعنا نُعيد معداتك وسفينتك لأعلى كفاءة ومعايير أمان معتمدة.' }}</p>
                    <a href="{{ route('quote.index') }}?service={{ $project->service?->slug ?? '' }}&case={{ $project->slug }}" class="btn btn-case-gold rounded-pill px-5 py-3 fw-extrabold fs-6 shadow-xl text-uppercase letter-spacing-1">
                        {{ $isEn ? 'START YOUR JOURNEY —' : 'ابدأ رحلتك معنا — طلب عرض سعر' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════
         5. RELATED PROJECTS
    ════════════════════════════════════════════ -->
    @if(isset($relatedProjects) && count($relatedProjects) > 0)
    <section class="case-related-section py-5" style="background: #090E17;">
        <div class="container" style="max-width: 1080px;">
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom border-secondary border-opacity-25 pb-3">
                <h4 class="text-white fw-bold m-0">{{ $isEn ? 'Explore Other Case Studies' : 'مشاريع ودراسات حالة أخرى' }}</h4>
                <a href="{{ route('projects.index') }}" class="text-warning text-decoration-none fw-bold fs-7 hover-underline">
                    {{ $isEn ? 'View All Projects →' : 'عرض كافة المشاريع ←' }}
                </a>
            </div>

            <div class="row g-4">
                @foreach($relatedProjects as $relProj)
                    <div class="col-md-4">
                        <a href="{{ route('projects.show', $relProj->slug) }}" class="card case-card-mini h-100 text-decoration-none rounded-4 overflow-hidden border border-secondary border-opacity-25 bg-dark">
                            <div class="position-relative overflow-hidden" style="height: 200px;">
                                <img src="{{ $relProj->after_image ? (\Illuminate\Support\Str::startsWith($relProj->after_image, ['http://', 'https://']) ? $relProj->after_image : asset($relProj->after_image)) : $relProj->main_image_url }}" alt="{{ $relProj->title }}" class="w-100 h-100 object-fit-cover transition-transform">
                                <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark px-2 py-1 rounded-pill fs-9 fw-bold">Before / After</span>
                            </div>
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="text-white fw-bold mb-1 line-clamp-2">{{ $relProj->title }}</h6>
                                    <p class="text-white-50 fs-8 line-clamp-2 m-0">{{ $relProj->short_desc }}</p>
                                </div>
                                <div class="mt-2 pt-2 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between text-warning fs-8 fw-bold">
                                    <span>{{ $isEn ? 'View Case' : 'معاينة المقارنة' }}</span>
                                    <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }}"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</div>

<!-- ════════════════════════════════════════════
     CUSTOM CSS FOR DARK LUXURY AESTHETIC
════════════════════════════════════════════ -->
<style>
.project-case-study-page {
    background-color: #121822;
    color: #F0F4F8;
    font-family: 'Cairo', 'Tajawal', sans-serif;
    min-height: 100vh;
}
.font-inter .project-case-study-page {
    font-family: 'Inter', sans-serif;
}

.case-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.35);
}

.case-main-title {
    color: #FFFFFF;
    letter-spacing: -0.5px;
}
.case-gold-heading {
    color: #E5A919;
    font-weight: 700;
}

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

/* Slider Style */
.case-slider-wrapper {
    touch-action: none;
    user-select: none;
    background-color: #080D14;
}
.case-handle-circle {
    transition: transform 0.15s ease;
}
.case-slider-handle:hover .case-handle-circle,
.case-slider-handle:active .case-handle-circle {
    transform: scale(1.15);
    box-shadow: 0 0 24px rgba(229, 169, 25, 0.9);
}

.case-card-mini {
    transition: all 0.3s ease;
}
.case-card-mini:hover {
    transform: translateY(-4px);
    border-color: rgba(229, 169, 25, 0.5) !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.5);
}
.case-card-mini:hover img {
    transform: scale(1.06);
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

@media (max-width: 768px) {
    .case-slider-wrapper {
        height: 320px !important;
    }
    .case-slider-img {
        width: 100% !important;
    }
    #beforeImageContainer img {
        width: 100vw !important;
    }
}
</style>

<!-- ════════════════════════════════════════════
     JAVASCRIPT: BEFORE/AFTER SLIDER
════════════════════════════════════════════ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.querySelector('.case-slider-wrapper');
    const beforeContainer = document.getElementById('beforeImageContainer');
    const handle = document.getElementById('sliderHandle');

    if (!wrapper || !beforeContainer || !handle) return;

    let isDragging = false;

    function updateSlider(clientX) {
        const rect = wrapper.getBoundingClientRect();
        let posX = clientX - rect.left;
        if (posX < 0) posX = 0;
        if (posX > rect.width) posX = rect.width;

        const percentage = (posX / rect.width) * 100;
        beforeContainer.style.width = percentage + '%';
        handle.style.left = percentage + '%';
    }

    // Mouse Events
    wrapper.addEventListener('mousedown', function(e) {
        isDragging = true;
        updateSlider(e.clientX);
    });

    window.addEventListener('mouseup', function() {
        isDragging = false;
    });

    window.addEventListener('mousemove', function(e) {
        if (!isDragging) return;
        updateSlider(e.clientX);
    });

    // Touch Events for Mobile
    wrapper.addEventListener('touchstart', function(e) {
        isDragging = true;
        if (e.touches.length > 0) {
            updateSlider(e.touches[0].clientX);
        }
    }, { passive: true });

    window.addEventListener('touchend', function() {
        isDragging = false;
    });

    window.addEventListener('touchmove', function(e) {
        if (!isDragging || e.touches.length === 0) return;
        updateSlider(e.touches[0].clientX);
    }, { passive: true });

    function syncBeforeImageWidth() {
        const beforeImg = beforeContainer.querySelector('img');
        if (beforeImg) {
            beforeImg.style.width = wrapper.offsetWidth + 'px';
        }
    }
    syncBeforeImageWidth();
    window.addEventListener('resize', syncBeforeImageWidth);
});
</script>

@endsection
