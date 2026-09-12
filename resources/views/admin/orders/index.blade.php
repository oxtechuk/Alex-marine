@extends('layouts.admin')

@section('title', 'أوامر الشراء والمبيعات — لوحة الإدارة')
@section('page_title', 'إدارة أوامر الشراء والمبيعات (Orders)')

@section('content')
<!-- 1. Header Banner & Quick Summary -->
<div class="card-luxury p-3 mb-4 bg-white">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-bag-check-fill fs-4 text-gold"></i>
            <div>
                <h5 class="fw-extrabold text-navy m-0">سجل أوامر الشراء والفواتير والمبيعات</h5>
                <small class="text-muted">عرض تفاصيل الطلبات، البحث السريع، الفلترة حسب الحالة والفرع والتحصيل</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-navy px-3 py-2 fs-7 rounded-pill">
                إجمالي النتائج: <strong class="text-gold ms-1">{{ $orders->total() }}</strong>
            </span>
            <a href="{{ route('admin.quotes.index') }}" class="btn btn-outline-navy btn-sm rounded-pill px-3">
                <i class="bi bi-file-earmark-text me-1"></i> طلبات عروض الأسعار
            </a>
        </div>
    </div>
</div>

<!-- 2. Search & Filter Toolbar -->
<div class="card-luxury p-3 mb-4 bg-white">
    <form action="{{ route('admin.orders.index') }}" method="GET" id="ordersFilterForm">
        <div class="row g-2 align-items-center">
            
            <!-- Quick Search Input -->
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search text-gold"></i></span>
                    <input type="text" name="search" id="orderQuickSearch" class="form-control border-start-0 bg-light" value="{{ $search ?? '' }}" placeholder="بحث برقم الأمر، العميل، الهاتف...">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-lg-2 col-md-3">
                <select name="status" class="form-select bg-light fw-semibold" onchange="document.getElementById('ordersFilterForm').submit()">
                    <option value="">جميع الحالات</option>
                    <option value="قيد التجهيز" {{ ($status ?? '') === 'قيد التجهيز' ? 'selected' : '' }}>⏳ قيد التجهيز</option>
                    <option value="مكتمل" {{ ($status ?? '') === 'مكتمل' ? 'selected' : '' }}>✅ مكتمل</option>
                    <option value="تم الشحن" {{ ($status ?? '') === 'تم الشحن' ? 'selected' : '' }}>🚚 تم الشحن</option>
                    <option value="ملغي" {{ ($status ?? '') === 'ملغي' ? 'selected' : '' }}>❌ ملغي</option>
                </select>
            </div>

            <!-- Branch Filter -->
            <div class="col-lg-3 col-md-3">
                <select name="branch_id" class="form-select bg-light fw-semibold" onchange="document.getElementById('ordersFilterForm').submit()">
                    <option value="">🏢 جميع الفروع</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ ($branchId ?? '') == $b->id ? 'selected' : '' }}>
                            {{ $b->name_ar }} ({{ $b->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Payment Status Filter -->
            <div class="col-lg-2 col-md-6">
                <select name="payment_status" class="form-select bg-light fw-semibold" onchange="document.getElementById('ordersFilterForm').submit()">
                    <option value="">طريقة الدفع</option>
                    <option value="نقدي" {{ ($paymentStatus ?? '') === 'نقدي' ? 'selected' : '' }}>نقدي / كاش</option>
                    <option value="آجل / حسب الاتفاق" {{ ($paymentStatus ?? '') === 'آجل / حسب الاتفاق' ? 'selected' : '' }}>آجل / اتفاق</option>
                    <option value="تحويل بنكي" {{ ($paymentStatus ?? '') === 'تحويل بنكي' ? 'selected' : '' }}>تحويل بنكي</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-lg-1 col-md-6 d-flex gap-1">
                <button type="submit" class="btn btn-navy btn-sm rounded-pill w-100 fw-bold" title="بحث">
                    <i class="bi bi-search"></i>
                </button>
                @if(!empty($search) || !empty($status) || !empty($branchId) || !empty($paymentStatus))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-2.5" title="إعادة ضبط">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>

<!-- 3. Orders Table -->
<div class="card-luxury overflow-hidden">

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('orderQuickSearch');
    const tableRows = document.querySelectorAll('.table-luxury tbody tr');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            if (!query) {
                tableRows.forEach(row => row.style.display = '');
                return;
            }

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
</script>

@endsection
