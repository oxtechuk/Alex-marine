@extends('layouts.admin')

@section('title', 'طلبات عروض الأسعار (RFQ) — لوحة الإدارة')
@section('page_title', 'إدارة طلبات عروض الأسعار (RFQ)')

@section('content')
<div class="card-luxury overflow-hidden">
    <div class="p-3 bg-white border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-text-fill fs-4 text-gold"></i>
            <div>
                <h5 class="fw-extrabold text-navy m-0">سجل طلبات عروض الأسعار والمناقصات (RFQ)</h5>
                <small class="text-muted">تسعير الأصناف، تحويل العروض لأوامر شراء، ومتابعة العملاء</small>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-luxury align-middle m-0">
            <thead>
                <tr>
                    <th>رقم الطلب (RFQ)</th>
                    <th>الشركة / العميل</th>
                    <th>المسؤول</th>
                    <th>الهاتف / واتساب</th>
                    <th>التاريخ</th>
                    <th>الحالة</th>
                    <th>الإجمالي التقديري</th>
                    <th class="text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotes as $q)
                    @php
                        $waMsg = "مرحباً " . ($q->customer_name ?: 'عزيزنا العميل') . "، بخصوص طلب عرض السعر رقم (" . $q->quote_number . ") لدى أليكس مارين للمهمات البحرية.";
                        $waUrl = \App\Helpers\WhatsAppHelper::link($q->phone, $waMsg);
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.quotes.show', $q->id) }}" class="fw-extrabold text-navy text-decoration-none">
                                {{ $q->quote_number }}
                            </a>
                        </td>
                        <td>
                            <strong class="text-navy">{{ $q->company_name ?: 'عميل مباشر' }}</strong>
                        </td>
                        <td>
                            <span class="text-dark">{{ $q->customer_name ?: '—' }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span dir="ltr" class="fw-semibold text-dark">{{ $q->phone ?: '—' }}</span>
                                @if(!empty($q->phone))
                                    <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب فورية">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="text-muted fs-8">
                            <i class="bi bi-clock-history me-1"></i>{{ $q->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            <span class="badge {{ $q->status == 'جديد' ? 'badge-gold' : ($q->status == 'مقبول' ? 'bg-success' : 'badge-navy') }} rounded-pill px-2.5 py-1">
                                {{ $q->status }}
                            </span>
                        </td>
                        <td>
                            <strong class="text-navy fs-6">
                                {{ $q->total_estimated ? number_format($q->total_estimated, 2) . ' ج.م' : '—' }}
                            </strong>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.quotes.show', $q->id) }}" class="btn btn-sm btn-navy rounded-pill px-3">
                                <i class="bi bi-tag-fill text-gold me-1"></i> التفاصيل والتسعير
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-gold"></i>
                            لا توجد طلبات عروض أسعار مسجلة.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($quotes->hasPages())
        <div class="p-3 bg-white border-top d-flex justify-content-center">
            {{ $quotes->links() }}
        </div>
    @endif
</div>
@endsection
