@extends('layouts.app')

@section('title', 'سلة طلب عروض الأسعار (RFQ) — أليكس مارين')

@section('content')
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <h1 class="fw-bold text-dark fs-2 mb-1">طلب عرض سعر (Request for Quotation)</h1>
        <p class="text-muted m-0">راجِع المنتجات المختارة في قائمتك وأدخل بيانات المؤسسة لإرسال طلب التسعير الرسمي</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        @if(empty($cart))
            <div class="alex-card p-5 text-center my-4">
                <i class="bi bi-file-earmark-text text-muted fs-1 d-block mb-3"></i>
                <h3 class="fw-bold text-dark mb-2">سلة طلب الأسعار فارغة</h3>
                <p class="text-muted mb-4">قم بتصفح المنتجات وأضف الأصناف التي ترغب في الحصول على عرض سعر رسمي لها.</p>
                <a href="{{ route('products.index') }}" class="btn btn-alex-primary btn-lg">تصفح دلال المنتجات</a>
            </div>
        @else
            <div class="row g-4">
                <!-- Cart Items Table -->
                <div class="col-lg-7">
                    <div class="alex-card p-4">
                        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-list-check text-primary me-2"></i> المنتجات المطلوبة ({{ count($cart) }})</h4>
                        
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>المنتج</th>
                                        <th style="width: 130px;">الكمية</th>
                                        <th style="width: 60px;">إجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $item['name_ar'] }}</div>
                                                <small class="text-muted">كود: {{ $item['sku'] }} | {{ $item['category'] }}</small>
                                                @if(!empty($item['notes']))
                                                    <div class="small text-info mt-1"><i class="bi bi-info-circle me-1"></i> {{ $item['notes'] }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('quote.update') }}" method="POST" class="d-flex align-items-center gap-1">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <input type="number" name="quantity" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}" min="1">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="تحديث"><i class="bi bi-arrow-clockwise"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('quote.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <a href="{{ route('products.index') }}" class="text-primary text-decoration-none fw-semibold">
                                <i class="bi bi-plus-circle me-1"></i> إضافة منتجات أخرى
                            </a>
                            <small class="text-muted">ملاحظة: سيتم احتساب الأسعار وإصدار PDF من لوحة الإدارة</small>
                        </div>
                    </div>
                </div>

                <!-- Customer Details Form -->
                <div class="col-lg-5">
                    <div class="alex-card p-4">
                        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-building text-primary me-2"></i> بيانات الشركة والطلب</h4>

                        <form action="{{ route('quote.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم المسؤول / المشتريات <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control" required value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" placeholder="أدخل اسمك بالكامل">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الشركة / المؤسسة <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" required value="{{ Auth::check() ? Auth::user()->company_name : old('company_name') }}" placeholder="مثال: شركة البحر الأحمر للملاحة">
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required value="{{ Auth::check() ? Auth::user()->email : old('email') }}" placeholder="name@company.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" required value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}" placeholder="+20 100 000 0000">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">ملاحظات الطلب أو شروط التسليم</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="أدخل أي ملاحظات إضافية بخصوص مكان التسليم أو جدول التوريد..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-alex-gold btn-lg w-100 fw-bold">
                                إرسال طلب عرض السعر <i class="bi bi-send-fill ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
