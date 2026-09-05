@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', $isEn ? 'Contact Us — ALEX MARINE' : 'تواصل معنا — أليكس مارين')

@section('content')
<section class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark fs-1 mb-2">{{ $isEn ? 'Contact Us' : 'تواصل معنا' }}</h1>
            <p class="text-muted fs-5">{{ $isEn ? 'Our sales and technical support engineering team is available 24/7' : 'فريق المبيعات والدعم الفني في خدمتكم على مدار الساعة' }}</p>
        </div>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="alex-card p-4 h-100" style="background-color: #0A1D37; color: #ffffff;">
                    <h3 class="fw-bold text-warning mb-4">{{ $isEn ? 'Contact Information' : 'معلومات الاتصال' }}</h3>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-geo-alt-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">{{ $isEn ? 'Headquarters & Port Facility' : 'العنوان والمقر الرئيسي' }}</div>
                            <div class="text-white-50">{{ $isEn ? 'Customs Area, Port of Alexandria, Alexandria, Egypt' : 'المنطقة الجمركية - ميناء الإسكندرية، جمهورية مصر العربية' }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">{{ $isEn ? 'Direct Hotline' : 'الهاتف المباشر' }}</div>
                            <div class="text-white-50" dir="ltr">+20 120 000 1122</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-whatsapp fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">{{ $isEn ? 'WhatsApp Customer Service' : 'خدمة العملاء عبر الواتساب' }}</div>
                            <div class="text-white-50" dir="ltr">+20 120 000 1122</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-primary text-white rounded-3 p-2" style="background-color: #1E6FAE !important;">
                            <i class="bi bi-envelope-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white mb-1">{{ $isEn ? 'Official Email' : 'البريد الإلكتروني' }}</div>
                            <div class="text-white-50">info@alexmarine.eg</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="alex-card p-4">
                    <h3 class="fw-bold text-dark mb-4">{{ $isEn ? 'Send Your Inquiry / RFQ' : 'أرسل استفسارك' }}</h3>
                    <form action="#" method="POST" onsubmit="alert('{{ $isEn ? 'Your inquiry has been received. Our team will contact you shortly.' : 'تم استلام رسالتك وسيتم التواصل معك قريباً' }}'); return false;">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ $isEn ? 'Full Name' : 'الاسم بالكامل' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required placeholder="{{ $isEn ? 'e.g. John Doe' : 'محمد أحمد' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ $isEn ? 'Company / Organization' : 'اسم الشركة / الجهة' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required placeholder="{{ $isEn ? 'e.g. Maritime Navigation Co.' : 'شركة الملاحة' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ $isEn ? 'Email Address' : 'البريد الإلكتروني' }} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" required placeholder="name@company.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ $isEn ? 'Phone / WhatsApp' : 'رقم الهاتف / الواتساب' }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required placeholder="+20 100 000 0000">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">{{ $isEn ? 'Message / Supply Request Details' : 'نص الرسالة أو الاستفسار' }} <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="4" required placeholder="{{ $isEn ? 'Describe your equipment inquiry or supply specifications...' : 'اكتب الاستفسار أو المنتجات المطلوبة هنا...' }}"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-alex-primary btn-lg w-100">
                                    {{ $isEn ? 'Submit Message' : 'إرسال الرسالة' }} <i class="bi bi-send-fill ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
