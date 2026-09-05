@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', $isEn ? 'Technical Services & Marine Maintenance — ALEX MARINE' : 'الخدمات والصيانة الفنية — أليكس مارين')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold text-dark fs-1 mb-3">{{ $isEn ? 'Technical Services & Marine Maintenance' : 'الخدمات والصيانة الفنية' }}</h1>
        <p class="text-muted fs-5 mx-auto" style="max-width: 700px;">
            {{ $isEn
                ? 'We provide certified inspection, hydrostatic testing, calibration, and maintenance for marine fire systems, SCBA breathing apparatus, and life safety equipment with international compliance certificates.'
                : 'نقدم خدمات صيانة، معايرة، واختبار كفاءة لمعدات الإطفاء وأجهزة التنفس ومعدات الإنقاذ مع إصدار شهادات صلاحية معتمدة.' }}
        </p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-lg-6">
                    <div class="alex-card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background-color: #0A1D37 !important;">
                                    <i class="bi {{ $service->icon ?: 'bi-wrench' }} fs-2"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold text-dark fs-4 m-0">{{ $isEn ? ($service->name_en ?: $service->name_ar) : $service->name_ar }}</h3>
                                    <small class="text-muted">{{ $isEn ? $service->name_ar : $service->name_en }}</small>
                                </div>
                            </div>
                            <p class="text-secondary leading-relaxed mb-3 fs-6">
                                {{ $isEn ? ($service->short_desc_en ?: $service->short_desc_ar) : $service->short_desc_ar }}
                            </p>

                            @if(!empty($service->features))
                                <ul class="list-unstyled mb-4">
                                    @foreach($service->features as $feature)
                                        <li class="mb-2 text-dark font-medium"><i class="bi bi-check-circle-fill text-primary me-2"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-alex-primary">
                                <span>{{ $isEn ? 'Service Details & Inquiry' : 'تفاصيل الخدمة وطرق الطلب' }}</span>
                                <i class="bi bi-arrow-{{ $isEn ? 'right' : 'left' }} ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
