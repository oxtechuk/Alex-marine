@extends('layouts.admin')

@section('title', 'أوامر الشراء والمبيعات — لوحة الإدارة')
@section('page_title', 'إدارة أوامر الشراء والمبيعات (Orders)')

@section('content')
<div class="card-luxury overflow-hidden">
    <div class="p-3 bg-white border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bag-check-fill fs-4 text-gold"></i>
            <div>
                <h5 class="fw-extrabold text-navy m-0">سجل أوامر الشراء والفواتير والمبيعات</h5>
                <small class="text-muted">عرض تفاصيل الطلبات، تعديل الأسعار، ومتابعة التحصيل وإتمام البيع المباشر</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-navy px-3 py-2 fs-7 rounded-pill">
                إجمالي الأوامر: <strong class="text-gold ms-1">{{ $orders->total() }}</strong>
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-luxury align-middle m-0">
            <thead>
                <tr>
                    <th>رقم الأمر</th>
                    <th>الشركة / العميل</th>
                    <th>رقم الهاتف / واتساب</th>
                    <th>التاريخ والوقت</th>
                    <th>الحالة</th>
                    <th>طريقة الدفع</th>
                    <th>الإجمالي المستحق</th>
                    <th class="text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    @php
                        $waMsg = "مرحباً " . ($o->customer_name ?: 'عزيزنا العميل') . "، بخصوص أمر الشراء رقم (" . $o->order_number . ") لدى أليكس مارين للمهمات البحرية.";
                        $waUrl = \App\Helpers\WhatsAppHelper::link($o->phone, $waMsg);
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="fw-extrabold text-navy text-decoration-none">
                                {{ $o->order_number }}
                            </a>
                        </td>
                        <td>
                            <strong class="text-navy d-block">{{ $o->customer_name ?: 'عميل نقدي' }}</strong>
                            @if($o->company_name)
                                <small class="text-muted"><i class="bi bi-building me-1"></i>{{ $o->company_name }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span dir="ltr" class="fw-semibold text-dark">{{ $o->phone ?: '—' }}</span>
                                @if(!empty($o->phone))
                                    <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب فورية">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td class="text-muted fs-8">
                            <i class="bi bi-clock-history me-1"></i>{{ $o->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td>
                            <span class="badge {{ str_contains($o->status, 'مكتمل') ? 'bg-success' : 'badge-gold' }} rounded-pill px-2.5 py-1">
                                {{ $o->status }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-navy rounded-pill px-2.5 py-1">
                                {{ $o->payment_status ?: 'غير محدد' }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-extrabold text-navy fs-6">{{ number_format($o->total_amount, 2) }} ج.م</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.orders.show', $o->id) }}" class="btn btn-sm btn-navy rounded-pill px-3">
                                <i class="bi bi-pencil-square text-gold me-1"></i> إدارة وتعديل
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-gold"></i>
                            لا توجد أوامر شراء مسجلة حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="p-3 bg-white border-top d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
