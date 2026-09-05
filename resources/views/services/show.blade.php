@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
    $serviceTitle = $isEn ? ($service->name_en ?: $service->name_ar) : $service->name_ar;
@endphp

@section('title', $serviceTitle . ' — ' . ($isEn ? 'ALEX MARINE' : 'أليكس مارين'))

@section('content')
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <h1 class="fw-bold text-dark fs-2 mb-2">{{ $serviceTitle }}</h1>
        <p class="text-muted m-0">{{ $isEn ? $service->name_ar : $service->name_en }}</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="alex-card p-4 mb-4">
                    <h3 class="fw-bold text-dark fs-4 mb-3">{{ $isEn ? 'Service Scope & Technical Specifications' : 'تفاصيل الخدمة والشروط الفنية' }}</h3>
                    <p class="text-secondary leading-relaxed fs-6 mb-4">
                        {{ $isEn ? ($service->full_desc_en ?: ($service->short_desc_en ?: ($service->full_desc_ar ?: $service->short_desc_ar))) : ($service->full_desc_ar ?: $service->short_desc_ar) }}
                    </p>

                    @if(!empty($service->features))
                        <h4 class="fw-bold text-dark fs-5 mb-3">{{ $isEn ? 'Service Capabilities & Procedures:' : 'مميزات وخطوات الخدمة:' }}</h4>
                        <div class="row g-3 mb-4">
                            @foreach($service->features as $feature)
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded-3 border d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill text-primary fs-5"></i>
                                        <span class="fw-semibold text-dark">{{ $feature }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if($service->maintenanceProjects && $service->maintenanceProjects->count() > 0)
                        <div class="mt-5 pt-4 border-top">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h4 class="fw-bold text-dark fs-5 m-0"><i class="bi bi-tools text-warning me-2"></i>{{ $isEn ? 'Completed Maintenance Projects for this Service' : 'مشاريع وحالات صيانة منفذة لهذه الخدمة' }}</h4>
                                <a href="{{ route('projects.index', ['service' => $service->slug]) }}" class="text-primary fw-bold fs-7 text-decoration-none">
                                    <span>{{ $isEn ? 'View All' : 'عرض الكل' }}</span>
                                    <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
                                </a>
                            </div>
                            <div class="row g-3">
                                @foreach($service->maintenanceProjects as $mProj)
                                    @php
                                        $projTitle = $isEn ? ($mProj->title_en ?: $mProj->title_ar) : $mProj->title_ar;
                                        $projLocation = $isEn ? ($mProj->location_en ?: $mProj->location_ar) : $mProj->location_ar;
                                    @endphp
                                    <div class="col-md-6">
                                        <a href="{{ route('projects.show', $mProj->slug) }}" class="card border rounded-3 overflow-hidden text-decoration-none h-100 shadow-sm hover-shadow transition-all">
                                            <div style="height: 140px;" class="position-relative">
                                                <img src="{{ $mProj->main_image_url }}" alt="{{ $projTitle }}" class="w-100 h-100 object-fit-cover">
                                                @if(!empty($mProj->before_image) && !empty($mProj->after_image))
                                                    <span class="badge bg-dark bg-opacity-75 text-warning position-absolute bottom-0 start-0 m-2 fs-9">Before / After</span>
                                                @endif
                                            </div>
                                            <div class="p-3 bg-white">
                                                <h6 class="fw-bold text-dark fs-7 mb-1 line-clamp-2">{{ $projTitle }}</h6>
                                                <span class="text-muted fs-8"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $projLocation }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="alex-card p-4" style="background-color: #0A1D37; color: #ffffff;">
                    <h4 class="fw-bold text-warning mb-3">{{ $isEn ? 'Request Service / Inspection' : 'طلب خدمة صيانة / معايرة' }}</h4>
                    <p class="text-white-50 small mb-4">{{ $isEn ? 'Contact our technical engineers directly for inspection schedule, workshop intake, or emergency servicing.' : 'تواصل مباشرة مع المهندس المسؤول لتحديد موعد المعاينة أو إرسال المعدات الفنية.' }}</p>
                    
                    <a href="https://wa.me/201200001122?text={{ urlencode(($isEn ? 'Hello, I would like to inquire about the service: ' : 'مرحباً، أود الاستفسار عن خدمة: ') . $serviceTitle) }}" target="_blank" class="btn btn-success w-100 btn-lg mb-3">
                        <i class="bi bi-whatsapp me-2"></i> {{ $isEn ? 'Inquire via WhatsApp' : 'طلب الخدمة عبر الواتساب' }}
                    </a>

                    <a href="{{ route('quote.index') }}?service={{ $service->slug }}" class="btn btn-warning w-100 btn-lg mb-3 fw-bold text-dark">
                        <i class="bi bi-file-earmark-text me-2"></i> {{ $isEn ? 'Request Technical RFQ' : 'طلب عرض سعر فني (RFQ)' }}
                    </a>

                    <a href="{{ route('contact') }}" class="btn btn-outline-light w-100 btn-lg">
                        <i class="bi bi-envelope me-2"></i> {{ $isEn ? 'Send Formal Inquiry' : 'إرسال طلب رسمي' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
