@extends('layouts.admin')

@section('title', 'طلبات عروض الأسعار (RFQ) — لوحة الإدارة')
@section('page_title', 'إدارة طلبات عروض الأسعار (RFQ)')

@section('content')
<!-- 1. Header Banner & Quick Summary -->
<div class="card-luxury p-3 mb-4 bg-white">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-earmark-text-fill fs-4 text-gold"></i>
            <div>
                <h5 class="fw-extrabold text-navy m-0">سجل طلبات عروض الأسعار والمناقصات (RFQ)</h5>
                <small class="text-muted">تسعير الأصناف، تحويل العروض لأوامر شراء، ومتابعة العملاء بالبحث والفلترة</small>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-navy px-3 py-2 fs-7 rounded-pill">
                إجمالي النتائج: <strong class="text-gold ms-1">{{ $quotes->total() }}</strong>
            </span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-navy btn-sm rounded-pill px-3">
                <i class="bi bi-bag-check-fill me-1"></i> أوامر الشراء والمبيعات
            </a>
        </div>
    </div>
</div>

<!-- 2. Search & Filter Toolbar -->
<div class="card-luxury p-3 mb-4 bg-white">
    <form action="{{ route('admin.quotes.index') }}" method="GET" id="quotesFilterForm">
        <div class="row g-2 align-items-center">
            
            <!-- Quick Search Input -->
            <div class="col-lg-5 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search text-gold"></i></span>
                    <input type="text" name="search" id="quoteQuickSearch" class="form-control border-start-0 bg-light" value="{{ $search ?? '' }}" placeholder="بحث برقم الطلب (RFQ)، العميل، الشركة، الهاتف...">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-lg-3 col-md-3">
                <select name="status" class="form-select bg-light fw-semibold" onchange="document.getElementById('quotesFilterForm').submit()">
                    <option value="">جميع الحالات</option>
                    <option value="جديد" {{ ($status ?? '') === 'جديد' ? 'selected' : '' }}>⭐ جديد</option>
                    <option value="قيد المراجعة" {{ ($status ?? '') === 'قيد المراجعة' ? 'selected' : '' }}>⏳ قيد المراجعة</option>
                    <option value="مقبول" {{ ($status ?? '') === 'مقبول' ? 'selected' : '' }}>✅ مقبول</option>
                    <option value="ملغي" {{ ($status ?? '') === 'ملغي' ? 'selected' : '' }}>❌ ملغي</option>
                </select>
            </div>

            <!-- Branch Filter -->
            <div class="col-lg-3 col-md-3">
                <select name="branch_id" class="form-select bg-light fw-semibold" onchange="document.getElementById('quotesFilterForm').submit()">
                    <option value="">🏢 جميع الفروع</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ ($branchId ?? '') == $b->id ? 'selected' : '' }}>
                            {{ $b->name_ar }} ({{ $b->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-lg-1 col-md-12 d-flex gap-1">
                <button type="submit" class="btn btn-navy btn-sm rounded-pill w-100 fw-bold" title="بحث">
                    <i class="bi bi-search"></i>
                </button>
                @if(!empty($search) || !empty($status) || !empty($branchId))
                    <a href="{{ route('admin.quotes.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-2.5" title="إعادة ضبط">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>

<!-- 3. Quotes Table -->
<div class="card-luxury overflow-hidden">

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('quoteQuickSearch');
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
