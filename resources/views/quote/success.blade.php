@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', ($isEn ? 'RFQ Quotation Request Received' : 'تم إرسال طلب عرض السعر') . ' — ' . ($isEn ? 'ALEX MARINE' : 'أليكس مارين'))

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="alex-card p-5 text-center mx-auto" style="max-width: 650px;">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-check-lg fs-1"></i>
            </div>

            <h2 class="fw-bold text-dark mb-2">{{ $isEn ? 'Quotation Request Submitted Successfully!' : 'تم إرسال طلب عرض السعر بنجاح!' }}</h2>
            <p class="text-muted fs-5 mb-4">{{ $isEn ? 'Thank you for contacting ALEX MARINE. Our technical sales department has received your RFQ and is preparing an official quotation for you.' : 'شكراً لتواصلك مع شركة أليكس مارين. قام فريق المبيعات باستلام طلبك وسيتم تجهيز عرض السعر الرسمي التواصل معكم في أقرب وقت.' }}</p>

            <div class="bg-light p-3 rounded-3 border mb-4">
                <div class="text-muted small mb-1">{{ $isEn ? 'Quotation Reference Number (RFQ Number):' : 'الرقم المرجعي لطلب عرض السعر (RFQ Number):' }}</div>
                <div class="h3 fw-bold text-primary m-0" style="letter-spacing: 1px;">{{ $quoteRequest->quote_number }}</div>
            </div>

            <div class="text-start mb-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">{{ $isEn ? 'Request Summary:' : 'تفاصيل الطلب:' }}</h5>
                <ul class="list-unstyled text-secondary small d-flex flex-column gap-2">
                    <li><strong>{{ $isEn ? 'Company:' : 'الشركة:' }}</strong> {{ $quoteRequest->company_name }}</li>
                    <li><strong>{{ $isEn ? 'Contact Person:' : 'المسؤول:' }}</strong> {{ $quoteRequest->customer_name }}</li>
                    <li><strong>{{ $isEn ? 'Email:' : 'البريد الإلكتروني:' }}</strong> {{ $quoteRequest->email }}</li>
                    <li><strong>{{ $isEn ? 'Phone:' : 'الهاتف:' }}</strong> {{ $quoteRequest->phone }}</li>
                    <li><strong>{{ $isEn ? 'Status:' : 'حالة الطلب:' }}</strong> <span class="badge bg-warning text-dark">{{ $quoteRequest->status }}</span></li>
                </ul>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('home') }}" class="btn btn-alex-outline">{{ $isEn ? 'Back to Home' : 'العودة للرئيسية' }}</a>
                <a href="https://wa.me/201200001122?text={{ urlencode(($isEn ? 'Hello, I would like to follow up regarding RFQ quote number: ' : 'مرحباً، أود المتابعة بخصوص طلب عرض السعر رقم: ') . $quoteRequest->quote_number) }}" target="_blank" class="btn btn-success">
                    <i class="bi bi-whatsapp me-1"></i> {{ $isEn ? 'Follow up via WhatsApp' : 'المتابعة عبر الواتساب' }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
