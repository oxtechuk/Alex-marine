@extends('layouts.app')

@section('title', 'تسجيل الدخول — أليكس مارين')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="alex-card p-4 mx-auto" style="max-width: 450px;">
            <div class="text-center mb-4">
                <i class="bi bi-person-lock text-primary fs-1"></i>
                <h3 class="fw-bold text-dark mt-2">تسجيل الدخول</h3>
                <p class="text-muted small">أدخل بيانات حسابك للمتابعة في بوابة العملاء</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="admin@alexmarine.com">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label small" for="remember">تذكر بيانات دخولي</label>
                </div>

                <button type="submit" class="btn btn-alex-primary w-100 btn-lg mb-3">تسجيل الدخول</button>

                <div class="text-center small text-muted">
                    ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">إنشاء حساب جديد</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
