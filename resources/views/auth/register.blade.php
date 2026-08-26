@extends('layouts.app')

@section('title', 'إنشاء حساب جديد — أليكس مارين')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="alex-card p-4 mx-auto" style="max-width: 520px;">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus text-primary fs-1"></i>
                <h3 class="fw-bold text-dark mt-2">حساب جديد للشركات والعملاء</h3>
                <p class="text-muted small">قم بالتسجيل لمتابعة طلبات عروض الأسعار السابقة وحالة التوريد</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">الاسم بالكامل <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="أدخل اسمك بالكامل">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">اسم الشركة / الجهة <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" class="form-control" required value="{{ old('company_name') }}" placeholder="شركة الملاحة الوطنية">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="name@company.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم الهاتف / الواتساب <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}" placeholder="+20 100 000 0000">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn btn-alex-gold w-100 btn-lg mb-3">إنشاء الحساب</button>

                <div class="text-center small text-muted">
                    لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
