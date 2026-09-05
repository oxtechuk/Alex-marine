@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', ($isEn ? 'Client Portal Login' : 'تسجيل الدخول') . ' — ' . ($isEn ? 'ALEX MARINE' : 'أليكس مارين'))

@section('content')
<section class="py-5 bg-light min-vh-75 d-flex align-items-center">
    <div class="container">
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 mx-auto bg-white" style="max-width: 480px;">
            <div class="text-center mb-4">
                @php
                    $logoSrc = !empty($siteHeaderLogo) ? (\Illuminate\Support\Str::startsWith($siteHeaderLogo, ['http://', 'https://']) ? $siteHeaderLogo : asset($siteHeaderLogo)) : asset('uploads/Alex-marin.svg');
                @endphp
                <a href="{{ route('home') }}" class="d-inline-block mb-3 text-decoration-none">
                    <img src="{{ $logoSrc }}" alt="ALEX MARINE" style="max-height: 52px; width: auto; object-fit: contain;"
                         onerror="this.style.display='none'; this.nextElementSibling.classList.remove('d-none'); this.nextElementSibling.classList.add('d-inline-flex');">
                    <div class="d-none rounded-4 align-items-center justify-content-center p-3" style="background-color: #0A192F; width: 64px; height: 64px;">
                        <i class="bi bi-anchor fs-2" style="color: #D4AF37;"></i>
                    </div>
                </a>
                <h3 class="fw-extrabold text-navy mb-1" style="color: #0A192F;">{{ $isEn ? 'Account Login' : 'تسجيل الدخول' }}</h3>
                <p class="text-muted fs-7 mb-0">{{ $isEn ? 'Enter your credentials to access the ALEX MARINE portal' : 'أدخل بيانات حسابك للمتابعة في بوابة أليكس مارين' }}</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <ul class="m-0 ps-3 list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">{{ $isEn ? 'Email Address' : 'البريد الإلكتروني' }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" id="loginEmail" class="form-control border-start-0" required value="{{ old('email', 'admin@alexmarine.com') }}" placeholder="admin@alexmarine.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-navy fs-7">{{ $isEn ? 'Password' : 'كلمة المرور' }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="password" id="loginPassword" class="form-control border-start-0" required value="password" placeholder="••••••••">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember" checked>
                        <label class="form-check-label fs-7 text-muted" for="remember">{{ $isEn ? 'Remember me' : 'تذكر بيانات دخولي' }}</label>
                    </div>
                </div>

                <button type="submit" class="btn w-100 btn-lg rounded-pill fw-bold text-white shadow-sm mb-3" style="background: linear-gradient(135deg, #0A192F 0%, #162E4E 100%); border: 1px solid #D4AF37;">
                    <i class="bi bi-box-arrow-in-right me-2" style="color: #D4AF37;"></i> {{ $isEn ? 'Sign In' : 'تسجيل الدخول' }}
                </button>

                <div class="text-center fs-7 text-muted">
                    {{ $isEn ? "Don't have an account?" : 'ليس لديك حساب؟' }} <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #0A192F;">{{ $isEn ? 'Register New Account' : 'إنشاء حساب جديد' }}</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
