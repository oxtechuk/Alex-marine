@extends('layouts.app')

@php
    $isEn = app()->getLocale() == 'en';
@endphp

@section('title', ($isEn ? 'Request for Quotation (RFQ) Cart' : 'سلة طلب عروض الأسعار (RFQ)') . ' — ' . ($isEn ? 'ALEX MARINE' : 'أليكس مارين'))

@section('content')
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <h1 class="fw-bold text-dark fs-2 mb-1">{{ $isEn ? 'Request for Quotation (RFQ)' : 'طلب عرض سعر (Request for Quotation)' }}</h1>
        <p class="text-muted m-0">{{ $isEn ? 'Review your selected items and submit your corporate details to receive an official certified price proposal.' : 'راجِع المنتجات المختارة في قائمتك وأدخل بيانات المؤسسة لإرسال طلب التسعير الرسمي' }}</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        @if(empty($cart))
            <div class="alex-card p-5 text-center my-4">
                <i class="bi bi-file-earmark-text text-muted fs-1 d-block mb-3"></i>
                <h3 class="fw-bold text-dark mb-2">{{ $isEn ? 'Your RFQ Quote List is Empty' : 'سلة طلب الأسعار فارغة' }}</h3>
                <p class="text-muted mb-4">{{ $isEn ? 'Explore our commercial marine products and supplies catalog to add items for an official quotation.' : 'قم بتصفح المنتجات وأضف الأصناف التي ترغب في الحصول على عرض سعر رسمي لها.' }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-alex-primary btn-lg">{{ $isEn ? 'Browse Products Catalog' : 'تصفح دليل المنتجات' }}</a>
            </div>
        @else
            <div class="row g-4">
                <!-- Cart Items Table -->
                <div class="col-lg-7">
                    <div class="alex-card p-4">
                        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-list-check text-primary me-2"></i> {{ $isEn ? 'Requested Items' : 'المنتجات المطلوبة' }} ({{ count($cart) }})</h4>
                        
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ $isEn ? 'Product' : 'المنتج' }}</th>
                                        <th style="width: 130px;">{{ $isEn ? 'Quantity' : 'الكمية' }}</th>
                                        <th style="width: 60px;">{{ $isEn ? 'Action' : 'إجراء' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $isEn ? ($item['name_en'] ?? $item['name_ar']) : $item['name_ar'] }}</div>
                                                <small class="text-muted">{{ $isEn ? 'Code: ' : 'كود: ' }}{{ $item['sku'] }} | {{ $item['category'] }}</small>
                                                @if(!empty($item['notes']))
                                                    <div class="small text-info mt-1"><i class="bi bi-info-circle me-1"></i> {{ $item['notes'] }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('quote.update') }}" method="POST" class="d-flex align-items-center gap-1">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                                    <input type="number" name="quantity" class="form-control form-control-sm text-center" value="{{ $item['quantity'] }}" min="1">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $isEn ? 'Update' : 'تحديث' }}"><i class="bi bi-arrow-clockwise"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('quote.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ $isEn ? 'Remove' : 'حذف' }}"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top flex-wrap gap-2">
                            <a href="{{ route('products.index') }}" class="text-primary text-decoration-none fw-semibold">
                                <i class="bi bi-plus-circle me-1"></i> {{ $isEn ? 'Add More Products' : 'إضافة منتجات أخرى' }}
                            </a>
                            <small class="text-muted">{{ $isEn ? 'Prices & delivery terms will be prepared by our sales engineering department.' : 'ملاحظة: سيتم احتساب الأسعار وإصدار PDF من لوحة الإدارة' }}</small>
                        </div>
                    </div>
                </div>

                <!-- Customer Details Form -->
                <div class="col-lg-5">
                    <div class="alex-card p-4">
                        <h4 class="fw-bold text-dark mb-4"><i class="bi bi-building text-primary me-2"></i> {{ $isEn ? 'Company & RFQ Details' : 'بيانات الشركة والطلب' }}</h4>

                        <form action="{{ route('quote.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ $isEn ? 'Contact Person / Procurement' : 'اسم المسؤول / المشتريات' }} <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control" required value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}" placeholder="{{ $isEn ? 'e.g. John Doe' : 'أدخل اسمك بالكامل' }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ $isEn ? 'Company / Organization' : 'اسم الشركة / المؤسسة' }} <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" required value="{{ Auth::check() ? Auth::user()->company_name : old('company_name') }}" placeholder="{{ $isEn ? 'e.g. Red Sea Shipping Agency' : 'مثال: شركة البحر الأحمر للملاحة' }}">
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ $isEn ? 'Email' : 'البريد الإلكتروني' }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required value="{{ Auth::check() ? Auth::user()->email : old('email') }}" placeholder="name@company.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ $isEn ? 'Phone / Mobile' : 'رقم الهاتف' }} <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" required value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}" placeholder="+20 100 000 0000">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">{{ $isEn ? 'Order Notes / Delivery Port Requirements' : 'ملاحظات الطلب أو شروط التسليم' }}</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="{{ $isEn ? 'Enter port delivery berth, vessel name, or specific supply requirements...' : 'أدخل أي ملاحظات إضافية بخصوص مكان التسليم أو جدول التوريد...' }}"></textarea>
                            </div>

                            <button type="submit" class="btn btn-alex-gold btn-lg w-100 fw-bold">
                                {{ $isEn ? 'Submit RFQ Quotation Request' : 'إرسال طلب عرض السعر' }} <i class="bi bi-send-fill ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
