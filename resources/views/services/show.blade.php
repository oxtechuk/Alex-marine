@extends('layouts.app')

@section('title', $service->name_ar . ' — أليكس مارين')

@section('content')
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <h1 class="fw-bold text-dark fs-2 mb-2">{{ $service->name_ar }}</h1>
        <p class="text-muted m-0">{{ $service->name_en }}</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="alex-card p-4 mb-4">
                    <h3 class="fw-bold text-dark fs-4 mb-3">تفاصيل الخدمة والشروط الفنية</h3>
                    <p class="text-secondary leading-relaxed fs-6 mb-4">
                        {{ $service->full_desc_ar ?: $service->short_desc_ar }}
                    </p>

                    @if(!empty($service->features))
                        <h4 class="fw-bold text-dark fs-5 mb-3">مميزات وخطوات الخدمة:</h4>
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
                </div>
            </div>

            <div class="col-lg-4">
                <div class="alex-card p-4" style="background-color: #0A1D37; color: #ffffff;">
                    <h4 class="fw-bold text-warning mb-3">طلب خدمة صيانة / معايرة</h4>
                    <p class="text-white-50 small mb-4">تواصل مباشرة مع المهندس المسؤول لتحديد موعد المعاينة أو إرسال المعدات الفنية.</p>
                    
                    <a href="https://wa.me/201200001122?text={{ urlencode('مرحباً، أود الاستفسار عن خدمة: ' . $service->name_ar) }}" target="_blank" class="btn btn-success w-100 btn-lg mb-3">
                        <i class="bi bi-whatsapp me-2"></i> طلب الخدمة عبر الواتساب
                    </a>

                    <a href="{{ route('contact') }}" class="btn btn-outline-light w-100 btn-lg">
                        <i class="bi bi-envelope me-2"></i> إرسال طلب رسمي
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
