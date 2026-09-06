@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', ($isEn ? 'Create Client Account' : 'إنشاء حساب جديد') . ' — ' . ($isEn ? 'ALEX MARINE' : 'أليكس مارين'))

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="alex-card p-4 mx-auto" style="max-width: 520px;">
            <div class="text-center mb-4">
                @php
                    $headerLogoSrc = !empty($siteHeaderLogo) ? (\Illuminate\Support\Str::startsWith($siteHeaderLogo, ['http://', 'https://']) ? $siteHeaderLogo : asset($siteHeaderLogo)) : asset('uploads/Alex-marin.svg');
                @endphp
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center justify-content-center mb-3 text-decoration-none">
                    <img src="{{ $headerLogoSrc }}" alt="ALEX MARINE" style="max-height: 58px; width: auto; object-fit: contain;"
                         onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none'); this.nextElementSibling.classList.add('d-flex');">
                    <div class="d-none align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width:44px;height:44px;background:var(--alex-navy-dark);">
                            <i class="bi bi-anchor fs-4" style="color:var(--alex-gold);"></i>
                        </div>
                        <div class="text-start">
                            <div class="navbar-brand-title fw-bold" style="color:var(--alex-navy-dark); font-size:1.2rem;">ALEX MARINE</div>
                            <div class="navbar-brand-subtitle text-muted" style="font-size:0.75rem;">{{ $isEn ? 'Marine Supplies' : 'للتوريدات البحرية' }}</div>
                        </div>
                    </div>
                </a>
                <h3 class="fw-bold text-dark mt-1">{{ $isEn ? 'Corporate Client Registration' : 'حساب جديد للشركات والعملاء' }}</h3>
                <p class="text-muted small">{{ $isEn ? 'Register to manage RFQ quotations, download certified specs, and track delivery status.' : 'قم بالتسجيل لمتابعة طلبات عروض الأسعار السابقة وحالة التوريد' }}</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">{{ $isEn ? 'Full Name' : 'الاسم بالكامل' }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="{{ $isEn ? 'e.g. John Doe' : 'أدخل اسمك بالكامل' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">{{ $isEn ? 'Company / Organization' : 'اسم الشركة / الجهة' }} <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control" required value="{{ old('company_name') }}" placeholder="{{ $isEn ? 'e.g. National Maritime Corp.' : 'شركة الملاحة الوطنية' }}">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ $isEn ? 'Email' : 'البريد الإلكتروني' }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="name@company.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ $isEn ? 'Phone / WhatsApp' : 'رقم الهاتف / الواتساب' }} <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}" placeholder="+20 100 000 0000">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ $isEn ? 'Password' : 'كلمة المرور' }} <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ $isEn ? 'Confirm Password' : 'تأكيد كلمة المرور' }} <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn btn-alex-gold w-100 btn-lg mb-3">{{ $isEn ? 'Create Account' : 'إنشاء الحساب' }}</button>

                <div class="text-center small text-muted">
                    {{ $isEn ? 'Already have an account?' : 'لديك حساب بالفعل؟' }} <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">{{ $isEn ? 'Sign In' : 'تسجيل الدخول' }}</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
