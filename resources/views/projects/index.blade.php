@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', ($isEn ? 'Our Maintenance Projects & Case Studies' : 'مشاريع الصيانة البحرية ودراسات الحالة') . ' — ALEX MARINE')
@section('meta_description', $isEn ? 'Explore Alex Marine certified marine maintenance projects, CO2 suppression overhauls, SCBA inspections, and rescue equipment refurbishment.' : 'استعرض أحدث مشروعات ودراسات حالة الصيانة البحرية لشركة أليكس مارين، فحص أنظمة الإطفاء، أجهزة التنفس، وطوافات الإنقاذ.')

@section('content')

<div class="projects-index-page" style="background-color: #121822; color: #F0F4F8; min-height: 100vh;">

    <!-- ════════════════════════════════════════════
         1. HERO HEADER BANNER
    ════════════════════════════════════════════ -->
    <section class="py-5 text-center position-relative overflow-hidden" style="background: linear-gradient(180deg, #0A1D37 0%, #121822 100%); border-bottom: 1px solid rgba(229, 169, 25, 0.2);">
        <div class="container py-4 position-relative z-1">
            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3.5 py-2 rounded-pill fw-bold fs-7 mb-3 text-uppercase tracking-widest">
                <i class="bi bi-patch-check-fill me-1"></i> {{ $isEn ? 'Proven Track Record & Marine Case Studies' : 'سجل إنجازات وتوثيق لمشاريع الصيانة البحرية' }}
            </span>
            <h1 class="display-4 fw-extrabold text-white mb-3 tracking-tight">
                {{ $isEn ? 'Our Maintenance Projects' : 'مشاريعنا وحالات الصيانة' }}
            </h1>
            <p class="text-white-50 fs-5 mx-auto mb-0" style="max-width: 720px; line-height: 1.7;">
                {{ $isEn ? 'Explore how Alex Marine inspects, tests, and certifies mission-critical safety systems, life rafts, and marine equipment according to international SOLAS standards.' : 'استعرض كيف تقوم فرق أليكس مارين الهندسية بفحص وإعادة تأهيل واعتماد أنظمة السلامة والإطفاء ومعدات الإنقاذ البحري بأعلى معايير الجودة العالمية.' }}
            </p>
        </div>
    </section>

    <!-- ════════════════════════════════════════════
         2. SERVICE FILTER TABS
    ════════════════════════════════════════════ -->
    <section class="py-4 border-bottom border-secondary border-opacity-25" style="background: #0E141D;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                <a href="{{ route('projects.index') }}" class="btn {{ empty($serviceSlug) ? 'btn-gold-active' : 'btn-dark-filter' }} rounded-pill px-4 py-2 fs-7 fw-bold transition-all">
                    <i class="bi bi-grid-fill me-1"></i> {{ $isEn ? 'All Projects' : 'جميع المشاريع' }}
                </a>
                @foreach($services as $s)
                    <a href="{{ route('projects.index', ['service' => $s->slug]) }}" class="btn {{ $serviceSlug === $s->slug ? 'btn-gold-active' : 'btn-dark-filter' }} rounded-pill px-4 py-2 fs-7 fw-bold transition-all">
                        <i class="bi {{ $s->icon ?? 'bi-gear' }} me-1"></i> {{ $s->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════════
         3. PROJECTS GRID
    ════════════════════════════════════════════ -->
    <section class="py-5">
        <div class="container py-2">
            
            <div class="row g-4">
                @forelse($projects as $proj)
                    @php
                        $projTitle = $proj->title;
                        $hasBA = $proj->has_before_after;
                    @endphp
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 60 }}">
                        <div class="card h-100 border border-secondary border-opacity-25 rounded-4 overflow-hidden shadow-lg project-card-hover" style="background: #161E2C;">
                            
                            <!-- Cover Image & Badges -->
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img src="{{ $proj->main_image_url }}" alt="{{ $projTitle }}" class="w-100 h-100 object-fit-cover transition-transform">
                                <div class="position-absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                                
                                @if($proj->service)
                                    <span class="position-absolute top-0 start-0 m-3 badge bg-black bg-opacity-75 text-warning border border-warning border-opacity-50 px-3 py-1.5 rounded-pill fs-8">
                                        <i class="bi {{ $proj->service->icon ?? 'bi-gear' }} me-1"></i> {{ $proj->service->name }}
                                    </span>
                                @endif

                                @if($hasBA)
                                    <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark px-2.5 py-1.5 rounded-pill fs-9 fw-bold shadow-sm">
                                        <i class="bi bi-sliders me-1"></i> Before / After
                                    </span>
                                @endif

                                @if($proj->video_url)
                                    <span class="position-absolute bottom-0 end-0 m-3 badge bg-danger text-white px-2.5 py-1 rounded-pill fs-9 shadow-sm">
                                        <i class="bi bi-play-fill me-1"></i> Video
                                    </span>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <!-- Vessel & Location -->
                                    <div class="d-flex align-items-center justify-content-between text-white-50 fs-8 mb-2 pb-2 border-bottom border-secondary border-opacity-25">
                                        @if($proj->location)
                                            <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> {{ $proj->location }}</span>
                                        @endif
                                        @if($proj->duration)
                                            <span><i class="bi bi-stopwatch text-warning me-1"></i> {{ $proj->duration }}</span>
                                        @endif
                                    </div>

                                    <!-- Title -->
                                    <h5 class="fw-bold text-white mb-2 leading-snug">
                                        <a href="{{ route('projects.show', $proj->slug) }}" class="text-white text-decoration-none hover-gold transition-colors">
                                            {{ $projTitle }}
                                        </a>
                                    </h5>

                                    <!-- Short Description -->
                                    <p class="text-white-50 fs-7 line-clamp-3 mb-0" style="line-height: 1.6;">
                                        {{ $proj->short_desc ?: \Illuminate\Support\Str::limit(strip_tags($proj->description), 130) }}
                                    </p>
                                </div>

                                <!-- Card Footer CTA -->
                                <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
                                    <a href="{{ route('projects.show', $proj->slug) }}" class="btn btn-outline-warning btn-sm rounded-pill px-3.5 py-1.5 fw-bold fs-7 d-flex align-items-center gap-1.5 hover-glow">
                                        <span>{{ $isEn ? 'View Case Study' : 'عرض دراسة الحالة' }}</span>
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
                    <div class="col-12 py-5 text-center">
                        <div class="p-5 rounded-4 border border-secondary border-opacity-25 mx-auto" style="max-width: 600px; background: #161E2C;">
                            <i class="bi bi-tools fs-1 text-warning d-block mb-3 opacity-75"></i>
                            <h4 class="text-white fw-bold">{{ $isEn ? 'No maintenance projects found in this category' : 'لا توجد مشاريع في هذا القسم حالياً' }}</h4>
                            <p class="text-white-50 fs-7 mt-2">{{ $isEn ? 'Check back soon or browse all our projects.' : 'يمكنك تصفح جميع المشاريع المتاحة أو التواصل معنا لطلب صيانة مخصصة.' }}</p>
                            <a href="{{ route('projects.index') }}" class="btn btn-case-gold rounded-pill px-4 py-2 mt-3 fw-bold">
                                {{ $isEn ? 'View All Projects' : 'عرض كافة المشاريع' }}
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($projects->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $projects->links() }}
                </div>
            @endif

        </div>
    </section>

    <!-- ════════════════════════════════════════════
         4. BOTTOM CTA BANNER
    ════════════════════════════════════════════ -->
    <section class="py-5" style="background: linear-gradient(180deg, #121822 0%, #080E17 100%); border-top: 1px solid rgba(229, 169, 25, 0.2);">
        <div class="container text-center py-3">
            <h2 class="text-white fw-bold display-6 mb-2">{{ $isEn ? 'Ready to Overhaul or Recertify Your Marine Systems?' : 'هل ترغب في صيانة أو اعتماد معدات سفينتك؟' }}</h2>
            <p class="text-white-50 fs-5 mb-4 mx-auto" style="max-width: 650px;">
                {{ $isEn ? 'Contact our certified marine safety engineers today for a swift inspection and proposal.' : 'تواصل مع فريق المهندسين المعتمدين بشركة أليكس مارين للحصول على فحص سريع وعرض سعر فني معتمد.' }}
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('quote.index') }}" class="btn btn-case-gold rounded-pill px-5 py-3 fw-bold fs-6 shadow-lg">
                    <i class="bi bi-file-earmark-text me-1"></i> {{ $isEn ? 'Request a Quote' : 'طلب عرض سعر صيانة' }}
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold fs-6">
                    <i class="bi bi-telephone-fill me-1 text-warning"></i> {{ $isEn ? 'Contact Support' : 'تواصل مع الدعم الفني' }}
                </a>
            </div>
        </div>
    </section>

</div>

<style>
.btn-gold-active {
    background: linear-gradient(135deg, #FAD961 0%, #F7B731 35%, #D49B23 70%, #B37D14 100%) !important;
    color: #061325 !important;
    border: none;
    box-shadow: 0 4px 14px rgba(229, 169, 25, 0.4);
}
.btn-dark-filter {
    background: #161E2C;
    color: #cbd5e1;
    border: 1px solid rgba(255, 255, 255, 0.12);
}
.btn-dark-filter:hover {
    background: #1E293B;
    color: #FFFFFF;
    border-color: #E5A919;
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
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

@endsection
