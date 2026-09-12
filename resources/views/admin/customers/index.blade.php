@extends('layouts.admin')

@section('title', 'دليل وسجلات العملاء — أليكس مارين')
@section('page_title', 'دليل العملاء والحسابات (Customers)')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-extrabold text-navy mb-1">دليل وقاعدة بيانات العملاء</h4>
        <small class="text-muted">العملاء والشركات المسجلة مع إمكانية التواصل الفوري عبر الواتساب والبحث المتقدم</small>
    </div>
    
    <div class="d-flex align-items-center gap-2">
        <span class="badge badge-navy px-3 py-2 fs-7 rounded-pill">
            إجمالي النتائج: <strong class="text-gold ms-1">{{ $customers->total() }}</strong>
        </span>
        <button type="button" class="btn btn-gold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-person-plus-fill me-1"></i> تسجيل عميل جديد
        </button>
    </div>
</div>

<!-- Search & Filter Toolbar -->
<div class="card-luxury p-3 mb-4 bg-white">
    <form action="{{ route('admin.customers.index') }}" method="GET" id="customersFilterForm">
        <div class="row g-2 align-items-center">
            
            <!-- Quick Search Input -->
            <div class="col-lg-5 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search text-gold"></i></span>
                    <input type="text" name="search" id="customerQuickSearch" class="form-control border-start-0 bg-light" value="{{ $search ?? '' }}" placeholder="بحث سريع بالاسم، الشركة، الهاتف، أو البريد...">
                </div>
            </div>

            <!-- Orders Activity Filter -->
            <div class="col-lg-3 col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-funnel"></i></span>
                    <select name="orders_filter" class="form-select border-start-0 bg-light fw-semibold" onchange="document.getElementById('customersFilterForm').submit()">
                        <option value="">جميع العملاء</option>
                        <option value="has_orders" {{ ($ordersFilter ?? '') === 'has_orders' ? 'selected' : '' }}>لديهم أوامر شراء سابقة</option>
                        <option value="no_orders" {{ ($ordersFilter ?? '') === 'no_orders' ? 'selected' : '' }}>عملاء جدد / بدون طلبات</option>
                    </select>
                </div>
            </div>

            <!-- Sorting Select -->
            <div class="col-lg-2 col-md-3">
                <select name="sort" class="form-select bg-light fw-semibold" onchange="document.getElementById('customersFilterForm').submit()">
                    <option value="latest" {{ ($sort ?? '') === 'latest' ? 'selected' : '' }}>الأحدث تسجيلاً</option>
                    <option value="highest_spent" {{ ($sort ?? '') === 'highest_spent' ? 'selected' : '' }}>الأعلى إنفاقاً</option>
                    <option value="most_orders" {{ ($sort ?? '') === 'most_orders' ? 'selected' : '' }}>الأكثر طلباً</option>
                    <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>أبجدياً (أ-ي)</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-navy btn-sm rounded-pill px-3 fw-bold flex-grow-1">
                    <i class="bi bi-search me-1"></i> بحث
                </button>
                @if(!empty($search) || !empty($ordersFilter) || (!empty($sort) && $sort !== 'latest'))
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="إعادة تعيين">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>

<!-- Customers Directory Table -->
<div class="card-luxury overflow-hidden">
    <div class="table-responsive">
        <table class="table table-luxury align-middle m-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم العميل / الشركة</th>
                    <th>رقم الهاتف / واتساب</th>
                    <th>البريد الإلكتروني</th>
                    <th class="text-center">أوامر الشراء</th>
                    <th class="text-center">عروض الأسعار</th>
                    <th>إجمالي المشتريات</th>
                    <th>تاريخ التسجيل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    @php
                        $waMsg = "مرحباً " . $customer->name . "، نتواصل معكم من شركة أليكس مارين للمهمات والخدمات البحرية.";
                        $waUrl = \App\Helpers\WhatsAppHelper::link($customer->phone, $waMsg);
                    @endphp
                    <tr>
                        <td class="fw-bold text-muted">#{{ $customer->id }}</td>
                        <td>
                            <div class="fw-extrabold text-navy fs-6">{{ $customer->name }}</div>
                            @if($customer->company_name)
                                <span class="badge badge-navy mt-1"><i class="bi bi-building me-1"></i>{{ $customer->company_name }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($customer->phone)
                                    <span dir="ltr" class="fw-semibold text-dark">{{ $customer->phone }}</span>
                                    <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp-icon" title="محادثة واتساب مباشرة">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @else
                                    <span class="text-muted fs-8">غير مسجل</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="fs-7 text-muted">{{ $customer->email }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-navy rounded-pill px-3 py-1.5 fs-7">{{ $customer->orders_count ?? 0 }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-gold rounded-pill px-3 py-1.5 fs-7">{{ $customer->quote_requests_count ?? 0 }}</span>
                        </td>
                        <td>
                            <span class="fw-extrabold text-navy fs-6">
                                {{ number_format($customer->orders_sum_total_amount ?? 0, 2) }} ج.م
                            </span>
                        </td>
                        <td class="fs-8 text-muted">
                            {{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-2 text-gold"></i>
                            لا يوجد عملاء مسجلين حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
        <div class="p-3 bg-white border-top d-flex justify-content-center">
            {{ $customers->links() }}
        </div>
    @endif
</div>

<!-- Modal: Add New Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-navy text-white p-3">
                <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-plus-fill me-2 text-gold"></i>تسجيل عميل جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.customers.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-navy fs-7">اسم العميل / المسؤول <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: شركة الملاحة أو قبطان أحمد" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy fs-7">رقم الهاتف / واتساب</label>
                            <input type="text" name="phone" class="form-control" placeholder="010XXXXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy fs-7">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" placeholder="client@domain.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-navy fs-7">اسم الشركة / السفينة</label>
                        <input type="text" name="company_name" class="form-control" placeholder="اختياري">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-navy fs-7">العنوان / الميناء</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="المدينة، الميناء، الرصيف..."></textarea>
                    </div>
                </div>

                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-gold rounded-pill px-4 fw-bold">حفظ العميل</button>
                </div>
            </form>
        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('customerQuickSearch');
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
